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

		$this->current_blood = $this->attributes[ConfigDefine::USER_ATTRIBUTE_BLOOD];
		$this->current_magic = $this->attributes[ConfigDefine::USER_ATTRIBUTE_MAGIC];
	}

	public function isAlive() {
		return $this->current_blood > 0;
	}

	public function isDead() {
		return ! $this->isAlive();
	}

	public function isSleep() {
		return $this->status & self::STATUS_SLEEP;
	}

	public function setSleep() {
		$this->status |= self::STATUS_SLEEP;
	}

	public function unsetSleep() {
		$this->status &= ~self::STATUS_SLEEP;
	}

	public function clearLastInfo() {
		$this->last_attack_skill = null;
		$this->last_defense_skill = null;
		$this->last_beat_back = 0;
		$this->last_is_bj = false ;
	}

	public function getCurrentBlood() {
		return $this->current_blood;
	}

	public function getCurrentMagic() {
		return $this->current_magic;
	}

	//打它
	public function attack(Fightable $target) {
		//新一轮攻击前清除上次攻击和防御时的记录信息
		$this->clearLastInfo();
		$target->clearLastInfo();

		//记录攻击开始前目标血量，用于计算目标实际掉血量
		$target_blood_start = $target->getCurrentBlood();

		//死人是不会攻击的
		if ($this->isDead() || $target->isDead()) {
			return false;
		}

		//休息状态跳过
		if ( $this->isSleep()) {
			$this->unsetSleep();
			return false;
		}

		//随机技能
		$skill_id = $this->randAttackSkill();

		//魔法攻击
		if (Skill::isMagicSkill($skill_id)) {
			$harm = $this->magicAttack($skill_id, $target);
		} else {
            //物理攻击
			$harm = $this->physicAttack($skill_id, $target);
		}
		//成功命中
		if ($harm) {
			if ($this->randomBj()) {
				$harm *= 2;
			}
			$beat_back = $target->defense($this, $skill_id, $harm);
			$this->last_beat_back = $beat_back;
			$this->current_blood -= $beat_back;
		}

		//连击后进入休息状态
//		if (Skill::isLj($skill_id))没有此方法
		if (FALSE) {
			$this->setSleep();
		}

		$target_blood_end = $target->getCurrentBlood();
		return $target_blood_start - $target_blood_end;
	}

	//我顶
	public function defense(Fightable $attacker, $attack_skill, $attack_harm) {
		if ($this->isDead() || $attacker->isDead()) {
			return 0;
		}

		$defense_skill = $this->randDefenseSkill();

		//木有防御技能  或者防御技能无效
		if (empty($defense_skill) || ! Skill::isSkillDefensable($attack_skill, $defense_skill)) {
			$this->current_blood -= $attack_harm;
			return 0;
		}

		$defense_skill_level = $this->skills['defense'][$defense_skill];
		$defense_harm = Skill::doDefenseSkill($defense_skill, $defense_skill_level, $attacker->getFightParameters(), $this->getFightParameters());

		//反击防御技能, 不降低伤害值, 但回弹伤害
		if (Skill::isFj($defense_skill)) {
			$this->current_blood -= $attack_harm;

			// 回弹伤害
			return $this->isAlive() ? $defense_harm : 0;
		}

		//普通防御技能,降低伤害值
		$this->current_blood -= max($attack_harm - $defense_harm, 0);
		return 0;
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

	//物理命中
	public function physicHit() {
		$rand_rate = PerRand::getRandValue(array(0.2, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_HIT] * $rand_rate;
	}

	//法术命中
	public function magicHit() {
		$rand_rate = PerRand::getRandValue(array(0.5, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] * $rand_rate;
	}

	//物理躲闪
	public function physicDodge() {
		$rand_rate = PerRand::getRandValue(array(0.7, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_DODGE] * $rand_rate;
	}

	//法术躲闪
	public function magicDodge() {
		$rand_rate = PerRand::getRandValue(array(0.5, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] * $rand_rate;
	}

	//随机暴击概率5％
	public function randomBj() {
		$rand = mt_rand(0,99);
		return $this->last_is_bj = ($rand < 5);
	}

	//获取使用技能所必须的参数
	public function getFightParameters() {
		$attributes = $this->attributes;
		if ($this->isSleep()) {
			$attributes[ConfigDefine::USER_ATTRIBUTE_DEFENSE] *= 0.8;
		}

		return array(
			'level' => $this->level,
			'attributes' => $attributes,
		);
	}

	public function reportAttack() {
		return array(
			'identity' => $this->identity,
			'status' => $this->status,
			'current_blood' => $this->current_blood,
			'current_magic' => $this->current_magic,
			'skill' => $this->last_attack_skill,
			'is_bj' => $this->last_is_bj,
			'beat_back' => $this->last_beat_back,
		);
	}

	public function reportDefense() {
		return array(
			'identity' => $this->identity,
			'status' => $this->status,
			'current_blood' => $this->current_blood,
			'current_magic' => $this->current_magic,
			'skill' => $this->last_defense_skill,
		);
	}

    public function getInfo() {
        return $this->identity;
    }

    //开动法术攻击, 返回伤害值
	protected function magicAttack($skill_id, Fightable $target) {
		$magic = Skill::getSkillMagic($skill_id);

		//当魔法不足时，改用物理普通攻击
		if ($this->current_magic < $magic) {
			return $this->physicAttack(false, $target);
		}

		$this->current_magic -= $magic;

		//检查是否命中
		if ($this->magicHit() - $target->magicDodge() >= 1) {
			$skill_level = $this->skills['attack'][$skill_id];
			return Skill::useSkill($skill_id, $skill_level, $this->getFightParameters(), $target->getFightParameters());
		}

		//没有命中，返回伤害值为0
		return 0;
	}

	//开动物理攻击,返回伤害值
	protected function physicAttack($skill_id, Fightable $target) {
		//检查命中
		if ($this->physicHit() - $target->physicDodge() >= 1) {
			$skill_level = $skill_id ? $this->skills['attack'][$skill_id] : false;
			return Skill::useSkill($skill_id, $skill_level, $this->getFightParameters(), $target->getFightParameters());
		}

		return 0;
	}

	//随机攻击技能
	protected function randAttackSkill() {
		return $this->last_attack_skill = $this->randSkill($this->skills['attack']['list'], $this->skills['attack']['rate']);
	}

	//随机防御技能
	protected function randDefenseSkill() {
		return $this->last_defense_skill = $this->randSkill($this->skills['defense']['list'], $this->skills['defense']['rate']);
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