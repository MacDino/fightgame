<?php

class Equip_Config
{
	//装备对应的基本属性
	public static function equipBaseAttributeList()
	{
		$equipBaseAttributeList = array(
			Equip::EQUIP_TYPE_ARMS 		=> array(ConfigDefine::USER_ATTRIBUTE_HIT, ConfigDefine::USER_ATTRIBUTE_HURT),
			Equip::EQUIP_TYPE_HELMET 	=> array(ConfigDefine::USER_ATTRIBUTE_DEFENSE, ConfigDefine::USER_ATTRIBUTE_MAGIC),
			Equip::EQUIP_TYPE_NECKLACE 	=> array(ConfigDefine::USER_ATTRIBUTE_PSYCHIC),
			Equip::EQUIP_TYPE_CLOTHES 	=> array(ConfigDefine::USER_ATTRIBUTE_DEFENSE),
			Equip::EQUIP_TYPE_BELT 		=> array(ConfigDefine::USER_ATTRIBUTE_BLOOD, ConfigDefine::USER_ATTRIBUTE_DEFENSE),
			Equip::EQUIP_TYPE_SHOES 	=> array(ConfigDefine::USER_ATTRIBUTE_DEFENSE, ConfigDefine::USER_ATTRIBUTE_QUICK),
		);
		return $equipBaseAttributeList;
	}
	//品质获取几率
	public static function qualityProbabilityList()
	{
		$qualityProbabilityList = array(
			Equip::EQUIP_QUALITY_GENERAL 	=> 0.8,
			Equip::EQUIP_QUALITY_ADVANCED 	=> 0.18,
			Equip::EQUIP_QUALITY_SUBLIME 	=> 0.019,
			Equip::EQUIP_QUALITY_HOLY 		=> 0.001,
		);
		return $qualityProbabilityList;
	}

    //打造增加的基本属性
    public static function upgradeAttributeList(){
        $ret = array(
            Equip::EQUIP_TYPE_ARMS     => array(ConfigDefine::USER_ATTRIBUTE_HIT => 8),
            Equip::EQUIP_TYPE_HELMET   => array(ConfigDefine::USER_ATTRIBUTE_DEFENSE => 20), 
            Equip::EQUIP_TYPE_NECKLACE => array(ConfigDefine::USER_ATTRIBUTE_PSYCHIC => 6), 
            Equip::EQUIP_TYPE_CLOTHES  => array(ConfigDefine::USER_ATTRIBUTE_DEFENSE => 12),
            Equip::EQUIP_TYPE_BELT     => array(ConfigDefine::USER_ATTRIBUTE_BLOOD => 40),
            Equip::EQUIP_TYPE_SHOES    => array(ConfigDefine::USER_ATTRIBUTE_QUICK =>8),
        );

        return $ret;
    }
	
	//装备附加属性列表
	public static function equipAttributeList()
	{
		$equipAttributeList = array(
			ConfigDefine::USER_ATTRIBUTE_HURT => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_PSYCHIC => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_MAGIC => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_HIT => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_DODGE => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_DEFENSE => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_SPEED => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_BLOOD => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_POWER => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_QUICK => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_PHYSIQUE => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),
			ConfigDefine::USER_ATTRIBUTE_ENDURANCE => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.05),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.05, 0.1),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.1, 0.15),
				Equip::EQUIP_QUALITY_HOLY => array(0.15, 0.20),
			),

			ConfigDefine::USER_ATTRIBUTE_LUCKY => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 4),
				Equip::EQUIP_QUALITY_SUBLIME => array(3, 7),
				Equip::EQUIP_QUALITY_HOLY => array(8, 8),
			),

			ConfigDefine::RELEASE_PROBABILITY => array(
				Equip::EQUIP_QUALITY_GENERAL => array(0.01, 0.03),
				Equip::EQUIP_QUALITY_ADVANCED => array(0.04, 0.06),
				Equip::EQUIP_QUALITY_SUBLIME => array(0.07, 0.09),
				Equip::EQUIP_QUALITY_HOLY => array(0.1, 0.12),
			),

			ConfigDefine::SKILL_ZJ => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_LJ => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_LSYZ => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_SWZH => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_HFHY => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_WFX => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_FFX => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_GX => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_FX => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_DZ => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_FY => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_FJ => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
			ConfigDefine::SKILL_FD => array(
				Equip::EQUIP_QUALITY_GENERAL => array(1, 1),
				Equip::EQUIP_QUALITY_ADVANCED => array(2, 3),
				Equip::EQUIP_QUALITY_SUBLIME => array(4, 4),
				Equip::EQUIP_QUALITY_HOLY => array(5, 5),
			),
		);
		return $equipAttributeList;
	}
	//根据种族和装备部位，返回对应的属性相关信息
	public static function getEquipSuitAttributeByRaceIdAndEquipType($raceId, $equipType)
	{
		if(!$raceId || !$equipType)return array();
		$equipSuitAttributeList = self::equipSuitAttributeList();
		if(is_array($equipSuitAttributeList) && isset($equipSuitAttributeList[$raceId][$equipType]))
		{
			return $equipSuitAttributeList[$raceId][$equipType];
		}
		return array();
	}
	//套装必带属性
	public static function equipSuitAttributeList()
	{
		$equipSuitAttributeList = array(
			//人族
			Race::RACE_HUMAN => array(
				Equip::EQUIP_TYPE_ARMS => array(
					array(ConfigDefine::SKILL_DZ => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_HELMET => array(
					array(ConfigDefine::SKILL_DZ => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_NECKLACE => array(
					array(ConfigDefine::SKILL_DZ => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_CLOTHES => array(
					array(ConfigDefine::SKILL_DZ => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_BELT => array(
					array(ConfigDefine::SKILL_DZ => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_SHOES => array(
					array(ConfigDefine::SKILL_DZ => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
			),
			//仙族
			Race::RACE_TSIMSHIAN => array(
				Equip::EQUIP_TYPE_ARMS => array(
					array(ConfigDefine::SKILL_FX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_HELMET => array(
					array(ConfigDefine::SKILL_FX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_NECKLACE => array(
					array(ConfigDefine::SKILL_FX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_CLOTHES => array(
					array(ConfigDefine::SKILL_FX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_BELT => array(
					array(ConfigDefine::SKILL_FX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_SHOES => array(
					array(ConfigDefine::SKILL_FX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
			),
			//魔族
			Race::RACE_DEMON => array(
				Equip::EQUIP_TYPE_ARMS => array(
					array(ConfigDefine::SKILL_GX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_HELMET => array(
					array(ConfigDefine::SKILL_GX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_NECKLACE => array(
					array(ConfigDefine::SKILL_GX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_CLOTHES => array(
					array(ConfigDefine::SKILL_GX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_BELT => array(
					array(ConfigDefine::SKILL_GX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
				Equip::EQUIP_TYPE_SHOES => array(
					array(ConfigDefine::SKILL_GX => 1,),
					array(ConfigDefine::USER_ATTRIBUTE_LUCKY => 0.5, ConfigDefine::RELEASE_PROBABILITY => 0.5,),
				),
			),
		);
		return $equipSuitAttributeList;
	}
}
