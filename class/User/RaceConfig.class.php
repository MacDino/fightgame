<?php
class User_RaceConfig
{
	/**
	 * 种族初始化属性点
	 * @return array
	 */
    public static function defaultAttributesList()
    {
        $defaultAttributesList = array(
            User_Race::RACE_HUMAN => 
                array(ConfigDefine::USER_ATTRIBUTE_POWER       => 10,
                      ConfigDefine::USER_ATTRIBUTE_QUICK       => 10,
                      ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 10,
                      ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 10,
                      ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 10,
                      ConfigDefine::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
            User_Race::RACE_TSIMSHIAN => 
                array(ConfigDefine::USER_ATTRIBUTE_POWER       => 11,
                      ConfigDefine::USER_ATTRIBUTE_QUICK       => 10,
                      ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 12,
                      ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 5,
                      ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 12,
                      ConfigDefine::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
            User_Race::RACE_DEMON => 
                array(ConfigDefine::USER_ATTRIBUTE_POWER       => 11,
                      ConfigDefine::USER_ATTRIBUTE_QUICK       => 8,
                      ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 12,
                      ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 11,
                      ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 8,
                      ConfigDefine::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
        );
        return $defaultAttributesList;
    }
    
    /**
     * 种族升级对应增加属性点
     * @return array
     */
    public static function levelUpAddAttributesList()
    {
        $leveUpAddAttributtesList = array(
            User_Race::RACE_HUMAN => 
                array(ConfigDefine::USER_ATTRIBUTE_POWER       => 2,
                      ConfigDefine::USER_ATTRIBUTE_QUICK       => 2,
                      ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 2,
                      ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 2,
                      ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 2,
                      ConfigDefine::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
            User_Race::RACE_TSIMSHIAN => 
                array(ConfigDefine::USER_ATTRIBUTE_POWER       => 1.5,
                      ConfigDefine::USER_ATTRIBUTE_QUICK       => 1.5,
                      ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 1.5,
                      ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 3,
                      ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 2.5,
                      ConfigDefine::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
            User_Race::RACE_DEMON => 
                array(ConfigDefine::USER_ATTRIBUTE_POWER       => 2.5,
                      ConfigDefine::USER_ATTRIBUTE_QUICK       => 2,
                      ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => 2.5,
                      ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => 1.5,
                      ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => 1.5,
                      ConfigDefine::USER_ATTRIBUTE_LUCKY       => 0,
                     ),
        );
        return $leveUpAddAttributtesList;
    }
    
    /**
     * 魔族成长属性计算公式
     * @param array $userAttributes
     * @return array
     */
    public static function demonGrowUpAttributesFormula($userAttributes)
    {
        $demonGrowUpAttributes = array(
            ConfigDefine::USER_ATTRIBUTE_HURT     => 34 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.77,
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC  => $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.4 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*0.3 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER]*0.7 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*0.2,
            ConfigDefine::USER_ATTRIBUTE_MAGIC    => 80 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER]*2.5,
            ConfigDefine::USER_ATTRIBUTE_HIT      => 27 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*2.31,
            ConfigDefine::USER_ATTRIBUTE_DODGE    => $userAttributes[ConfigDefine::USER_ATTRIBUTE_QUICK]*1,
            ConfigDefine::USER_ATTRIBUTE_DEFENSE  => $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*1.4,
            ConfigDefine::USER_ATTRIBUTE_SPEED    => $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.1 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_QUICK]*0.7 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*0.1 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*0.1,
            ConfigDefine::USER_ATTRIBUTE_BLOOD    => 100 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*6,
            ConfigDefine::USER_ATTRIBUTE_LUCKY	  => 0,
              );
        return $demonGrowUpAttributes;
    }
    
    /**
     * 仙族成长属性计算公式
     * @param array $userAttributes
     * @return array
     */
    public static function tsimshianGrowUpAttributesFormula($userAttributes)
    {
        $tsimshianGrowUpAttributes = array(
            ConfigDefine::USER_ATTRIBUTE_HURT     => 40 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.57,
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC  => $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.4 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*0.3 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER]*0.7 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*0.2,
            ConfigDefine::USER_ATTRIBUTE_MAGIC    => 80 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER]*3.5,
            ConfigDefine::USER_ATTRIBUTE_HIT      => 30 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*1.71,
            ConfigDefine::USER_ATTRIBUTE_DODGE    => $userAttributes[ConfigDefine::USER_ATTRIBUTE_QUICK]*1,
            ConfigDefine::USER_ATTRIBUTE_DEFENSE  => $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*1.6,
            ConfigDefine::USER_ATTRIBUTE_SPEED    => $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.1 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_QUICK]*0.7 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*0.1 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*0.1,
            ConfigDefine::USER_ATTRIBUTE_BLOOD    => 100 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*4.5,
            ConfigDefine::USER_ATTRIBUTE_LUCKY	  => 0,
              );
        return $tsimshianGrowUpAttributes;
    }
    
    /**
     * 人族成长属性计算公式
     * @param array $userAttributes
     * @return array
     */
    public static function humanGrowUpAttributesFormula($userAttributes)
    {
        $humanGrowUpAttributes =  array(
            ConfigDefine::USER_ATTRIBUTE_HURT     => 34 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.67,
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC  => $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.4 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*0.3 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER]*0.7 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*0.2,
            ConfigDefine::USER_ATTRIBUTE_MAGIC    => 80 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER]*3,
            ConfigDefine::USER_ATTRIBUTE_HIT      => 30 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*2.01,
            ConfigDefine::USER_ATTRIBUTE_DODGE    => $userAttributes[ConfigDefine::USER_ATTRIBUTE_QUICK]*1,
            ConfigDefine::USER_ATTRIBUTE_DEFENSE  => $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*1.5,
            ConfigDefine::USER_ATTRIBUTE_SPEED    => $userAttributes[ConfigDefine::USER_ATTRIBUTE_POWER]*0.1 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_QUICK]*0.7 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*0.1 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_ENDURANCE]*0.1,
            ConfigDefine::USER_ATTRIBUTE_BLOOD    => 100 + $userAttributes[ConfigDefine::USER_ATTRIBUTE_PHYSIQUE]*5,
            ConfigDefine::USER_ATTRIBUTE_LUCKY	  => 0,
              );
        return $humanGrowUpAttributes;
    }
}
