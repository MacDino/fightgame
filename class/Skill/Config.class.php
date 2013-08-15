<?php

class Skill_Config
{
    /**
     * @desc 重击技能公式
     *
     * return int 伤害值
     */
    public static function zjSkillFormula($attributes){
        $hurt   = 0;
        $const  = Skill_Common::wlgjConst($attributes['user_level'], $attributes[ConfigDefine::USER_ATTRIBUTE_POWER]);
        extract($const);
        $hurt   = $hurt + $rand5 + ($attributes[ConfigDefine::USER_ATTRIBUTE_HIT] + 12 * $attrubutes['skill_level']) / 3 + $attributes[ConfigDefine::USER_ATTRIBUTE_HURT] + $randPower;
        $hurt   = $hurt * $rate;
        $hurt   = $hurt - $attributes['op_defense'];
        $hurt   = $hurt * (1.5 + 0.01 * $attributes['skill_level']);
        return $hurt;
    }

    /**
     * @desc 连击技能公式,三次攻击
     *
     */
    public static function ljSkillFormula($attributes){
        $hurt       = 0;
        $const  = Skill_Common::wlgjConst($attributes['user_level'], $attributes[ConfigDefine::USER_ATTRIBUTE_POWER]);
        extract($const);
        $hurt       = $hurt + $rand5 + $attributes[ConfigDefine::USER_ATTRIBUTE_HIT] / 3 + $attributes[ConfigDefine::USER_ATTRIBUTE_HURT] + 4 * $attributes['skill_level'] + $randPower;  
        $hurt       = $hurt * $rate;
        $hurt_all   = 1.5 * $hurt - 3 * $attributes['op_defense'];
        /*
            0.7 * $hurt - $attributes['op_defense'],
            0.8 * $hurt - $attributes['op_defense'],
            $hurt - $attributes['op_defense']
         */
        return $hurt_all;
    }
    
    /**
     * @desc 灵犀一指技能公式
     *
     * return int 伤害值
     */
    public static function lxyzSkillFormula($attributes){
        //消耗50魔法
        $hurt   = 0;
        $const  = Skill_Common::wlgjConst($attributes['user_level'], $attributes[ConfigDefine::USER_ATTRIBUTE_POWER]);
        extract($const);
        $hurt   = $hurt + $rand5 + ($attributes[ConfigDefine::USER_ATTRIBUTE_HIT] + 4 * $attributes['skill_level']) / 3 + $attributes[ConfigDefine::USER_ATTRIBUTE_HURT] + 2 * $attributes['skill_level'] + $randPower; 
        $hurt   = $hurt * $rate;
        $hurt   = $hurt - $attributes['op_defense'] + (20 + 4 * $attributes['skill_level']);
        return $hurt;
    }
   
