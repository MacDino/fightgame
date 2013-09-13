<?php
//怪物前缀相关的配置信息
class Monster_PrefixConfig
{
	protected static $prefix_config_list = array(
		Monster::MONSTER_PREFIX_PUNY => array(
			'meet_probability' => 0.3,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 0.5,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 0.5,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 0.5,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 0.5,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1,//敏捷
			),
			'experience_change' => 0.5, //经验加成
			'money_change' => 0.5, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0.05,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0.025,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0,//橙色
			),
		),
		Monster::MONSTER_PREFIX_SLOW => array(
			'meet_probability' => 0.3,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 0.25,//敏捷
			),
			'experience_change' => 0.5, //经验加成
			'money_change' => 0.5, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0.05,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0.025,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0,//橙色
			),
		),
		Monster::MONSTER_PREFIX_ORDINARY => array(
			'meet_probability' => 0.3,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1,//敏捷
			),
			'experience_change' => 1, //经验加成
			'money_change' => 1, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0.125,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0.04,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0,//橙色
			),
		),
		Monster::MONSTER_PREFIX_POWERFUL => array(
			'meet_probability' => 0.05,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1.5,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1.5,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1.5,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1.5,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1,//敏捷
			),
			'experience_change' => 1.5, //经验加成
			'money_change' => 1.5, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0.175,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0.075,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0,//橙色
			),
		),
		Monster::MONSTER_PREFIX_QUICK => array(
			'meet_probability' => 0.05,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1.5,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1.5,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1.5,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1.5,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 2,//敏捷
			),
			'experience_change' => 1.5, //经验加成
			'money_change' => 1.5, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0.175,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0.075,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0,//橙色
			),
		),
	);
	//前缀
	public static function monsterPrefixList()
	{
		$monsterPrefixList = array(
			Monster::MONSTER_PREFIX_PUNY     => '弱小的',
			Monster::MONSTER_PREFIX_SLOW     => '缓慢的',
			Monster::MONSTER_PREFIX_ORDINARY => '普通的',
			Monster::MONSTER_PREFIX_POWERFUL => '强大的',
			Monster::MONSTER_PREFIX_QUICK    => '敏捷的',
		);
		return $monsterPrefixList;
	}

	public static function monsterPrefixRateList()
	{
		$rate_list = array();

		foreach (self::$prefix_config_list as $prefix => $config)
		{
			$rat_list[$prefix] = $config['meet_probability'];
		}

		return $rat_list;
	}

	public static function getMonsterPrefixConfig($prefix_id, $item = null)
	{
		if ( ! isset(self::$prefix_config_list[$prefix_id]))
		{
			return false;
		}

		$prefix_config = self::$prefix_config_list[$prefix_id];
		return isset($item) ? $prefix_config[$item] : $prefix_config;
	}
}
