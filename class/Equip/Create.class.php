<?php
//生产一件装备
class Equip_Create
{	
	CONST TABLE_USER_EQUID = 'user_equip';
	
	//创建一件随机的装备,颜色由外部传入
	public static function createOneRandEquip($equipColour, $userId)
	{
		if(!$equipColour)return FALSE;
		$equipType = self::_getRandEquipType();
		$equipQuality = self::_randQuality();
		return self::createEquip($equipType, $equipColour, $equipQuality, $userId);
	}
	//颜色，品质
	public static function createEquip($equipType, $equipColour, $equipQuality, $userId)
	{
		if(!$equipColour || !$equipQuality || !$equipType)return FALSE;
		$equipInfo = $attributeList = $randAttributes = array();
		$attributeHaveNum = 0;
        //附加属性
		$equipAttributeList = Equip_Config::equipAttributeList();
		$allowRandAttributes = array_keys($equipAttributeList);
		
		if($equipColour == Equip::EQUIP_COLOUR_ORANGE && $equipQuality == Equip::EQUIP_QUALITY_HOLY)
		{
			//确认为套装
			$equipSuitInfo = self::equipSuit($equipType);
			if(!$equipSuitInfo)return FALSE;
			foreach ($equipSuitInfo['list'] as $haveAttributeId) {
				$unsetKey = array_search($haveAttributeId, $allowRandAttributes);
				if($unsetKey)unset($allowRandAttributes[$unsetKey]);
				$thisAttributeRandValue = $equipAttributeList[$haveAttributeId][$equipQuality];
				$attributeList[$haveAttributeId] = PerRand::getRandValue($thisAttributeRandValue);
				++$attributeHaveNum;
			}
		}

		$equipConfigList = Equip::getEquipConfigListByColour($equipColour);
		if(!$equipConfigList)return FALSE;
		$attributeAllowNum = $equipConfigList['add_attribute_num'];

		$randAttributeNum = $attributeAllowNum - $attributeHaveNum;
		if($randAttributeNum > 0)
		{
			$randAttributes = array_rand($allowRandAttributes, $randAttributeNum);	
		}

		if(is_array($randAttributes) && $randAttributes)
		{
			foreach ($randAttributes as $randAttribute) {
				$thisAttributeRandValue = $equipAttributeList[$allowRandAttributes[$randAttribute]][$equipQuality];
				$attributeList[$allowRandAttributes[$randAttribute]] = PerRand::getRandValue($thisAttributeRandValue);
			}
		}

		$attributeBaseList = Equip::attributeBaseList($equipConfigList['base_attribute'], $equipType, 0);
		$equipInfo['attribute_base_list'] = json_encode($attributeBaseList);
		$equipInfo['attribute_list'] = json_encode($attributeList);
		$equipInfo['equip_colour'] = $equipColour;
		$equipInfo['equip_type'] = $equipType;
		$equipInfo['race_id'] = isset($equipSuitInfo['race_id'])?$equipSuitInfo['race_id']:0;
		$equipInfo['is_used'] = 0;
		$equipInfo['equip_level'] = 0;
        $equipInfo['user_id'] = $userId;

        return self::equipInsertDb($equipInfo);
	}

	//创建数据庘数据
	public static function equipInsertDb($data)
    {
        //todo 检查数据
		if(!$data || !is_array($data))return FALSE;
		$res = MySql::insert(self::TABLE_USER_EQUID, $data);
        //echo MySql::getLastSQL();
        return $res;
	}

	//套装
	public static function equipSuit($equipType)
	{
		if(!$equipType)return FALSE;
		$raceId = Race::randRaceId();//随机一把种族
		$equipSuitInfo['race_id'] = $raceId;
		$equipSuitAttributeList = Equip_Config::getEquipSuitAttributeByRaceIdAndEquipType($raceId, $equipType);
		$equipSuitInfo['list'] = PerRand::getMultiRandResultKey($equipSuitAttributeList);
		return $equipSuitInfo;
	}

	//随机一把品质
	private static function _randQuality()
	{
		$qualityProbabilityList = Equip_Config::qualityProbabilityList();
		$randHitQuality = PerRand::getRandResultKey($qualityProbabilityList);
		return $randHitQuality;
	}
	//随机装备位置
	private static function _getRandEquipType()
	{
		return mt_rand(1, 6);
	}
}
