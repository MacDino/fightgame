<?php

class Skill_Config
{
    /**
     * @desc 重击技能公式
     *
     * return int 伤害值
     */
    public static function zjSkillFormula(){
    }

    /**
     * @desc 连击技能公式,三次攻击
     *
     * return array array(第一次攻击值,...)
     */
    public static function ljSkillFormula(){
    }
    
    /**
     * @desc 灵犀一指技能公式
     *
     * return int 伤害值
     */
    public static function lxyzSkillFormula(){
        //消耗50魔法
    }
   
    /**
     * @desc 三味真火技能公式
     *
     * return int 伤害值
     */
    public static function swzhSkillFormula(){
        //消耗70魔法
    }

    /**
     * @desc 呼风唤雨技能公式
     *
     * return array array(第一次攻击值，第二次攻击值)
     */
    public static function hfhySkillFormula(){
        //每次攻击30点魔法
    }

    /**
     * @desc 五雷决技能公式
     *
     * return int 伤害值
     */
    public static function wljSkillFormula(){
    }

    /*****  被动技能    *****/

    /**
     * @desc 物防修技能公式
     *
     * return array array(物理防御，气血，躲避，灵力)
     */
    public static function wfxSkillFormula(){
    }

    /**
     * @desc 法防修技能公式
     *
     * return array array(法术防御，气血，躲避，防御)
     */
    public static function ffxSkillFormula(){
    }

    /**
     * @desc 功修技能公式
     *
     * return array array(伤害，，命中)
     */
    public static function gxSkillFormula(){
    }

    /**
     * @desc 法修技能公式
     *
     * return array array(伤害，灵力，魔法)
     */
    public static function fxSkillFormula(){
    }

    /**
     * @desc 锻造技能公式
     *
     * return array array(敏捷，成功率，失败后不掉锻造等级概率)
     */
    public static function dzSkillFormula(){
    }

    /*****  防御技能，概率触发  *****/

    /**
     * @desc 防御技能公式
     *
     * return int 防御值
     */
    public static function fySkillFormula(){
    }

    /**
     * @desc 反击技能公式
     *
     * return int 伤害值
     */
    public static function fjSkillFormula(){
    }

    /**
     * @desc 法盾技能公式
     *
     * return int 灵力值
     */
    public static function fdSkillFormula(){
    }
}
