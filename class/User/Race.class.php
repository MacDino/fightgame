<?php
class User_Race
{
    //种族定义
    CONST RACE_HUMAN        = 1;//人族
    CONST RACE_TSIMSHIAN    = 2;//仙族
    CONST RACE_DEMON        = 3;//魔族

    /**
     * 获取种族升级属性加成
     * @param int	 $raceId	种族ID
     * @return array
     */
    public static function getDefaultAttributes($raceId)
    {
        $defaultAttributtesList = User_RaceConfig::defaultAttributesList();
        if($raceId && isset($defaultAttributtesList[$raceId]))
        {
            return $defaultAttributtesList[$raceId];
        }
        return FALSE;
    }

    /**
     * 获取种族升级属性加成
     * @param int	 $raceId	种族ID
     * @return array
     */
    public static function getLeveUpAddAttributes($raceId)
    {
        $leveUpAddAttributtesList = User_RaceConfig::levelUpAddAttributesList();
        if($raceId && isset($leveUpAddAttributtesList[$raceId]))
        {
            return $leveUpAddAttributtesList[$raceId];
        }
        return FALSE;
    }

    /**
     * 随机一把种族
     * @return int
     */
    public static function randRaceId()
    {
        $raceList = self::getRaceList();
        $raceId = array_rand(array_keys($raceList), 1);
        return $raceId;
    }
    /**
     * 获取种族列表
     * @return array
     */
    public static function getRaceList()
    {
        $raceList = array(
            self::RACE_HUMAN      => '人族',
            self::RACE_TSIMSHIAN  => '仙族',
            self::RACE_DEMON      => '魔族',
          );
        return $raceList;
    }
    /**
     * 获取对应种族的成长属性
     * @param int	 $raceId	种族ID
     * @param array $userAttributes
     * @return array
     */
    public static function getGrowUpAttributes($raceId, $userAttributes)
    {
        if(!$raceId || !is_array($userAttributes))return array();
        $growUpAttributes = array();
        if($raceId == self::RACE_HUMAN)
        {
            $growUpAttributes = User_RaceConfig::humanGrowUpAttributesFormula($userAttributes);
        }elseif($raceId == self::RACE_TSIMSHIAN){
            $growUpAttributes = User_RaceConfig::tsimshianGrowUpAttributesFormula($userAttributes);
        }elseif($raceId == self::RACE_DEMON){
            $growUpAttributes = User_RaceConfig::demonGrowUpAttributesFormula($userAttributes);
        }
        return $growUpAttributes;
    }
}
