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
        $const  = Skill_Common::wlgjConst($attributes['role_level'], $attributes['power']);
        extract($const);
        $hurt   = $hurt + $rand5 + ($attributes['hit'] + 12 * $attrubutes['skill_level']) / 3 + $attributes['hurt'] + $randPower;
        $hurt   = $hurt * $rate;
        $hurt   = $hurt - $attributes['base_defense'] - $attributes['skill_defense'];
        $hurt   = $hurt * (1.5 + 0.01 * $attributes['skill_level']);
        return $hurt;
    }

    /**
     * @desc 连击技能公式,三次攻击
     *
     * return array array(第一次攻击值,...)
     */
    public static function ljSkillFormula($attributes){
        $hurt       = 0;
        $const  = Skill_Common::wlgjConst($attributes['role_level'], $attributes['power']);
        extract($const);
        $hurt       = $hurt + $rand5 + $attributes['hit'] / 3 + $attributes['hurt'] + 4 * $attributes['skill_level'] + $randPower;  
        $hurt       = $hurt * $rate;
        $hurt_arr   = array(
            0.7 * $hurt - $attributes['base_defense'] - $attributes['skill_defense'],
            0.8 * $hurt - $attributes['base_defense'] - $attributes['skill_defense'],
            $hurt - $attributes['base_defense'] - $attributes['skill_defense']
        );
        return $hurt_arr;
    }
    
    /**
     * @desc 灵犀一指技能公式
     *
     * return int 伤害值
     */
    public static function lxyzSkillFormula($attributes){
        //消耗50魔法
        $hurt   = 0;
        $const  = Skill_Common::wlgjConst($attributes['role_level'], $attributes['power']);
        extract($const);
        $hurt   = $hurt + $rand5 + ($attributes['hit'] + 4 * $attributes['skill_level']) / 3 + $attributes['hurt'] + 2 * $attributes['skill_level'] + $randPower; 
        $hurt   = $hurt * $rate;
        $hurt   = $hurt - $attributes['base_defense'] - $attributes['skill_defense'] + (20 + 4 * $attributes['skill_level']);
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
        $const  = Skill_Common::fsgjConst($attributes['role_level'], $attributes['hurt']);
        extract($const);
        $hurt       = $attributes['psychic'] + 4 * $attributes['skill_level'] + $hurt_rand + 1.3 * $attributes['skill_level'];
        $hurt       = $hurt - $attributes['op_psychic'] - $attributes['op_skill_psychic'];
        $hurt       = (0.01 * $attribtues['skill_level'] + 1.5) * $hurt + $rand5;
        return $hurt;
    }

    /**
     * @desc 呼风唤雨技能公式
     *
     * return array array(第一次攻击值，第二次攻击值)
     */
    public static function hfhySkillFormula($attributes){
        //每次攻击30点魔法,每次魔法判断
        $hurt   = 0;
        $const  = Skill_Common::fsgjConst($attributes['role_level'], $attributes['hurt']);
        extract($const);
        $hurt   = $attributes['psychic'] + 3 * $attributes['skill_level'] + $hurt_rand + 1.2 * $attributes['skill_level'];
        $hurt   = $hurt * $rate;
        $hurt   = $hurt - $attributes['op_psychic'] - $attributes['op_skill_psychic'];
        $hurt   = $hurt + $rand5;
        return array($hurt, $hurt);
    }

    /**
     * @desc 五雷决技能公式
     *
     * return int 伤害值
     */
    public static function wljSkillFormula($attributes){
        //20点魔法
        $hurt   = 0;
        $const  = Skill_Common::fsgjConst($attributes['role_level'], $attributes['hurt']);
        extract($const);
        $hurt   = $attributes['psychic'] + $attributes['skill_level'] + $hurt_rand + 1.1 * $attributes['skill_level'];
        $hurt   = $hurt * $rate;
        $hurt   = $hurt - $attributes['op_psychic'] - $attributes['op_skill_psychic'];
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
        $attributes['defense_result']   = 0.02 * $attributes['defense_result'] + 5;
        $attributes['blood']            = 0.01 * $attributes['blood']; 
        $attributes['dodge']            = 0.005 * $attributes['dodge'];
        $attributes['psychic']          = -0.005 * $attributes['psychic'];
        return $attributes;
    }

    /**
     * @desc 法防修技能公式
     *
     * return array array(法术防御，气血，躲避，防御)
     */
    public static function ffxSkillFormula($attributes){
        $attributes['magic_result'] = 0.02 * $attributes['magic_result'] + 5;
        $attributes['blood']        = 0.01 * $attributes['blood'];
        $attribtues['dodge']        = 0.005 * $attributes['dodge'];
        $attributes['defense']      = -0.005 * $attributes['defense'];
        return $attributes;
    }

    /**
     * @desc 功修技能公式
     *
     * return array array(伤害结果，伤害，命中)
     */
    public static function gxSkillFormula($attributes){
        $attributes['hurt_result']  = 0.02 * $attributes['hurt_result'] + 5;
        $attributes['hurt']         = 3;
        $attributes['hit']          = 4;
        return $attributes;
    }

    /**
     * @desc 法修技能公式
     *
     * return array array(伤害，灵力，魔法)
     */
    public static function fxSkillFormula($attributes){
        $attributes['hurt_result']  = 0.02 * $attributes['hurt_result'] + 5;
        $attributes['psychic']      = 3;
        $attributes['magic']        = 4;
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
