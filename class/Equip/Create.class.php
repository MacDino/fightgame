<?php
//生产一件装备
class Equip_Create
{	
	CONST TABLE_USER_EQUIP = 'user_equip';

    private static $_equipGetAttribute = array();
    private static $_equipSuitRaceId = NULL;
    private static $_equipAttributeConfigList = array();

    //创建一件装备
    public static function createEquip($equipColour, $userId = NULL, $equipLevel = 0, $equipType = NULL, $equipQuality = NULL)
    {
        if(!$equipColour)return FALSE;//装备颜色
        $equipLevel = self::_getEquipLevel($equipLevel);
        $equipType  = self::_getEquipType($equipType);
        $equipQuality = self::_getEquipQuality($equipQuality);
        self::$_equipAttributeConfigList = Equip_Config::equipAttributeList();//获取装备的附加属性配置信息
        
        try{
            self::_getEquipSuitAttributeInfo($equipColour, $equipQuality, $equipType);//套装信息
            $attributeBaseList = self::_getEquipAttributeInfo($equipColour, $equipQuality, $equipType, $equipLevel);//装备信息      
            $attributeList = self::_getEquipAttributeValue($equipLevel, $equipQuality);
            $equipInfo = self::_getEquipData($equipLevel, $equipType, $equipColour, $attributeList, $attributeBaseList, $equipQuality); 
            if($userId)
            {
                $equipInfo['user_id'] = $userId;
                self::_insertDataToValue($equipInfo);
            }else{
                return $equipInfo;
            }
        }catch(Exception $e){
            return FALSE;
        }
    }

    private static function _insertDataToValue($data)
    {
        $res = MySql::insert(self::TABLE_USER_EQUIP, $data);
        echo MySql::getLastSql();
        return $res;
    }

    private static function _getEquipData($equipLevel, $equipType, $equipColour, $attributeList, $attributeBaseList, $equipQuality)
    {
        $equipInfo['equip_level'] =  $equipLevel;
        $equipInfo['is_used'] = 0;
        $equipInfo['race_id'] = isset(self::$_equipSuitRaceId)?self::$_equipSuitRaceId:0;
        $equipInfo['equip_type'] = $equipType;
        $equipInfo['equip_colour'] = $equipColour;
        $equipInfo['equip_quality'] = $equipQuality;
        $equipInfo['attribute_list'] = json_encode($attributeList);
        $equipInfo['attribute_base_list'] = json_encode($attributeBaseList);
        return $equipInfo;
    }

    private static function _getEquipAttributeValue($equipLevel, $equipQuality)
    {
        if(self::$_equipGetAttribute && is_array(self::$_equipGetAttribute))
        {
            $humanAttribute = User_Attributes::getUserAllAttribute(User_Race::RACE_HUMAN, $equipLevel);  
            $percentValueAttributeIds = self::_getPercentValueAttributeIds();
            foreach(self::$_equipGetAttribute as $equipAttribute)
            {
                $randValue = self::$_equipAttributeConfigList[$equipAttribute][$equipQuality]; 
                if(in_array($equipAttribute, $percentValueAttributeIds))
                {
                     $attribtueValue[$equipAttribute] = $humanAttribute[$equipAttribute]*PerRand::getRandValue($randValue);
                }else{
                    $attribtueValue[$equipAttribute]  = PerRand::getRandValue($randValue); 
                }
            }
        }
        return $attribtueValue;
    }

    private static function _getPercentValueAttributeIds()
    {
        return array(
                ConfigDefine::USER_ATTRIBUTE_POWER, 
                ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER, 
                ConfigDefine::USER_ATTRIBUTE_PHYSIQUE, 
                ConfigDefine::USER_ATTRIBUTE_ENDURANCE, 
                ConfigDefine::USER_ATTRIBUTE_QUICK, 
                ConfigDefine::USER_ATTRIBUTE_HIT,
                ConfigDefine::USER_ATTRIBUTE_HURT,
                ConfigDefine::USER_ATTRIBUTE_MAGIC,
                ConfigDefine::USER_ATTRIBUTE_BLOOD,
                ConfigDefine::USER_ATTRIBUTE_PSYCHIC,
                ConfigDefine::USER_ATTRIBUTE_SPEED,
                ConfigDefine::USER_ATTRIBUTE_DEFENSE,
                ConfigDefine::USER_ATTRIBUTE_DODGE,
                );
    
    }
    //获取装备属性配置信息
    private static function _getEquipAttributeInfo($equipColour, $equipQuality, $equipType, $equipLevel)
    {
        $randAttributeIdList =  array_keys(self::$_equipAttributeConfigList);//允许获取的属性ID
        $randAttributeIdList = array_diff($randAttributeIdList, self::$_equipGetAttribute);
        $equipConfigList = Equip::getEquipConfigListByColour($equipColour);
        if(!$equipConfigList)return FALSE;
        $randNum = $equipConfigList['add_attribute_num'] - count(self::$_equipGetAttribute);
        $getAttribute = array_rand($randAttributeIdList, $randNum);
        foreach($getAttribute as $attributeId)
        {
            self::$_equipGetAttribute[] = $randAttributeIdList[$attributeId];
        }
        $attributeBaseList = Equip::attributeBaseList($equipConfigList['base_attribute'], $equipType, $equipLevel);
        return $attributeBaseList;
    }

    //获取套装信息
    private static function _getEquipSuitAttributeInfo($equipColour, $equipQuality, $equipType)
    {
        if($equipColour != Equip::EQUIP_COLOUR_ORANGE)return array();
        if($equipQuality != Equip::EQUIP_QUALITY_HOLY)return array();
        self::$_equipSuitRaceId = User_Race::randRaceId();
        $equipSuitAttribute = self::getEquipSuitAttributeByRaceIdAndEquipType(self::$_equipSuitRaceId, $equipType);
        $equipSuitAttribute = PerRand::getMultiRandResultKey($equipSuitAttribute);
        if($equipSuitAttribute && is_array($equipSuitAttribute))
        {
            foreach($equipSuitAttribute as $attributeId)
            {
                self::$_equipGetAttribute[] = $attributeId;
            }
        }
        return TRUE;
    }
    //根据种族和装备部位，返回对应的属性相关信息
	public static function getEquipSuitAttributeByRaceIdAndEquipType($raceId, $equipType)
	{
		if(!$raceId || !$equipType)return array();
		$equipSuitAttributeList = Equip_Config::equipSuitAttributeList();
		if(is_array($equipSuitAttributeList) && isset($equipSuitAttributeList[$raceId][$equipType]))
		{
			return $equipSuitAttributeList[$raceId][$equipType];
		}
		return array();
	}
    //获取装备品质
    private static function _getEquipQuality($equipQuality = NULL)
    {
        if(!$equipQuality)$equipQuality = self::_randQuality();
        return $equipQuality;
    }
    //获取装备类型
    private static function _getEquipType($equipType = NULL)
    {
        if(!$equipType)$equipType = self::_getRandEquipType();
        return $equipType;
    }
    //获取装备等级
    private static function _getEquipLevel($equipLevel = 0)
    {
        if(!$equipLevel || (int)$equipLevel < 0)
        {
            return 0;
        }
        return (int)$equipLevel;
    }
    //随机装备位置
	private static function _getRandEquipType()
	{
		return mt_rand(1, 6);
	}
    //随机一把品质
	private static function _randQuality()
	{
		$qualityProbabilityList = Equip_Config::qualityProbabilityList();
		$randHitQuality = PerRand::getRandResultKey($qualityProbabilityList);
		return $randHitQuality;
	}
}
