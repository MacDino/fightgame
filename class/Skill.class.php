<?php
//技能
class Skill
{
    CONST SKILL_ZJ      = 1;//重击
    CONST SKILL_LSYZ    = 2;//灵犀一指
    CONST SKILL_SWZH    = 3;//三昧真火
    CONST SKILL_HFHY    = 4;//呼风唤雨 
    CONST SKILL_WLJ     = 5;//五雷决
    CONST SKILL_WFX     = 6;//物防修 
    CONST SKILL_FFX     = 7;//法防修
    CONST SKILL_GX      = 8;//攻修
    CONST SKILL_FX      = 9;//法修
    CONST SKILL_DZ      = 10;//锻造
    CONST SKILL_FY      = 11;//防御
    CONST SKILL_FJ      = 12;//反击
    CONST SKILL_FD      = 13;//法盾
      
    CONST SKILL_GROUP_WLGJ = 1;//物理攻击
    CONST SKILL_GROUP_FSGJ = 2;//法术攻击
    CONST SKILL_GROUP_BDJN = 3;//被动技能
    CONST SKILL_GROUP_FYJN = 4;//防御技能

    //技能组及对应技能
    public static function skillGroupList()
    {
        $skillGroupList = array(
            self::SKILL_GROUP_WLGJ => array(self::SKILL_ZJ, self::SKILL_LSYZ,),
            self::SKILL_GROUP_FSGJ => array(self::SKILL_SWZH, self::SKILL_HFHY, self::SKILL_WLJ,),
            self::SKILL_GROUP_BDJN => array(self::SKILL_WFX, self::SKILL_FFX, self::SKILL_GX, self::SKILL_FX, self::SEILL_DZ,),
            self::SKILL_GROUP_FYJN => array(self::SKILL_FY, self::SKILL_FJ, self::SKILL_FD),
        );
    }
    //技能分组名称
    private static function _skillGroupNameList()
    {
        $skillGroupNameList = array(
            self::SKILL_GROUP_WLGJ => '物理攻击',
            self::SKILL_GROUP_FSGJ => '法术攻击',
            self::SKILL_GROUP_BDJN => '被动技能',
            self::SKILL_GROUP_FYJN => '防御技能',
        );
        return $skillGroupNameList;
    }
    //技能列表
    private static function _skillNameList()
    {
        $skillNameList = array(
            self::SKILL_ZJ      => '重击', 
            self::SKILL_LSYZ    => '灵犀一指',
            self::SKILL_SWZH    => '三昧真火', 
            self::SKILL_HFHY    => '呼风唤雨', 
            self::SKILL_WLJ     => '五雷决',
            self::SKILL_WFX     => '物防修', 
            self::SKILL_FFX     => '法防修', 
            self::SKILL_GX      => '攻修', 
            self::SKILL_FX      => '法修', 
            self::SKILL_DZ      => '锻造'
            self::SKILL_FY      => '防御', 
            self::SKILL_FJ      => '反击', 
            self::SKILL_FD      => '法盾',
          );
        return $skillNameList;
    }
}
