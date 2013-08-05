<?php
class User_Attributes
{
    //获取某种族在某等级属性
    public static function getInfoByRaceAndLevel($raceId, $level, $needGrowUpAttribute = FALSE)
    {
        if(!$raceId || !$level)return FALSE;
        $raceId = (int)$raceId;
        $level = (int)$level;
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
