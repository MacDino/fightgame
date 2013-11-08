<?php
/**
 * 基础的技能的释放概率
 * @author lishengwei
 */
class Skill_Rate {

    //获得基础的攻击技能释放概率
    public static function getAttackRates() {
        return array(
            1 => 0.25,
            2 => 0.3,
            3 => 0.35,
            4 => 0.4,
            5 => 0.45
        );
    }

    //获得基础的防御技能释放概率
    public static function getDefineRates() {
        return array(
            1 => 0.2,
        );
    }
}