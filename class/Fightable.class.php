<?php
class Fightable {

	//等级
	protected $level;

	//基本属性和成长属性(各种装备，加成后的)
	protected $attributes; 

	//包括技能等级，释放概率
	protected $skills;

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

	//打它
	public function attack(Fightable $user)
	{
		//死人是不会攻击的
		if ( ! $this->isAlive())
		{
			return;
		}

		//随机技能
		$skill_id = $this->randAttackSkill();

		//魔法攻击
		if (Skill::isMagicSkill($skill_id))
		{
			$harm = $this->magicAttack($skill_id, $user);
		}
		//物理攻击
		else
		{
			$harm = $this->physicAttack($skill_id, $user);
		}

		//成功命中
		if ($harm)
		{
			$beat_back = $user->defense($this, $skill_id, $harm);
			$this->current_blood -= $beat_back;
		}
	}

	//我顶
	public function defense(Fightable $attacker, $attack_skill, $attack_harm)
	{
		// 死人也不会防御
		if ( ! $this->isAlive())
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

		$defense_harm = Skill::doDefenseSkill($defense_skill, $attacker->getFightParameters(), $this->getFightParameters());

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

	// 速度上下浮动5%
	public function speed()
	{
		$rand_rate = PerRand::getRandValue(array(0.95, 1.05));
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
		$skill_ids = array();
		foreach($this->skills as $skills)
		{
			$skill_ids = array_merge($skill_ids, $skills['list']);
		}

		return array(
			'level' => $this->level,
			'attributes' => $this->attributes,
			'skills' => $skill_ids,
		);
	}

	//开动法术攻击, 返回伤害值
	protected function magicAttack($skill_id, Fightable $user)
	{
		$magic = Skill::getSkillMagic($skill_id);

		//当魔法不足时，改用物理普通攻击
		if ($this->current_magic < $magic)
		{
			return $this->physicAttack(false, $user);
		}

		$this->current_magic -= $magic;

		//检查是否命中
		if ($this->magicHit() - $user->magicDodge() >= 1)
		{
			return Skill::useSkill($skill_id, $this->getFightParameters(), $user->getFightParameters());
		}

		//没有命中，返回伤害值为0
		return 0;
	}

	//开动物理攻击,返回伤害值
	protected function physicAttack($skill_id, Fightable $user)
	{
		//检查命中
		if ($this->physicHit() - $user->physicDodge() >= 1)
		{
			return Skill::userSkill($skill_id, $this->getFightParameters(), $user->getFightParameters());
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
