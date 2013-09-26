<?php
/**
 * 生成可战斗对象
 * review by lishengwei
 * **/

class Fightable {

	//1为休息状态，后续的状态id应该为2, 4, 8, 16, 32...
	const STATUS_SLEEP = 1;

	//战斗对象的身份信息
	protected $identity;

	//战斗对象的等级
	protected $level;

	//基本属性和成长属性(各种装备，加成后的)
	protected $attributes;

	//包括技能等级，释放概率
	protected $skills;
    protected $skillIds = array();

    //记录当前各种状态的和 0为正常状态，
	protected $status;

	protected $current_blood;
	protected $current_magic;

	protected $last_attack_skill;
	protected $last_defense_skill;

	//记录上次攻击是否产生暴击
	protected $last_is_bj;
	//记录上次攻击产生的反击伤害
	protected $last_beat_back;
    protected $is_miss;

    protected $fight;
    protected $isSleep;


    protected $attackAction = 'attack';
    protected $defenseAction = 'defense';

    /**
	 * 初始化一个可战斗对象
	 *
	 * $attributes = array(:attribute_id => :attribute_value, ...);
	 * $skills = array(
	 * 		'attack' => array('list' => array(:skill_id => :skill_level, ...), 'rate' => :attack_rate),
	 * 		'defense' => array('list' => array(:skill_id => :skill_level, ...), 'rate' => :defense_rate),
	 * 		'passive' => array('list' => array(:skill_id => :skill_level, ...), 'rate' => null),
	 * );
	 *
	 * @param int $level 	战斗对象级别
	 * @param array $attributes 战斗对象的所有属性(包括各种装备，技能加成后的最终基本属性和成长属性)
	 * @param array $skills 	战斗对象的所有技能(分别包括进攻，防御，及被动技能的技能等级列表及释放概率)
	 * @param mixed $skills 	战斗对象的身份信息(此参数将会记录到战斗过程中)
	 */
	public function __construct($level, $attributes, $skills, $identity = null) {
		$this->level        = $level;
		$this->attributes   = $attributes;
		$this->skills       = $skills;
		$this->identity     = $identity;
        $this->status       = 0;
        if(is_array($this->skills) && count($this->skills)) {
            foreach ($this->skills as $skillGroup) {
                if(is_array($skillGroup['list']) && count($skillGroup['list'])) {
                    foreach ($skillGroup['list'] as $skillId =>$skillLevel) {
                        $this->skillIds[$skillId] = $skillLevel;
                    }
                }
            }
        }
		$this->current_blood = $this->attributes[ConfigDefine::USER_ATTRIBUTE_BLOOD];
		$this->current_magic = $this->attributes[ConfigDefine::USER_ATTRIBUTE_MAGIC];
	}

	public function isAlive() {
		return $this->current_blood > 0;
	}

	public function isDead() {
		return ! $this->isAlive();
	}

	public function isStatus() {
		return $this->status;
	}

	public function setStatus() {
		$this->status = 1;
	}

	public function unsetStatus() {
		$this->status = 0;
	}

	public function clearLastInfo() {
		$this->last_attack_skill = NULL;
        $this->fight = NULL;
        $this->isSleep = 0;
	}

	public function getCurrentBlood() {
		return $this->current_blood;
	}

	public function getCurrentMagic() {
		return $this->current_magic;
	}

