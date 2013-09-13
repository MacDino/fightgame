<?php
class Monster
{
	CONST MONSTER_PREFIX_PUNY     = 1;//弱小的
	CONST MONSTER_PREFIX_SLOW     = 2;//缓慢的
	CONST MONSTER_PREFIX_ORDINARY = 3;//普通的
	CONST MONSTER_PREFIX_POWERFUL = 4;//强大的
	CONST MONSTER_PREFIX_QUICK    = 5;//敏捷的

	CONST MONSTER_SUFFIX_BOSS         = 1;//Boss
	CONST MONSTER_SUFFIX_SACRED       = 2;//神圣的
	CONST MONSTER_SUFFIX_UNKNOWN      = 3;//未知的
	CONST MONSTER_SUFFIX_ADVANCED     = 4;//进阶的
	CONST MONSTER_SUFFIX_WILL_EXTINCT = 5;//将要灭绝的
	CONST MONSTER_SUFFIX_CURSED       = 6;//被诅咒的
	CONST MONSTER_SUFFIX_ANCIENT      = 7;//远古的
	CONST MONSTER_SUFFIX_HEAD         = 8;//头头

	//获取杀死怪物获得的金钱，没有计算加成
	public static function getMonsterBaseMoney($level)
	{
		if(!$level || (int)$level < 1)return 0;
		$baseNum = ($level/10)*2*($level*(1 + 0.09))+3;
		$randBegin = $baseNum*(1 - 0.09);
		$randEnd = $baseNum*(1+0.09);
		$ration = Utility::getChangeIntRation(array($randBegin, $randEnd));
		$randValue = mt_rand($randBegin*$ration, $randEnd*$ration);
		return $randValue/$ration;
	}

	//获取杀死怪物获得的经验，没有计算加成
	public static function getMonsterBaseExperience($level)
	{
		return (float)41.4 + 10.33*(int)$level;
	}

	//获取某指定等级怪物的基本属性值,没有计算加成
	public static function getMonsterBaseAttribute($level)
	{
		$level = (int)$level;
		$totalBaseAttribute = Monster_Config::getMonsterBaseAttributeTotal($level);
		$userAttributeList  = Monster_Config::getMonsterBaseAttributeList($level);
		$useAttributeTotal  = array_sum($userAttributeList);
		if($useAttributeTotal >= $totalBaseAttribute)
		{
			return $userAttributeList;
		}
		$surplusAttribute = $totalBaseAttribute - $useAttributeTotal;
		return self::_randAttribute($surplusAttribute, $userAttributeList);
	}

