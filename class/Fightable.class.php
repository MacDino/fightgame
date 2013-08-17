<?php
class Fightable {

	//等级
	protected $level;

	//基本属性和成长属性(各种装备，加成后的)
	protected $attributes; 

	//包括技能等级，释放概率
	protected $skills;

	protected $status_sleep;

	protected $current_blood;
	protected $current_magic;

	public function __construct($level, $attributes, $skills)
	{
		$this->level = $level;
		$this->attributes = $attributes;
		$this->skills = $skills;

		$this->current_blood = $this->attributes[ConfigDefine::USER_ATTRIBUTE_BLOOD];
		$this->current_magic = $this->attributes[ConfigDefine::USER_ATTRIBUTE_MAGIC];
	}

	public function isAlive()
	{
		return $this->current_blood > 0;
	}

	public function isDead()
	{
		return ! $this->isAlive();
	}

	public function isSleep()
	{
		return $this->status_sleep;
	}

	//打它
	public function attack(Fightable $target)
	{
		//死人是不会攻击的
		if ($this->isDead() || $target->isDead())
		{
			return;
		}

		//休息状态跳过
		if ( $this->isSleep())
		{
			$this->status_sleep = false;
			return;
		}

		//随机技能
		$skill_id = $this->randAttackSkill();

		//魔法攻击
		if (Skill::isMagicSkill($skill_id))
		{
			$harm = $this->magicAttack($skill_id, $target);
		}
		//物理攻击
		else
		{
			$harm = $this->physicAttack($skill_id, $target);
		}

		//成功命中
		if ($harm)
		{
			$beat_back = $target->defense($this, $skill_id, $harm);
			$this->current_blood -= $beat_back;
		}

		//连击后进入休息状态
		if (Skill::isLj($skill_id))
		{
			$this->status_sleep = true;
		}
	}

	//我顶
	public function defense(Fightable $attacker, $attack_skill, $attack_harm)
	{
		if ($this->isDead() || $attacker->isDead())
		{
			return 0;
		}

		$defense_skill = $this->randDefenseSkill();

		//木有防御技能  或者防御技能无效
		if (empty($defense_skill) 
			|| ! Skill::isSkillDefensable($attack_skill, $defense_skill))
		{
			$this->current_blood -= $attack_harm;
			return 0;
		}

		$defense_skill_level = $this->skills['defense'][$defense_skill];
		$defense_harm = Skill::doDefenseSkill($defense_skill, $defense_skill_level, $attacker->getFightParameters(), $this->getFightParameters());

		//反击防御技能, 不降低伤害值, 但回弹伤害
		if (Skill::isFj($defense_skill))
		{
			$this->current_blood -= $attack_harm;

			// 回弹伤害
			return $this->isAlive() ? $defense_harm : 0;
		}

		//普通防御技能,降低伤害值
		$this->current_blood -= max($attack_harm - $defense_harm, 0);
		return 0;
	}

	// 出手速度
	public function speed()
	{
		$rand_rate = PerRand::getRandValue(array(0.95, 1.05));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_SPEED] * $rand_rate;
	}

	// 被攻击速度
	public function attackedSpeed()
	{
		$rand_rate = PerRand::getRandValue(array(0.5, 1.5));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_SPEED] * $rand_rate;
	}

	//物理命中
	public function physicHit()
	{
		$rand_rate = PerRand::getRandValue(array(0.2, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_HIT] * $rand_rate;
	}

	//法术命中
	public function magicHit()
	{
		$rand_rate = PerRand::getRandValue(array(0.5, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] * $rand_rate;
	}

	//物理躲闪
	public function physicDodge()
	{
		$rand_rate = PerRand::getRandValue(array(0.7, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_DODGE] * $rand_rate;
	}

	//法术躲闪
	public function magicDodge()
	{
		$rand_rate = PerRand::getRandValue(array(0.5, 1.0));
		return $this->attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] * $rand_rate;
	}

	//获取使用技能所必须的参数
	public function getFightParameters()
	{
		$attributes = $this->attributes;
		if ($this->isSleep())
		{
			$attributes[ConfigDefine::USER_ATTRIBUTE_DEFENSE] *= 0.8;
		}

		return array(
			'level' => $this->level,
			'attributes' => $attributes,
		);
	}

	//开动法术攻击, 返回伤害值
	protected function magicAttack($skill_id, Fightable $target)
	{
		$magic = Skill::getSkillMagic($skill_id);

		//当魔法不足时，改用物理普通攻击
		if ($this->current_magic < $magic)
		{
			return $this->physicAttack(false, $target);
		}

		$this->current_magic -= $magic;

		//检查是否命中
		if ($this->magicHit() - $target->magicDodge() >= 1)
		{
			$skill_level = $this->skills['attack'][$skill_id];
			return Skill::useSkill($skill_id, $skill_level, $this->getFightParameters(), $target->getFightParameters());
		}

		//没有命中，返回伤害值为0
		return 0;
	}

	//开动物理攻击,返回伤害值
	protected function physicAttack($skill_id, Fightable $target)
	{
		//检查命中
		if ($this->physicHit() - $target->physicDodge() >= 1)
		{
			$skill_level = $skill_id ? $this->skills['attack'][$skill_id] : false;
			return Skill::useSkill($skill_id, $skill_level, $this->getFightParameters(), $target->getFightParameters());
		}

		return 0;
	}

	//随机攻击技能
	protected function randAttackSkill()
	{
		return $this->randSkill($this->skills['attack']['list'], $this->skills['attack']['rate']);
	}

	//随机防御技能
	protected function randDefenseSkill()
	{
		return $this->randSkill($this->skills['defense']['list'], $this->skills['defense']['rate']);
	}

	protected function randSkill($skill_list, $skill_rate)
	{
		if (empty($skill_list))
		{
			return false;
		}

		$rand = mt_rand(0, 99);
		if ($rand > ($skill_rate * 100))
		{
			return false;
		}

		return array_rand($skill_list);
	}
}
