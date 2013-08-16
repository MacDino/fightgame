<?php
class User_Attributes
{
    /**
     * 获取某种族在某等级属性点
     * @param int $raceId				种族ID
     * @param int $level				等级
     * @return array
     */
    public static function getBaseAttribute($raceId, $level)
    {
//    	echo "raceId===$raceId&&level===$level";exit;
        if(!$raceId)return FALSE;
        $raceId = (int)$raceId;
        $level = (int)$level;
        
        //获取种族基本属性
        $defautlAttributes = Race::getDefaultAttributes($raceId);
//        var_dump($defautlAttributes);exit;
        if(!is_array($defautlAttributes))return FALSE;
        
        //获取种族属性升级加成
        $addAttributesList = Race::getLeveUpAddAttributes($raceId);
//        var_dump($addAttributesList);exit;
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
//		var_dump($res);exit;
        return $res;
    }
    
    /**
     * 根据属性点,通过成长属性,获取属性值
     * @param int	$raceId
     * @param array $data
     * @return array
     */
    public static function getAttributesValue($raceId, $data){
//    	var_dump($data);exit;
    	if(!$raceId || !is_array($data))return FALSE;
    	
    	$res = Race::getGrowUpAttributes($raceId, $data);
//    	var_dump($growUpAttributes);exit;
		return $res;
    }
    
}
