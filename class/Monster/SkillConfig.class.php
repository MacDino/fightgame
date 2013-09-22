<?php
/**
 * 根据怪物的相关属性
 * 以及前边随即出来的技能和技能等级
 * 计算怪物的技能属性加成
 * @author lishengwei
 */
class Monster_SkillConfig {

    /**
     * 计算生成的怪物所携带的技能
     * 对怪物本身的属性点（所定义的基础属性+扩展属性）
     * 的影响
     * 返回经过加成后的怪物的属性列表
     * **/
    public static function getAttributeBySkillInfos($attributes, $skillInfos, $monster = array()) {
        if(is_array($skillInfos) && count($skillInfos)) {
            foreach ($skillInfos as $skillId => $skillLevel) {
                if($skillLevel == 0) {
                    continue;
                }
                $functionName = self::_getFunctionBySkillId($skillId);
                if($functionName) {
                    $attributes = call_user_func_array(array('self',$functionName), array($attributes, $skillLevel, $monster['race_id']));
                }
            }
        }
        return $attributes;
    }

    private static function _getFunctionBySkillId($skillId) {
        $functionList = self::_getFunctionList();
        return isset($functionList[$skillId]) ? $functionList[$skillId] : '';
    }

    private static function _getFunctionList() {
        return array(
            ConfigDefine::SKILL_ZJ => 'zjAddAttribute',
            ConfigDefine::SKILL_LJ => 'ljAddAttribute',
            ConfigDefine::SKILL_LXYZ => 'lxyzAddAttribute',
            ConfigDefine::SKILL_SWZH => 'swzhAddAttribute',
            ConfigDefine::SKILL_HFHY => 'hfhyAddAttribute',
            ConfigDefine::SKILL_WLJ => 'wljAddAttribute',
            ConfigDefine::SKILL_DZ => 'dzAddAttribute',
            ConfigDefine::SKILL_TX => 'txAddAttribute',
        );
    }

    /**
     * 体修被动技能增加气血
     * **/
    private static function txAddAttribute($attributes, $skillLevel, $raceId) {
        $skillLevel = intval($skillLevel);
        if($skillLevel > 0) {
            $blood = $attributes[ConfigDefine::USER_ATTRIBUTE_BLOOD];
            $attributes[ConfigDefine::USER_ATTRIBUTE_BLOOD] = $blood + $blood * $skillLevel * 0.01;
        }
        return $attributes;
    }

    /**
     * 种族以及技能等级大于0
     * 重击根据技能等级，增加携带者的命中
     * **/
    private static function zjAddAttribute($attributes, $skillLevel, $raceId) {
        $addHit = 0;
        $skillLevel = intval($skillLevel);
        if($skillLevel > 0) {
            switch ($raceId) {
                case User_Race::RACE_HUMAN:
                    $addHit = 2.01 + 0.02*$skillLevel;
                    break;
                case User_Race::RACE_TSIMSHIAN:
                case User_Race::RACE_DEMON:
                    $addHit = 1.01 + 0.02*$skillLevel;
                    break;
            }
        }
        $attributes[ConfigDefine::USER_ATTRIBUTE_HIT] += $addHit;
        return $attributes;
    }

    /**
     * 连击增加的属性伤害点
     * **/
    private static function ljAddAttribute($attributes, $skillLevel, $raceId) {
        $addHurt = 0;
        $skillLevel = intval($skillLevel);
        if($skillLevel > 0) {
            switch ($raceId) {
                case User_Race::RACE_HUMAN:
                    $addHurt = 2.5 + 0.014*$skillLevel;
                    break;
                case User_Race::RACE_TSIMSHIAN:
                    $addHurt = 2.01 + 0.02*$skillLevel;
                    break;
                case User_Race::RACE_DEMON:
                    $addHurt = 2.02 + 0.01*$skillLevel;
                    break;
            }
        }
        $attributes[ConfigDefine::USER_ATTRIBUTE_HURT] += $addHurt;
        return $attributes;
    }

    /**
     * 灵犀一指增加命中和伤害
     * **/
    private static function lxyzAddAttribute($attributes, $skillLevel, $raceId = '') {
        $skillLevel = intval($skillLevel);
        if($skillLevel > 0) {
            $attributes[ConfigDefine::USER_ATTRIBUTE_HIT] += 4*$skillLevel;
            $attributes[ConfigDefine::USER_ATTRIBUTE_HURT] += 2*$skillLevel;
        }
        return $attributes;
    }

    /*
     * 叁味真火增加灵力
     * **/
    private static function swzhAddAttribute($attributes, $skillLevel, $raceId = '') {
        $skillLevel = intval($skillLevel);
        if($skillLevel > 0) {
            $attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] += 2*$skillLevel;
        }
        return $attributes;
    }

    /**
     * 呼风唤雨增加灵力
     * **/
    private static function hfhyAddAttribute($attributes, $skillLevel, $raceId = '') {
        $skillLevel = intval($skillLevel);
        if($skillLevel > 0) {
            $attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] += 1*$skillLevel;
        }
        return $attributes;
    }

    /**
     * 五雷决增加携带者的灵力
     * **/
    private static function wljAddAttribute($attributes, $skillLevel, $raceId = '') {
        $skillLevel = intval($skillLevel);
        if($skillLevel > 0) {
            $attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] += 1*$skillLevel;
        }
        return $attributes;
    }

    /**
     * 锻造增加携带者的躲闪
     * **/
    private static function dzAddAttribute($attributes, $skillLevel, $raceId) {
        $addDodge = $addSpeed = 0;
        $skillLevel = intval($skillLevel);
        if($skillLevel > 0) {
            switch ($raceId) {
                case User_Race::RACE_HUMAN:
                    $addDodge = 2.01 + 0.02*$skillLevel;
                    $addSpeed = 1 + 0.009*$skillLevel;
                    break;
                case User_Race::RACE_TSIMSHIAN:
                case User_Race::RACE_DEMON:
                    $addDodge = 2.01 + 0.02*$skillLevel;
                    break;
            }
        }
        $attributes[ConfigDefine::USER_ATTRIBUTE_DODGE] += $addDodge;
        $attributes[ConfigDefine::USER_ATTRIBUTE_SPEED] += $addSpeed;
        return $attributes;
    }

}