	// 出手速度
	public function speed() {
		$rand_rate = PerRand::getRandValue(array(0.95, 1.05));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_SPEED] * $rand_rate;
	}

	// 被攻击速度
	public function attackedSpeed() {
		$rand_rate = PerRand::getRandValue(array(0.5, 1.5));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_SPEED] * $rand_rate;
	}

	public function reportAttack() {
		return array(
			'attacker'      => $this->identity['marking'],
			'skill'         => $this->last_attack_skill,
			'status'        => $this->isSleep,
			'attacker_blood' => $this->current_blood,
			'attacker_magic' => $this->current_magic,
            'fight'         => $this->fight,
            'attack_indentity'     => $this->identity,
		);
	}

	public function reportDefense() {
		return array(
			'target'        => $this->identity['marking'],
			'target_blood' => $this->current_blood,
			'target_magic' => $this->current_magic,
            'target_indentity' => $this->identity,
		);
	}

    public function getInfo() {
        return $this->identity;
    }

    //进行一次回合
    public function doOneRound(Fightable $target) {
        //新一轮攻击前清除上次攻击和防御时的记录信息
		$this->clearLastInfo();
		$target->clearLastInfo();
		if ($this->isDead() || $target->isDead()) {
			return FALSE;
		}
		/**
         * 休息状态下，此回合结束
         * @todo 如何返回结构
         * **/
		if ($this->isStatus()) {
            $this->isSleep = 1;
			$this->unsetStatus();
			return TRUE;
		}
        $skillId        = $this->randAttackSkill();
        if(Skill::isMagicSkill($skillId)) {
            $attackData         = $this->magicAttack($skillId);
            $attackSkillType    = array_pop($attackData);
        } else {
            $attackData         = $this->physicAttack($skillId);
            $attackSkillType    = array_pop($attackData);
        }
        $attackTimes            = Skill::getAttactTimes($skillId);
        if($attackTimes <= 0) {
            return FALSE;
        }
        $targetData = $target->doDefense($attackSkillType, $attackTimes);
        $defenseSkillIds = array_keys($targetData['skill_ids']);
        $harmRes    = Skill::userSkillTest($attackData, $targetData);
        foreach ((array)$harmRes as $key => $harmInfo) {
            $this->fight[$key] = array(
                'is_miss'   => 1,
                'is_bj'     => $harmInfo['is_double'],
                'fy_skill'  => $defenseSkillIds[$key] > 100 ? $defenseSkillIds[$key] : 0,
                'harm'      => $harmInfo['hurt'],
            );
            if($attackSkillType == 'magic') {
                if($this->magicHit() - $target->magicDodge() >= 1) {
                    $this->fight[$key]['is_miss'] = 0;
                    $target->current_blood = $target->current_blood - $harmInfo['hurt'];
                }
            } else {
                if($this->physicHit() - $target->physicDodge() >= 1) {
                    $this->fight[$key]['is_miss'] = 0;
                    $target->current_blood = $target->current_blood - $harmInfo['hurt'];
                }
            }
            if($target->current_blood <= 0) {
                return TRUE;
            }
            //防御技能使用了反击
            if($defenseSkillIds[$key] == ConfigDefine::SKILL_FJ) {
                $fjAttackData = $target->makeSkillData(ConfigDefine::SKILL_PT, 0, 'physic');
                $fjTargetData = $this->doDefense('physic');
                $fjHarmInfo   = Skill::userSkillTest($fjAttackData, $fjTargetData);
                //暂时不做反击的命中、闪避判断。如果反击，直接命中
//                $this->fight['is_fj'] = 1;
//                $this->fight['fj_bj'] = $fjHarmInfo['is_double'];
//                $this->fight['fj_miss'] = 1;
//                if($target->physicHit() - $this->physicDodge() >= 1) {
//                $this->fight['fj_miss'] = 0;
                $fjHarm = $fjHarmInfo['is_double'] ? $fjHarmInfo['hurt']/2 : $fjHarmInfo['huit'];
                $this->current_blood = $this->current_blood - $fjHarm;
//                }
                $this->fight[$key]['fj_harm'] = $fjHarm;
            }
        }
        //连击时设置状态为虚弱
        if($attackData['skill_id'] == ConfigDefine::SKILL_LJ) {
            $this->setStatus();
        }
        return TRUE;
    }

    protected function makeSkillData($skillId, $skillLevel,$type) {
        return array(
            'attributes'    => $this->attributes,
            'skill_id'      => intval($skillId),
            'skill_level'   => intval($skillLevel),
            'user_level'    => $this->level,
            'have_skillids' => $this->skillIds,
            'type'          => $type,
        );
    }

    //开动法术攻击, 返回伤害值
	protected function magicAttack($skillId) {
		$magic = Skill::getSkillMagic($skillId);
		//当魔法不足时，改用物理普通攻击
		if ($this->current_magic < $magic) {
			return $this->physicAttack(ConfigDefine::SKILL_PT);
		}
        $skillLevel = $skillId > 0 ? $this->skills['attack']['list'][$skillId] : 0;
		$this->current_magic -= $magic;
        return $this->makeSkillData($skillId, $skillLevel,'magic');
	}

	//开动物理攻击,返回伤害值
	protected function physicAttack($skillId) {
        $skillLevel = $skillId > 0 ? $this->skills['attack']['list'][$skillId] : 0;
        return $this->makeSkillData($skillId, $skillLevel,'physic');
	}

    protected function doDefense($attackSkillType = 'physic', $defenseTimes) {
        if($defenseTimes < 0)            return FALSE;
        for($i = 1; $i <= $defenseTimes; $i ++) {
            $skillId    = $this->randDefenseSkill($attackSkillType);
            if($skillId > 0) {
                $defenseSkillInfos[$skillId]  = $this->skills['defense']['list'][$skillId];
            }  else {
                $defenseSkillInfos[] = 0;
            }
        }
        return array(
            'attributes'    => $this->attributes,
            'skill_ids'     => $defenseSkillInfos,
            'user_level'    => $this->level,
            'have_skillids' => $this->skillIds,
        );
    }

    //法术命中
	public function magicHit() {
		$randRate = PerRand::getRandValue(array(0.5, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] * $randRate;
	}

	//法术躲闪
	public function magicDodge() {
		$randRate = PerRand::getRandValue(array(0.5, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] * $randRate;
	}

    //物理命中
	public function physicHit() {
		$rand_rate = PerRand::getRandValue(array(0.2, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_HIT] * $rand_rate;
	}

	//物理躲闪
	public function physicDodge() {
		$rand_rate = PerRand::getRandValue(array(0.7, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_DODGE] * $rand_rate;
	}

    //随机攻击技能
	protected function randAttackSkill() {
        $attackSkillId = $this->randSkill($this->skills['attack']['list'], $this->skills['attack']['rate']);
		return $this->last_attack_skill = $attackSkillId > 0 ? $attackSkillId : ConfigDefine::SKILL_PT;
	}

    //随机防御技能，防御技能释放需要根据攻击技能的类型来确定
	protected function randDefenseSkill($attackSkillType = 'physic') {
        $skillIds = $physicSkillIds = $magicSkillIds = array();
        if(is_array($this->skills['defense']['list']) && count($this->skills['defense']['list'])) {
            foreach ($this->skills['defense']['list'] as $skillId => $skillLevel) {
                if(Skill::isPhysicDefense($skillId)) {
                    $physicSkillIds[$skillId] = $skillLevel;
                } elseif(Skill::isMagicDefense($skillId)) {
                    $magicSkillIds[$skillId] = $skillLevel;
                }
            }
        }
        $skillIds = $attackSkillType == 'physic' ? $physicSkillIds : $magicSkillIds;
        return $this->last_defense_skill = $this->randSkill($skillIds, $this->skills['defense']['rate']);
	}

    protected function randSkill($skill_list, $skill_rate) {
		if (empty($skill_list)) {
			return false;
		}
		$rand = mt_rand(0, 99);
		if ($rand > ($skill_rate * 100)) {
			return false;
		}
		return array_rand($skill_list);
	}
}