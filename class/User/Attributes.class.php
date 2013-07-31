<?php
class User_Attributes
{
    CONST USER_ATTRIBUTE_POWER        = 1;//力量 - 基本属性
    CONST USER_ATTRIBUTE_MAGIC_POWER  = 2;//魔力 - 基本属性
    CONST USER_ATTRIBUTE_PHYSIQUE     = 3;//体质 - 基本属性
    CONST USER_ATTRIBUTE_ENDURANCE    = 4;//耐力 - 基本属性
    CONST USER_ATTRIBUTE_QUICK        = 5;//敏捷 - 基本属性

    CONST USER_ATTRIBUTE_HIT          = 6;//命中 - 成长属性
    CONST USER_ATTRIBUTE_HURT         = 7;//伤害 - 成长属性
    CONST USER_ATTRIBUTE_MAGIC        = 8;//魔法 - 成长属性
    CONST USER_ATTRIBUTE_BLOOD        = 9;//气血 - 成长属性
    CONST USER_ATTRIBUTE_PSYCHIC      = 10;//灵力 - 成长属性
    CONST USER_ATTRIBUTE_SPEED        = 11;//速度 - 成长属性
    CONST USER_ATTRIBUTE_DEFENSE      = 12;//防御 - 成长属性
    CONST USER_ATTRIBUTE_DODGE        = 13;//躲闪 - 成长属性
    CONST USER_ATTRIBUTE_LUCKY        = 14;//幸运 - 成长属性



    //获取某种族在某等级属性
    public static function getInfoByRaceAndLevel($raceId, $level, $needGrowUpAttribute = FALSE)
    {
        if(!$raceId || !$level)return FALSE;
        $raceId = (int)$raceId;
        $level = (int)$level;
        $defautlAttributes = Race::getDefaultAttributes($raceId);
        if(!is_array($defautlAttributes))return FALSE;
        if($level <= User::DEFAULT_USER_LEVEL)
        {
            $res = $defautlAttributes;
        }else{
            $addAttributesList = Race::getLeveUpAddAttributes($raceId);
            if(!is_array($addAttributesList))return FALSE;
            foreach($defautlAttributes as $key => &$value)
            {
                if(isset($addAttributesList[$key]))
                {
                    $value += $addAttributesList[$key]*$level;
                }
            }
            unset($value);
            $res = $defautlAttributes;
        } 
        if($needGrowUpAttribute)
        {
            $growUpAttributes = Race::getGrowUpAttributes($raceId, $res);
            $res += $growUpAttributes;
        }
        return $res;
    }

    //获取属性名称
    public static function getAttributeName($attributeId)
    {
        if(!$attributeId || (int)$attributeId < 1)return FALSE;
        $attributesNameList = self::_attributesNameList();
        if(is_array($attributesNameList) && isset($attributesNameList[$attributeId]))
        {
            return $attributesNameList[$attributeId];
        }
        return FALSE;
    }
    private static function _attributesNameList()
    {
        $attributesNameList = array(
            self::USER_ATTRIBUTE_POWER        => '力量',
            self::USER_ATTRIBUTE_MAGIC_POWER  => '魔力',
            self::USER_ATTRIBUTE_PHYSIQUE     => '体质',
            self::USER_ATTRIBUTE_ENDURANCE    => '耐力',
            self::USER_ATTRIBUTE_QUICK        => '敏捷',
            self::USER_ATTRIBUTE_HIT          => '命中',
            self::USER_ATTRIBUTE_HURT         => '伤害',
            self::USER_ATTRIBUTE_MAGIC        => '魔法',
            self::USER_ATTRIBUTE_BLOOD        => '气血',
            self::USER_ATTRIBUTE_PSYCHIC      => '灵力',
            self::USER_ATTRIBUTE_SPEED        => '速度',
            self::USER_ATTRIBUTE_DEFENSE      => '防御',
            self::USER_ATTRIBUTE_DODGE        => '躲闪',
            self::USER_ATTRIBUTE_LUCKY        => '幸运',
        );
        return $attributesNameList;
    }
}
