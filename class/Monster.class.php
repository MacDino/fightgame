<?php
class Monster
{
	CONST MONSTER_PREFIX_PUNY     = 3101;//弱小的
	CONST MONSTER_PREFIX_SLOW     = 3102;//缓慢的
	CONST MONSTER_PREFIX_ORDINARY = 3103;//普通的
	CONST MONSTER_PREFIX_POWERFUL = 3104;//强大的
	CONST MONSTER_PREFIX_QUICK    = 3105;//敏捷的

	CONST MONSTER_SUFFIX_BOSS         = 3201;//Boss
	CONST MONSTER_SUFFIX_SACRED       = 3202;//圣灵
	CONST MONSTER_SUFFIX_UNKNOWN      = 3203;//领主
	CONST MONSTER_SUFFIX_ADVANCED     = 3204;//巨魔
	CONST MONSTER_SUFFIX_WILL_EXTINCT = 3205;//将领
	CONST MONSTER_SUFFIX_CURSED       = 3206;//魔王
	CONST MONSTER_SUFFIX_ANCIENT      = 3207;//长老
	CONST MONSTER_SUFFIX_HEAD         = 3208;//头头

	/**
     * 获取杀死怪物获得的金钱，没有计算加成
     * review by lishengwei
     */
	public static function getMonsterBaseMoney($level) {
		if(!$level || (int)$level < 1)return 1;
		$baseNum = ($level/10)*2*($level*(1 + 0.09))+3;
		$randBegin = $baseNum*(1 - 0.09);
		$randEnd = $baseNum*(1+0.09);
		$ration = Utility::getChangeIntRation(array($randBegin, $randEnd));
		$randValue = mt_rand($randBegin*$ration, $randEnd*$ration);
		return $randValue/$ration;
	}

	/***
     * 获取杀死怪物获得的经验，没有计算加成
     * review by lishengwei
     */
	public static function getMonsterBaseExperience($level) {
		return (float)41.4 + 10.33*(int)$level;
	}

	/****
     * 获取某指定等级怪物的基本属性值,没有计算加成
     */
	public static function getMonsterBaseAttribute($level) {
		$level = (int)$level;
		$totalBaseAttribute = Monster_Config::getMonsterBaseAttributeTotal($level);
		$userAttributeList  = Monster_Config::getMonsterBaseAttributeList($level);
		$useAttributeTotal  = array_sum($userAttributeList);
		if($useAttributeTotal >= $totalBaseAttribute) {
			return $userAttributeList;
		}
		$surplusAttribute = $totalBaseAttribute - $useAttributeTotal;
		return self::_randAttribute($surplusAttribute, $userAttributeList);
	}

