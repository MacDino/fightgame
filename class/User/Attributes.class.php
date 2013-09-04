<?php
class User_Attributes
{
    //获取用户所有属性 
    public static function getUserAllAttribute($raceId, $level)
    {
        $userBaseAttribute = self::getBaseAttribute($raceId ,$level);
        if($userBaseAttribute)$userGrowUpAttribute = User_Race::getGrowUpAttributes($raceId, $userBaseAttribute);
        $userAllAttribute = $userBaseAttribute + $userGrowUpAttribute;
        return $userAllAttribute;
    }
    /**
     * 获取某种族在某等级属性点
     * @param int $raceId				种族ID
     * @param int $level				等级
     * @return array
     */
    public static function getBaseAttribute($raceId, $level)
    {
        if(!$raceId)return FALSE;
        $raceId = (int)$raceId;
        $level = (int)$level;
        
        //获取种族基本属性
        $defautlAttributes = User_Race::getDefaultAttributes($raceId);
        if(!is_array($defautlAttributes))return FALSE;
        
        //获取种族属性升级加成
        $addAttributesList = User_Race::getLeveUpAddAttributes($raceId);
        if(!is_array($addAttributesList))return FALSE;
        
        //获取种族某等级属性点
        foreach($defautlAttributes as $key => &$value)
        {
            if(isset($addAttributesList[$key]))
            {
                $value += $addAttributesList[$key]*$level;
            }
        }
        unset($value);
        $res = $defautlAttributes;
        return $res;
    }
    /**
     * 根据属性点,通过成长属性,获取属性值
     * @param int	$raceId
     * @param array $data
     * @return array
     */
    public static function getAttributesValue($raceId, $data){
    	if(!$raceId || !is_array($data))return FALSE;
    	$res = User_Race::getGrowUpAttributes($raceId, $data);
		return $res;
    }
    
}