	// 获取怪物的金钱(前后缀加成后)
	public static function getMonsterMoney($monster)
	{
		$base_money = self::getMonsterBaseMoney($monster['level']);
		$prefix_change = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'money_change');
		$suffix_change = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'money_change');

		return self::_multiply($base_money, 1+$prefix_change, 1+$suffix_change);
	}

	// 获取怪物的经验(前后缀加成后)
	public static function getMonsterExperience($monster)
	{
		$base_experience = self::getMonsterBaseExperience($monster['level']);
		$prefix_change = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'experience_change');
		$suffix_change = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'experience_change');

		return self::_multiply($base_experience, 1+$prefix_change, 1+$suffix_change);
	}

	// 获取怪物的属性(前后缀加成后)
	public static function getMonsterAttribute($monster)
	{
		$base_attribute = self::getMonsterBaseAttribute($monster['level']);
		$prefix_change = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'attribute_change_list');
		$suffix_change = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'attribute_change_list');

		$attribute =  Utility::arrayMultiply($base_attribute, $prefix_change, $suffix_change);
		$growup_attribute = User_Race::getGrowUpAttributes($monster['race_id'], $attribute);
		return $attribute + $growup_attribute;
	}

	// 获取怪物的装备顔色(前后缀加成后)
	public static function getMonsterEquipmentColor($monster)
	{
		$prefix_probability = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'equip_get_probability');
		$suffix_probability = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'equip_get_probability');

		return PerRand::getMultiRandResultKey(array($prefix_probability, $suffix_probability));
	}

	// 获取怪物的技能
	public static function getMonsterSkill($monster)
	{
		$map_skills_list = Map_Skill::getAllSkills($monster['map_id']);
		$must_skills_list = self::_getMustSkills($monster);
		$min_count_list = self::_getMinSkillCount($monster);
		$skill_rate_list = self::_getSkillRate($monster);

		$ret = array('attack' => array(), 'defense' => array(), 'passive' => array());
		foreach ($ret as $skill_type => &$skills)
		{
			$must_skills = isset($must_skills_list[$skill_type]) ? $must_skills_list[$skill_type] : array();

			//地图技能为空时直接返回必须技能
			if (empty($map_skills_list[$skill_type]))
			{
				$skills = $must_skills;
				continue;
			}

			//可选技能中去除必选的
			$map_skills =  array_diff($map_skills_list[$skill_type], $must_skills);

			//生成技能数范围
			$min_count = isset($min_count_list[$skill_type]) ? $min_count_list[$skill_type] : 0;
			$max_count = ($skill_type == 'passive') ? count($map_skills_list[$skill_type]) : 5;

			//随机技能数
			$skill_count = mt_rand($min_count, $max_count);

			//去除必选的技能数
			$skill_count = max($skill_count - count($must_skills), 0);

			//随机技能
			shuffle($map_skills);
			$rand_skills = array_slice($map_skills, 0, $skill_count);
			$rand_skills = array_flip(array_merge($rand_skills, $must_skills));

			$min_skill_level = max(1, $monster['level'] - 10);
			$max_skill_level = $monster['level'] + 10;

			//随机技能级别
			foreach ($rand_skills as &$skill_level)
			{
				$skill_level = mt_rand($min_skill_level, $max_skill_level);
			}

			$skills = array(
				'list' => $rand_skills,
			);

			if ($skill_type == 'passive')
			{
				continue;
			}

			//获取技能概率
			$rand_skill_count = count($rand_skills);
			$skills['rate'] = $skill_rate_list[$skill_type][$rand_skill_count];
		}

		return $ret;
	}

	public static function fightable($monster)
	{
		$skill = self::getMonsterSkill($monster);
		$attribute = self::getMonsterAttribute($monster, $skill);

		//技能加成后的属性
		$attribute = self::attributeWithSkill($attribute, $skill);

		return new Fightable($monster['level'], $attribute, $skill, array('monster_id' => $monster['monster_id']));
	}

	public static function attributeWithSkill($attribute, $skill)
	{
		$skill_list = array();
		foreach ($skill as $_skill)
		{
			$skill_list = array_merge($skill_list, $_skill['list']);
		}

		return Skill::getRoleAttributesWithSkill($attribute, $skill_list);
	}

	//多余属性随机分配
	private static function _randAttribute($surplusAttribute, $userAttributeList)
	{
		for($i=1;$i<=$surplusAttribute;$i++)
		{
			$key = array_rand($userAttributeList, 1);
			++$userAttributeList[$key];
		}
		return $userAttributeList;
	}

	private static function _multiply()
	{
		$args = array_filter(func_get_args(), 'is_numeric');
		return array_product($args);
	}

	private static function _getMustSkills($monster)
	{
		if ($monster['suffix'] == self::MONSTER_SUFFIX_BOSS)
		{
			return Map_Skill::getBossMustHave($monster['map_id']);
		}

		if ($monster['suffix'])
		{
			return Map_Skill::getSuffixMustHave($monster['map_id']);
		}

		return array();
	}

	private static function _getMinSkillCount($monster)
	{
		if ($monster['suffix'] == self::MONSTER_SUFFIX_BOSS)
		{
			return Map_Skill::getBossMinCount($monster['map_id']);
		}

		if ($monster['suffix'])
		{
			return Map_Skill::getSuffixMinCount($monster['map_id']);
		}

		return array();
	}

	private static function _getSkillRate($monster)
	{
		if ($monster['suffix'] == self::MONSTER_SUFFIX_BOSS)
		{
			return Map_Skill::getSkillRate('boss');
		}

		return Map_Skill::getSkillRate('not_boss');
	}
}
