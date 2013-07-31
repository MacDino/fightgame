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

	CONST EQUIP_QUALITY_GENERAL = 1;//品质-普通
	CONST EQUIP_QUALITY_ADVANCED = 2;//品质-进阶
	CONST EQUIP_QUALITY_SUBLIME = 3;//品质-升华
	CONST EQUIP_QUALITY_HOLY = 4;//品质-圣品


	//随机建创建一套装备
	public static function createRandEquip($equipColour, $equipLevel)
	{

	}


	//颜色和装笽对应
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
	}

	//装备对应的属性
	public static function equipAttributeList()
	{
		$equipAttributeList = array(
			self::EQUIP_TYPE_ARMS 		=> array(User_Attributes::USER_ATTRIBUTE_HIT, User_Attributes::USER_ATTRIBUTE_HURT),
			self::EQUIP_TYPE_HELMET 	=> array(User_Attributes::USER_ATTRIBUTE_DEFENSE, User_Attributes::USER_ATTRIBUTE_MAGIC),
			self::EQUIP_TYPE_NECKLACE 	=> array(User_Attributes::USER_ATTRIBUTE_PSYCHIC),
			self::EQUIP_TYPE_CLOTHES 	=> array(User_Attributes::USER_ATTRIBUTE_DEFENSE),
			self::EQUIP_TYPE_BELT 		=> array(User_Attributes::USER_ATTRIBUTE_BLOOD, User_Attributes::USER_ATTRIBUTE_DEFENSE),
			self::EQUIP_TYPE_SHOES 		=> array(User_Attributes::USER_ATTRIBUTE_DEFENSE, User_Attributes::USER_ATTRIBUTE_QUICK),
		);
	}

}