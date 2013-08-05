<?php
//种族
class Race
{
    //种族定义
    CONST RACE_HUMAN        = 1;//人族
    CONST RACE_TSIMSHIAN    = 2;//仙族
    CONST RACE_DEMON        = 3;//魔族 
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
    
    //随机一把种族
    public static function randRaceId()
    {
        $raceList = self::getRaceList();
        $raceId = mt_rand(1, count($raceList));
        return $raceId;
    }
    //获取种族列表
    public static function getRaceList()
    {
        $raceList = array(
            self::RACE_HUMAN      => '人族',
            self::RACE_TSIMSHIAN  => '仙族',
            self::RACE_DEMON      => '魔族',
          );
        return $raceList;
    }
    //获取对应种族的成长属性
    public static function getGrowUpAttributes($raceId, $userAttributes)
    {
        if(!$raceId || !is_array($userAttributes))return array();
        $growUpAttributes = array();
        if($raceId == self::RACE_HUMAN)
        {
            $growUpAttributes = Race_Config::humanGrowUpAttributesFormula($userAttributes);
        }elseif($raceId == self::RACE_TSIMSHIAN){
            $growUpAttributes = Race_Config::tsimshianGrowUpAttributesFormula($userAttributes);
        }elseif($raceId == self::RACE_DEMON){
            $growUpAttributes = Race_Config::demonGrowUpAttributesFormula($userAttributes); 
        }
        return $growUpAttributes;
    }
}
