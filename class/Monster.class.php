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
}
