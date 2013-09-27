<?php
//怪物后缀相关的配置信息
class Monster_SuffixConfig
{
	protected static $suffix_config_list = array(
		Monster::MONSTER_SUFFIX_BOSS => array(
			'meet_probability' => 0.005,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 10,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 10,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 20,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 10,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 10,//敏捷
			),
			'experience_change' => 5, //经验加成
			'money_change' => 5, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0.9,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0.1,//橙色
			),
		),
		Monster::MONSTER_SUFFIX_SACRED => array(
			'meet_probability' => 0.02,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 5,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1,//敏捷
			),
			'experience_change' => 2, //经验加成
			'money_change' => 2, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0.075,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0.04,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0.025,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0.0025,//橙色
			),
		),
		Monster::MONSTER_SUFFIX_UNKNOWN => array(
			'meet_probability' => 0.02,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 5,//敏捷
			),
			'experience_change' => 2, //经验加成
			'money_change' => 2, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0.075,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0.04,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0.025,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0.0025,//橙色
			),
		),

		Monster::MONSTER_SUFFIX_ADVANCED => array(
			'meet_probability' => 0.02,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 5,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1,//敏捷
			),
			'experience_change' => 2, //经验加成
			'money_change' => 2, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0.075,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0.04,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0.025,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0.0025,//橙色
			),
		),

		Monster::MONSTER_SUFFIX_WILL_EXTINCT => array(
			'meet_probability' => 0.02,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 5,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1,//敏捷
			),
			'experience_change' => 2, //经验加成
			'money_change' => 2, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0.075,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0.04,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0.025,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0.0025,//橙色
			),
		),
		Monster::MONSTER_SUFFIX_CURSED => array(
			'meet_probability' => 0.02,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 5,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1,//敏捷
			),
			'experience_change' => 2, //经验加成
			'money_change' => 2, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0.075,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0.04,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0.025,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0.0025,//橙色
			),
		),
		Monster::MONSTER_SUFFIX_ANCIENT => array(
			'meet_probability' => 0.02,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1.25,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1.25,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1.25,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1.25,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1.25,//敏捷
			),
			'experience_change' => 2, //经验加成
			'money_change' => 2, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0.075,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0.04,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0.025,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0.0025,//橙色
			),
		),
		Monster::MONSTER_SUFFIX_HEAD => array(
			'meet_probability' => 0.03,//遇到几率
			'attribute_change_list' => array(//基本属性变变化
				ConfigDefine::USER_ATTRIBUTE_POWER       => 1.05,//力量
				ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1.05,//魔力
				ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1.05,//体质
				ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1.05,//耐力
				ConfigDefine::USER_ATTRIBUTE_QUICK       => 1,//敏捷
			),
			'experience_change' => 1.05, //经验加成
			'money_change' => 1.05, //金币加成
			'equip_get_probability' => array(
				Equip::EQUIP_COLOUR_GRAY    => 0,//灰色
				Equip::EQUIP_COLOUR_WHITE   => 0,//白色
				Equip::EQUIP_COLOUR_GREEN   => 0.04,//绿色
				Equip::EQUIP_COLOUR_BLUE    => 0.025,//蓝色
				Equip::EQUIP_COLOUR_PURPLE  => 0.0125,//紫色
				Equip::EQUIP_COLOUR_ORANGE  => 0,//橙色
			),
		),
	);

	// 后缀列表
	public static function monsterSuffixList()
	{
		$monsterSuffixList = array(
			Monster::MONSTER_SUFFIX_BOSS         => 'Boss',
			Monster::MONSTER_SUFFIX_SACRED       => '圣灵',
			Monster::MONSTER_SUFFIX_UNKNOWN      => '领主',
			Monster::MONSTER_SUFFIX_ADVANCED     => '巨魔',
			Monster::MONSTER_SUFFIX_WILL_EXTINCT => '将领',
			Monster::MONSTER_SUFFIX_CURSED       => '魔王',
			Monster::MONSTER_SUFFIX_ANCIENT      => '长老',
			Monster::MONSTER_SUFFIX_HEAD         => '头头',
		);
		return $monsterSuffixList;
	}

	// 后缀的概率列表
	public static function monsterSuffixRateList()
	{
		$rate_list = array();

		foreach (self::$suffix_config_list as $suffix => $config)
		{
			$rat_list[$suffix] = $config['meet_probability'];
		}

		return $rat_list;
	}

	//获取特定后缀信息
	public static function getMonsterSuffixConfig($suffix_id, $item = null)
	{
		if ( ! isset(self::$suffix_config_list[$suffix_id]))
		{
			return false;
		}

		$suffix_config = self::$suffix_config_list[$suffix_id];
		return isset($item) ? $suffix_config[$item] : $suffix_config;
	}
}
