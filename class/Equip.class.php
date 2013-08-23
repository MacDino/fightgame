<?php
//武器装备
class Equip
{
	CONST EQUIP_COLOUR_GRAY 	= 1;//灰色
	CONST EQUIP_COLOUR_WHITE 	= 2;//白色
	CONST EQUIP_COLOUR_GREEN 	= 3;//绿色
	CONST EQUIP_COLOUR_BLUE 	= 4;//蓝色
	CONST EQUIP_COLOUR_PURPLE 	= 5;//紫色
	CONST EQUIP_COLOUR_ORANGE 	= 6;//橙色


	CONST EQUIP_BASE_ATTRIBUTE_GENERAL 	= 'general';//普通
	CONST EQUIP_BASE_ATTRIBUTE_HIGH 	= 'high';//高
	CONST EQUIP_BASE_ATTRIBUTE_VH 		= 'vh';//很高

	CONST EQUIP_TYPE_ARMS 		= 1;//武器
	CONST EQUIP_TYPE_HELMET 	= 2;//头盔
	CONST EQUIP_TYPE_NECKLACE 	= 3;//项链
	CONST EQUIP_TYPE_CLOTHES 	= 4;//衣服
	CONST EQUIP_TYPE_BELT 		= 5;//腰带
	CONST EQUIP_TYPE_SHOES 		= 6;//鞋子

	CONST EQUIP_QUALITY_GENERAL 	= 1;//品质-普通
	CONST EQUIP_QUALITY_ADVANCED 	= 2;//品质-进阶
	CONST EQUIP_QUALITY_SUBLIME 	= 3;//品质-升华
	CONST EQUIP_QUALITY_HOLY 		= 4;//品质-圣品

	CONST TABLE_EQUID_ATTRIBUTES = 'equip_attributes';

	//创建一个装备
	public static function createEquip($equipType, $equipColour, $equipQuality, $userId)
	{
		return Equip_create::createEquip($equipType, $equipColour, $equipQuality, $userId);
	}


	//获取应颜色的配置
	public static function getEquipConfigListByColour($equipColour)
	{
		$equipConfigList = self::equipConfigList();
		if(is_array($equipConfigList) && isset($equipConfigList[$equipColour]))
		{
			return $equipConfigList[$equipColour];
		}
		return FALSE;
	}

	//获取装备基本属性
	public static function attributeBaseList($base = self::EQUIP_BASE_ATTRIBUTE_GENERAL, $equipType = self::EQUIP_TYPE_ARMS, $level = 0)
	{
		$sql = "SELECT * FROM ".self::TABLE_EQUID_ATTRIBUTES." WHERE `equip_id` = ".$equipType." AND `base_attribute` = '".$base."' AND '".$level."' >= level_begin ";
		$res = MySql::query($sql);
		if($res && is_array($res))
		{
			foreach ($res as $value) {
				$attributeBaseList[$value['attribute_id']] = PerRand::getRandValue(array($value['attributes_begin'], $value['attributes_end']));
			}
		}
		return $attributeBaseList;
	}

	//颜色和装备对应
	public static function equipConfigList()
	{
		$equipConfigList = array(
				self::EQUIP_COLOUR_GRAY => array(
					'base_attribute' => self::EQUIP_BASE_ATTRIBUTE_GENERAL,
					'add_attribute_num' => 0,
					),
				self::EQUIP_COLOUR_WHITE => array(
					'base_attribute' => self::EQUIP_BASE_ATTRIBUTE_GENERAL,
					'add_attribute_num' => 1,
					),
				self::EQUIP_COLOUR_GREEN => array(
					'base_attribute' => self::EQUIP_BASE_ATTRIBUTE_GENERAL,
					'add_attribute_num' => 2,
					),
				self::EQUIP_COLOUR_BLUE => array(
					'base_attribute' => self::EQUIP_BASE_ATTRIBUTE_HIGH,
					'add_attribute_num' => 3,
					),
				self::EQUIP_COLOUR_PURPLE => array(
					'base_attribute' => self::EQUIP_BASE_ATTRIBUTE_HIGH,
					'add_attribute_num' => 4,
					),
				self::EQUIP_COLOUR_ORANGE => array(
						'base_attribute' => self::EQUIP_BASE_ATTRIBUTE_VH,
						'add_attribute_num' => 5,
						),
				);
		return $equipConfigList;
	}
}