	/****
     * 获取怪物的金钱(前后缀加成后)
     * review by lishengwei
     */
	public static function getMonsterMoney($monster) {
		$base_money = self::getMonsterBaseMoney($monster['level']);
		$prefix_change = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'money_change');
		$suffix_change = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'money_change');
		return (int)self::_multiply($base_money, $prefix_change, $suffix_change);
	}

	/**
     *  获取怪物的经验(前后缀加成后)
     *  review by lishengwei
     * **/
	public static function getMonsterExperience($monster) {
		$base_experience = self::getMonsterBaseExperience($monster['level']);
		$prefix_change = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'experience_change');
		$suffix_change = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'experience_change');
		return (int)self::_multiply($base_experience, $prefix_change, $suffix_change);
	}

	/*
     * 统一计算怪物的基础属性以及成长属性
     * 获取怪物的属性(前后缀加成后)
     */
	public static function getMonsterAttribute($monster) {
		$base_attribute = self::getMonsterBaseAttribute($monster['level']);
        //附带前后缀的针对各个属性点的计算率
		$prefix_change      = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'attribute_change_list');
		$suffix_change      = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'attribute_change_list');
		$attribute          = Utility::arrayMultiply($base_attribute, $prefix_change, $suffix_change);
		$growup_attribute   = User_Race::getGrowUpAttributes($monster['race_id'], $attribute);
		return $attribute + $growup_attribute;
	}

	// 获取怪物的装备顔色(前后缀加成后)
	public static function getMonsterEquipmentColor($monster) {
		$prefix_probability = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'equip_get_probability');
		$suffix_probability = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'equip_get_probability');
		return PerRand::getMultiRandResultKey(array($prefix_probability, $suffix_probability));
	}

    public static function getMonsterEquipmentLevel($mapId) {
        $mapInfo        = Map_Config::getMapConfig($mapId);
        $maxEquipLevel  = $mapInfo['end_level'];
        $minEquipLevel  = $mapInfo['start_level'];
        if($minEquipLevel - 1 > 0) {
            $v = intval(($minEquipLevel-1)/10);
            $baseLevel = $v * 10;
        }  else {
            $baseLevel = 0;
        }
        $probability= PerRand::getRandResultKey(array(1 => 0.05,2 => 0.9,3 => 0.05));
        switch ($probability) {
            case 1:
                $equipmentLevel = $baseLevel - 10 > 0 ? $baseLevel - 10 : 0;
                break;
            case 3:
                $equipmentLevel = $baseLevel + 10;
                break;
            default :
                $equipmentLevel = $baseLevel;
                break;
        }
        return $equipmentLevel;
    }

    /**
     * 先去获取颜色，如果没有颜色，则不生成装备
     * 有一个颜色，就生成一个装备
     * 随即出来一个等级
     * **/
    public static function getMonsterEquipment($monster) {
        $color = self::getMonsterEquipmentColor($monster);
        if(is_array($color)) {
            foreach ($color as $equipmentColor) {
                if ($equipmentColor > 0) {
                    $equipment[] = array(
                        'equipment' => self::randomEquipment(),
                        'color'     => $equipmentColor,
                        'level'     => self::getMonsterEquipmentLevel($monster['map_id']),
                    );
                }
            }
        }
        return $equipment;
    }

    private static function randomEquipment() {
        //6件装备随即掉落
        return rand(1, 6);
    }

    // 获取怪物的技能
	public static function getMonsterSkill($monster) {
        //获取配置的技能列表
		$map_skills_list    = Map_Skill::getAllSkills($monster['map_id']);
		$must_skills_list   = self::_getMustSkills($monster);
		$min_count_list     = self::_getMinSkillCount($monster);
		$skill_rate_list    = self::_getSkillRate($monster);
		$ret = array('attack' => array(), 'defense' => array(), 'passive' => array());
		foreach ($ret as $skill_type => &$skills) {
			$must_skills = isset($must_skills_list[$skill_type]) ? $must_skills_list[$skill_type] : array();
			//地图技能为空时直接返回必须技能
			if (empty($map_skills_list[$skill_type])) {
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
			foreach ($rand_skills as $k => $skill_level) {
				$rand_skills[$k] = mt_rand($min_skill_level, $max_skill_level);
			}
			$skills = array(
				'list' => $rand_skills,
			);
			if ($skill_type == 'passive') {
				continue;
			}
			//获取技能概率
			$rand_skill_count = count($rand_skills);
            foreach ($rand_skills as $skill => $skillV) {
                $skills['rate'][$skill] = $skill_rate_list[$skill_type][$rand_skill_count];
            }
		}

		return $ret;
	}


    /**
     * 对怪物的成长属性进行技能的加成
     * **/
	public static function attributeWithSkill($attribute, $skill, $monster) {
		$skill_list = array();
        if(is_array($skill)) {
            foreach ($skill as $value) {
                if(is_array($value['list'])) {
                    $skill_list = $skill_list + $value['list'];
                }
            }
        }
        return Monster_SkillConfig::getAttributeBySkillInfos($attribute, $skill_list, $monster);
	}

	/****
     * 多余属性随机分配
     */
	private static function _randAttribute($surplusAttribute, $userAttributeList) {
		$i = 0;
		$arrtibuteNum = count($userAttributeList);
		
		while ($surplusAttribute > 0)
		{
			$i++;
			if($i == $arrtibuteNum)
			{
				$randValue = $surplusAttribute;
				$surplusAttribute = 0;
			}else{
				$randValue = rand(0, $surplusAttribute);
				$surplusAttribute -= $randValue;
			}
			$randAttributes[] = $randValue;
			
		}
		$randUserAttributeList = $userAttributeList;
		foreach ($randAttributes as $randAttribute)
		{
			$key = array_rand($randUserAttributeList, 1);
			$userAttributeList[$key] += $randAttribute;
			unset($randUserAttributeList[$key]);
		}
		return $userAttributeList;
	}

	private static function _multiply() {
		$args = array_filter(func_get_args(), 'is_numeric');
		return array_product($args);
	}

    /**
     * 根据怪物的后缀
     * 获取必须的技能列表
     * **/
	private static function _getMustSkills($monster) {
		if ($monster['suffix']) {
			return Map_Skill::getSuffixMustHave($monster['map_id'], $monster['suffix']);
		}
		return array();
	}

    /**
     * 获取怪物的最少技能个数
     * 要么为后缀所配置的值
     * 要么默认返回0
     * **/
	private static function _getMinSkillCount($monster) {
		if ($monster['suffix']) {
			return Map_Skill::getSuffixMinCount($monster['map_id'], $monster['suffix']);
		}
		return array('attack' => 0,'defense' => 0,'passive' => 0);
	}

    /**
     * 获取boss或者其他的技能释放概率
     * **/
	private static function _getSkillRate($monster) {
		if ($monster['suffix'] == self::MONSTER_SUFFIX_BOSS) {
			return Map_Skill::getSkillRate('boss');
		}
		return Map_Skill::getSkillRate('not_boss');
	}
}
