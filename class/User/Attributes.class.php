<?php
class User_Attributes
{
    /**
     * 获取某种族在某等级属性
     * @param int $raceId				种族ID
     * @param int $level				等级
     * @param bool $needGrowUpAttribute	是否需要成长属性
     * @return unknown
     */
    public static function getInfoByRaceAndLevel($raceId, $level, $needGrowUpAttribute = FALSE)
    {
    	//echo "raceId===$raceId&&level===$level";exit;
        if(!$raceId || !$level)return FALSE;
        $raceId = (int)$raceId;
        $level = (int)$level;
        
        //获取种族升级属性加成
        $defautlAttributes = Race::getDefaultAttributes($raceId);
        if(!is_array($defautlAttributes))return FALSE;
        
        if($level <= User::DEFAULT_USER_LEVEL)
        {
            $res = $defautlAttributes;
        }else{
            $addAttributesList = Race::getLeveUpAddAttributes($raceId);
            if(!is_array($addAttributesList))return FALSE;
            foreach($defautlAttributes as $key => &$value)
            {
                if(isset($addAttributesList[$key]))
                {
                    $value += $addAttributesList[$key]*$level;
                }
            }
            unset($value);
            $res = $defautlAttributes;
        } 
        if($needGrowUpAttribute)
        {
            $growUpAttributes = Race::getGrowUpAttributes($raceId, $res);
            $res += $growUpAttributes;
        }
        return $res;
    }
}