    /**
     * @desc 三味真火技能公式
     *
     * return int 伤害值
     */
    public static function swzhSkillFormula($attributes){
        //消耗70魔法,魔法值不够，技能使用失败
        $hurt       = 0;
        $const      = Skill_Common::fsgjConst($attributes['user_level'], $attributes[ConfigDefine::USER_ATTRIBUTE_HURT]);
        extract($const);
        $hurt       = $attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] + 4 * $attributes['skill_level'] + $hurt_rand + 1.3 * $attributes['skill_level'];
        $hurt       = $hurt - $attributes['op_psychic'];
        $hurt       = (0.01 * $attribtues['skill_level'] + 1.5) * $hurt + $rand5;
        return $hurt;
    }

    /**
     * @desc 呼风唤雨技能公式
     *
     */
    public static function hfhySkillFormula($attributes){
        //每次攻击30点魔法,每次魔法判断
        $hurt   = 0;
        $const  = Skill_Common::fsgjConst($attributes['user_level'], $attributes[ConfigDefine::USER_ATTRIBUTE_HURT]);
        extract($const);
        $hurt   = $attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] + 3 * $attributes['skill_level'] + $hurt_rand + 1.2 * $attributes['skill_level'];
        $hurt   = $hurt * $rate;
        $hurt   = $hurt - $attributes['op_psychic'];
        $hurt   = $hurt + $rand5;
        return 2 * $hurt;
    }

    /**
     * @desc 五雷决技能公式
     *
     * return int 伤害值
     */
    public static function wljSkillFormula($attributes){
        //20点魔法
        $hurt   = 0;
        $const  = Skill_Common::fsgjConst($attributes['user_level'], $attributes[ConfigDefine::USER_ATTRIBUTE_HURT]);
        extract($const);
        $hurt   = $attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] + $attributes['skill_level'] + $hurt_rand + 1.1 * $attributes['skill_level'];
        $hurt   = $hurt * $rate;
        $hurt   = $hurt - $attributes['op_psychic'];
        $hurt   = $hurt + $rand5;
        return $hurt;
    }

    /*****  被动技能    *****/
    /*****  负责对应属性每一级加成与减少    *****/

    /**
     * @desc 物防修技能公式
     *
     * return array array(物理防御，气血，躲避，灵力)
     */
    public static function wfxSkillFormula($attributes){
        //增加自身属性
        $attrAdd[ConfigDefine::USER_ATTRIBUTE_BLOOD]    = 0.01 * $attributes[ConfigDefine::USER_ATTRIBUTE_BLOOD]; 
        $attrAdd[ConfigDefine::USER_ATTRIBUTE_DODGE]    = 0.005 * $attributes[ConfigDefine::USER_ATTRIBUTE_DODGE];
        $attrAdd[ConfigDefine::USER_ATTRIBUTE_PSYCHIC]  = -0.005 * $attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC];
        return $attrAdd;
    }

    /**
     * @desc 法防修技能公式
     *
     * return array array(法术防御，气血，躲避，防御)
     */
    public static function ffxSkillFormula($attributes){
        //增加自身属性
        $attrAdd[ConfigDefine::USER_ATTRIBUTE_BLOOD]    = 0.01 * $attributes[ConfigDefine::USER_ATTRIBUTE_BLOOD];
        $attrAdd[ConfigDefine::USER_ATTRIBUTE_DODGE]    = 0.005 * $attributes[ConfigDefine::USER_ATTRIBUTE_DODGE];
        $attrAdd[ConfigDefine::USER_ATTRIBUTE_DEFENSE]  = -0.005 * $attributes[ConfigDefine::USER_ATTRIBUTE_DEFENSE];
        return $attrAdd;
    }

    /**
     * @desc 功修技能公式
     *
     * return array array(伤害结果，伤害，命中)
     */
    public static function gxSkillFormula($attributes){
        //自身属性
        $attrAdd[ConfigDefine::USER_ATTRIBUTE_HURT]         = 3;
        $attrAdd[ConfigDefine::USER_ATTRIBUTE_HIT]          = 4;
        return $attrAdd;
    }

    /**
     * @desc 法修技能公式
     *
     * return array array(伤害，灵力，魔法)
     */
    public static function fxSkillFormula($attributes){
        //自身属性
        $attributes[ConfigDefine::USER_ATTRIBUTE_PSYCHIC]   = 3;
        $attributes[ConfigDefine::USER_ATTRIBUTE_MAGIC]     = 4;
        return $attributes;
    }

    /**
     * @desc 锻造技能公式
     *
     * return array array(敏捷，成功率，失败后不掉锻造等级概率)
     */
    public static function dzSkillFormula(){
        $attributes['quick']    = 2;
        //装备强化成功率和失败率 todo
        return $attributes;
    }

    /*****  防御技能，概率触发  *****/

    /**
     * @desc 防御技能公式
     *
     * return int 增加的防御值
     */
    public static function fySkillFormula($skill_level){
        if($skill_level){
            return 4 + $skill_level;
        }
        return 0;
    }

    /**
     * @desc 反击技能公式
     *
     * return int 增加的伤害百分比
     */
    public static function fjSkillFormula($skill_level){
        if($skill_level){
            return 0.49 + 0.01 * $skill_level;
        }
        return 0;
    }

    /**
     * @desc 法盾技能公式
     *
     * return int 增加的灵力值
     */
    public static function fdSkillFormula($skill_level){
        if($skill_level){
            return 8 + 2 * $skill_level;
        }
        return 0;
    }
}
