<?php
//种族
class Race
{
    CONST RACE_HUMAN      = 1;//人族
    CONST RACE_TSIMSHIAN  = 2;//仙族
    CONST RACE_DEMON      = 3;//魔族 


    //获取种族升级属性加成
    public static function getDefaultAttributes($raceId)
    {
        $defaultAttributtesList = self::_defaultAttributesList();
        if($raceId && isset($defaultAttributtesList[$raceId]))
        {
            return $defaultAttributtesList[$raceId];
        }
        return FALSE;
    }
    //种族初始化属性点
    private static function _defaultAttributesList()
    {
        $defaultAttributesList = array(
            self::RACE_HUMAN => 
                array(User_Attributes::USER_ATTRIBUTE_POWER       => 10,
                      User_Attributes::USER_ATTRIBUTE_QUICK       => 10,
                      User_Attributes::USER_ATTRIBUTE_PHYSIQUE    => 10,
                      User_Attributes::USER_ATTRIBUTE_MAGIC_POWER => 10,
                      User_Attributes::USER_ATTRIBUTE_ENDURANCE   => 10,
                      User_Attributes::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
            self::RACE_TSIMSHIAN => 
                array(User_Attributes::USER_ATTRIBUTE_POWER       => 11,
                      User_Attributes::USER_ATTRIBUTE_QUICK       => 10,
                      User_Attributes::USER_ATTRIBUTE_PHYSIQUE    => 12,
                      User_Attributes::USER_ATTRIBUTE_MAGIC_POWER => 5,
                      User_Attributes::USER_ATTRIBUTE_ENDURANCE   => 12,
                      User_Attributes::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
            self::RACE_DEMON => 
                array(User_Attributes::USER_ATTRIBUTE_POWER       => 11,
                      User_Attributes::USER_ATTRIBUTE_QUICK       => 8,
                      User_Attributes::USER_ATTRIBUTE_PHYSIQUE    => 12,
                      User_Attributes::USER_ATTRIBUTE_MAGIC_POWER => 11,
                      User_Attributes::USER_ATTRIBUTE_ENDURANCE   => 8,
                      User_Attributes::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
        );
        return $defaultAttributesList;
    }
    //获取种族升级属性加成
    public static function getLeveUpAddAttributes($raceId)
    {
        $leveUpAddAttributtesList = self::_levelUpAddAttributesList();
        if($raceId && isset($leveUpAddAttributtesList[$raceId]))
        {
            return $leveUpAddAttributtesList[$raceId];
        }
        return FALSE;
    }
    //种族升级对应增加属性点
    private static function _levelUpAddAttributesList()
    {
        $leveUpAddAttributtesList = array(
            self::RACE_HUMAN => 
                array(User_Attributes::USER_ATTRIBUTE_POWER       => 2,
                      User_Attributes::USER_ATTRIBUTE_QUICK       => 2,
                      User_Attributes::USER_ATTRIBUTE_PHYSIQUE    => 2,
                      User_Attributes::USER_ATTRIBUTE_MAGIC_POWER => 2,
                      User_Attributes::USER_ATTRIBUTE_ENDURANCE   => 2,
                      User_Attributes::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
            self::RACE_TSIMSHIAN => 
                array(User_Attributes::USER_ATTRIBUTE_POWER       => 1.5,
                      User_Attributes::USER_ATTRIBUTE_QUICK       => 2,
                      User_Attributes::USER_ATTRIBUTE_PHYSIQUE    => 1,
                      User_Attributes::USER_ATTRIBUTE_MAGIC_POWER => 3,
                      User_Attributes::USER_ATTRIBUTE_ENDURANCE   => 2.5,
                      User_Attributes::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
            self::RACE_DEMON => 
                array(User_Attributes::USER_ATTRIBUTE_POWER       => 2.5,
                      User_Attributes::USER_ATTRIBUTE_QUICK       => 2,
                      User_Attributes::USER_ATTRIBUTE_PHYSIQUE    => 3,
                      User_Attributes::USER_ATTRIBUTE_MAGIC_POWER => 1,
                      User_Attributes::USER_ATTRIBUTE_ENDURANCE   => 1.5,
                      User_Attributes::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
        );
        return $leveUpAddAttributtesList;
    }
    //获取种族列表
    public static function getRaceList()
    {
        return self::_raceNameLsit();
    }
    //获取种族名称
    public static function getRaceName($raceId)
    {
        $raceNameList = self::_raceNameLsit();
        if($raceId && isset($raceNameList[$raceId]))
        {
            return $raceNameList[$raceId];
        }
        return FALSE;
    }
    //种族名称LIST
    private static function _raceNameLsit()
    {
    
        $raceNameList = array(self::RACE_HUMAN => '人族', self::RACE_TSIMSHIAN => '仙族', self::RACE_DEMON => '魔族',);
        return $raceNameList;
    }

    //获取对应种族的成长属性
    public static function getGrowUpAttributes($raceId, $userAttributes)
    {
        if(!$raceId || !is_array($userAttributes))return array();
        $growUpAttributes = array();
        if($raceId == self::RACE_HUMAN)
        {
            $growUpAttributes = self::_humanGrowUpAttributesFormula($userAttributes);
        }elseif($raceId == self::RACE_TSIMSHIAN){
            $growUpAttributes = self::_tsimshianGrowUpAttributesFormula($userAttributes);
        }elseif($raceId == self::RACE_DEMON){
            $growUpAttributes = self::_demonGrowUpAttributesFormula($userAttributes); 
        }
        return $growUpAttributes;
    }

    //魔族成长属性计算公式
    private static function _demonGrowUpAttributesFormula($userAttributes)
    {
        $demonGrowUpAttributes = array(
                User_Attributes::USER_ATTRIBUTE_HURT     => 34 + $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.77,
                User_Attributes::USER_ATTRIBUTE_PSYCHIC  => $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.4 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*0.3 + $userAttributes[User_Attributes::USER_ATTRIBUTE_MAGIC_POWER]*0.7 + $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*0.2,
                User_Attributes::USER_ATTRIBUTE_MAGIC    => 80 + $userAttributes[User_Attributes::USER_ATTRIBUTE_MAGIC_POWER]*2.5,
                User_Attributes::USER_ATTRIBUTE_HIT      => 27 + $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*2.31,
                User_Attributes::USER_ATTRIBUTE_DODGE    => $userAttributes[User_Attributes::USER_ATTRIBUTE_QUICK]*1,
                User_Attributes::USER_ATTRIBUTE_DEFENSE  => $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*1.4,
                User_Attributes::USER_ATTRIBUTE_SPEED    => $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.1 + $userAttributes[User_Attributes::USER_ATTRIBUTE_QUICK]*0.7 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*0.1 + $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*0.1,
                User_Attributes::USER_ATTRIBUTE_BLOOD    => 100 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*6,
              );
        return $demonGrowUpAttributes;
    }
    //仙族成长属性计算公式
    private static function _tsimshianGrowUpAttributesFormula($userAttributes)
    {
        $tsimshianGrowUpAttributes = array(
                User_Attributes::USER_ATTRIBUTE_HURT     => 40 + $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.57,
                User_Attributes::USER_ATTRIBUTE_PSYCHIC  => $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.4 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*0.3 + $userAttributes[User_Attributes::USER_ATTRIBUTE_MAGIC_POWER]*0.7 + $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*0.2,
                User_Attributes::USER_ATTRIBUTE_MAGIC    => 80 + $userAttributes[User_Attributes::USER_ATTRIBUTE_MAGIC_POWER]*3.5,
                User_Attributes::USER_ATTRIBUTE_HIT      => 30 + $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*1.71,
                User_Attributes::USER_ATTRIBUTE_DODGE    => $userAttributes[User_Attributes::USER_ATTRIBUTE_QUICK]*1,
                User_Attributes::USER_ATTRIBUTE_DEFENSE  => $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*1.6,
                User_Attributes::USER_ATTRIBUTE_SPEED    => $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.1 + $userAttributes[User_Attributes::USER_ATTRIBUTE_QUICK]*0.7 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*0.1 + $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*0.1,
                User_Attributes::USER_ATTRIBUTE_BLOOD    => 100 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*4.5,
              );
        return $tsimshianGrowUpAttributes;
    }
    //人族成长属性计算公式
    private static function _humanGrowUpAttributesFormula($userAttributes)
    {
        $humanGrowUpAttributes =  array(
                User_Attributes::USER_ATTRIBUTE_HURT     => 34 + $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.67,
                User_Attributes::USER_ATTRIBUTE_PSYCHIC  => $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.4 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*0.3 + $userAttributes[User_Attributes::USER_ATTRIBUTE_MAGIC_POWER]*0.7 + $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*0.2,
                User_Attributes::USER_ATTRIBUTE_MAGIC    => 80 + $userAttributes[User_Attributes::USER_ATTRIBUTE_MAGIC_POWER]*0.3,
                User_Attributes::USER_ATTRIBUTE_HIT      => 30 + $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*2.01,
                User_Attributes::USER_ATTRIBUTE_DODGE    => $userAttributes[User_Attributes::USER_ATTRIBUTE_QUICK]*1,
                User_Attributes::USER_ATTRIBUTE_DEFENSE  => $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*1.5,
                User_Attributes::USER_ATTRIBUTE_SPEED    => $userAttributes[User_Attributes::USER_ATTRIBUTE_POWER]*0.1 + $userAttributes[User_Attributes::USER_ATTRIBUTE_QUICK]*0.7 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*0.1 + $userAttributes[User_Attributes::USER_ATTRIBUTE_ENDURANCE]*0.1,
                User_Attributes::USER_ATTRIBUTE_BLOOD    => 100 + $userAttributes[User_Attributes::USER_ATTRIBUTE_PHYSIQUE]*0.5,
              );
        return $humanGrowUpAttributes;
    }
}
