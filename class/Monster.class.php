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
      if(!$level || (int)$level < 1)return 0;
      return (float)41.4 + 10.33*$level;
  }

  //获取某指定等级怪物的基本属性值,没有计算加成
  public static function getMonsterBaseAttribute($level)
  {
      if(!$level || (int)$level < 1)return array();
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

	  return self::_multiply($base_money, $prefix_change, $suffix_change);
  }

  // 获取怪物的经验(前后缀加成后)
  public static function getMonsterExperience($monster)
  {
	  $base_experience = self::getMonsterBaseExperience($monster['level']);
	  $prefix_change = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'experience_change');
	  $suffix_change = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'experience_change');

	  return self::_multiply($base_experience, $prefix_change, $suffix_change);
  }

  // 获取怪物的属性(前后缀加成后)
  public static function getMonsterAttribute($monster)
  {
	  $base_attribute = self::getMonsterBaseAttribute($monster['level']);
	  $prefix_change = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'attribute_change_list');
	  $suffix_change = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'attribute_change_list');

	  return Utility::arrayMultiply($base_attribute, $prefix_change, $suffix_change);
  }

  // 获取怪物的装备顔色(前后缀加成后)
  public static function getMonsterEquipmentColor($monster)
  {
	  $prefix_probability = Monster_PrefixConfig::getMonsterPrefixConfig($monster['prefix'], 'equip_get_probability');
	  $suffix_probability = Monster_SuffixConfig::getMonsterSuffixConfig($monster['suffix'], 'equip_get_probability');

	  // ?? 如何处理两种概率, 
	  // 暂先摇后缀概率，没中的话再摇前缀概率
	  if ($color = PerRand::getRandResultKey($suffix_probability))
	  {
		  return $color;
	  }

	  return PerRand::getRandResultKey($prefix_probability);
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

  public static function _multiply()
  {
	  $args = array_filter(func_get_args(), 'is_numeric');
	  return array_product($args);
  }
}
