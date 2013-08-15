<?php
//技能
class Skill
{      
    CONST SKILL_GROUP_WLGJ = 1;//物理攻击
    CONST SKILL_GROUP_FSGJ = 2;//法术攻击
    CONST SKILL_GROUP_BDJN = 3;//被动技能
    CONST SKILL_GROUP_FYJN = 4;//防御技能

    CONST DEFAULT_SKILL_POINT   = 3;//默认用户拥有的技能点

    /** 数据库字段映射 */
    public static $skill_map    = array(
        'zj'    => ConfigDefine::SKILL_ZJ,
        'lj'    => ConfigDefine::SKILL_LJ,
        'lsyz'  => ConfigDefine::SKILL_LSYZ,
        'swzh'  => ConfigDefine::SKILL_SWZH,
        'hfhy'  => ConfigDefine::SKILL_HFHY,
        'wlj'   => ConfigDefine::SKILL_WLJ,
        'wfx'   => ConfigDefine::SKILL_WFX,
        'ffx'   => ConfigDefine::SKILL_FFX,
        'gx'    => ConfigDefine::SKILL_GX,
        'fx'    => ConfigDefine::SKILL_FX,
        'dz'    => ConfigDefine::SKILL_DZ,
        'fy'    => ConfigDefine::SKILL_FY,
        'fj'    => ConfigDefine::SKILL_FJ,
        'fd'    => ConfigDefine::SKILL_FD,
        );

    /** 主动技能属性加成 */
    private static $_skill_attributes    = array(
        ConfigDefine::SKILL_ZJ  => array(
            ConfigDefine::USER_ATTRIBUTE_HIT    => 12
            ),
        ConfigDefine::SKILL_LJ  => array(
            ConfigDefine::USER_ATTRIBUTE_HURT   => 3
            ),
        ConfigDefine::SKILL_SWZH  => array(
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC    => 4
            ),
        ConfigDefine::SKILL_HFHY  => array(
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC    => 3
            ),
        ConfigDefine::SKILL_WLJ  => array(
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC    => 1
            )
        );

    //技能组及对应技能
    public static function skillGroupList()
    {
        $skillGroupList = array(
            self::SKILL_GROUP_WLGJ => array(ConfigDefine::SKILL_ZJ, ConfigDefine::SKILL_LSYZ,),
            self::SKILL_GROUP_FSGJ => array(ConfigDefine::SKILL_SWZH, ConfigDefine::SKILL_HFHY, ConfigDefine::SKILL_WLJ,),
            self::SKILL_GROUP_BDJN => array(ConfigDefine::SKILL_WFX, ConfigDefine::SKILL_FFX, ConfigDefine::SKILL_GX, ConfigDefine::SKILL_FX, ConfigDefine::SEILL_DZ,),
            self::SKILL_GROUP_FYJN => array(ConfigDefine::SKILL_FY, ConfigDefine::SKILL_FJ, ConfigDefine::SKILL_FD),
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

    //用户技能等级上限
    public static function skillLevelLimit($userLevel = 0)
    {
        return $userLevel + 10; 
    }
    //技能释放概率，基本释放概率和最高释放概率
    public static function skillUseProbability()
    {
        //canUserSkillNum => array(baseUseProbability => array(gj => 0.1, fy => 0.1), maxUseProbability => array(gj => 0.1 , fy => 0.1))
        $configList = array(
            1 => array(
                'baseUseProbability' => array('gj' => 0.25, 'fy' => 0.2),
                'maxUseProbability'  => array('gj' => 0.7, 'fy' => 0.6),
            ),
            2 => array(
                'baseUseProbability' => array('gj' => 0.3, 'fy' => 0.25),
                'maxUseProbability'  => array('gj' => 0.75, 'fy' => 0.65),
            ),
            3 => array(
                'baseUseProbability' => array('gj' => 0.35, 'fy' => 0.3),
                'maxUseProbability'  => array('gj' => 0.8, 'fy' => 0.7),
            ),
            4 => array(
                'baseUseProbability' => array('gj' => 0.4, 'fy' => 0.35),
                'maxUseProbability'  => array('gj' => 0.85, 'fy' => 0.75),
            ),
            5 => array(
                'baseUseProbability' => array('gj' => 0.45, 'fy' => 0.4),
                'maxUseProbability'  => array('gj' => 0.9, 'fy' => 0.8),
            ),
        );
    }

    /**
     * @desc 技能自身属性加成规则 
     *
     */
    public static function getSkillAttributesFormulas(){
    }

    /**
     * @desc 获取额外加成后的角色属性
     * @param $attributes 角色成长属性
     *
     */
    public static function getRoleAttributesWithSkill($role_id, $attributes){
        //装备加成 直接调用
        //道具加成 直接调用
        //主动技能属性加成
        $skill_info     = Skill_Info::getSkillByRoleId($role_id);
        if(!empty($skill_info) && is_array($skill_info)){
            foreach($skill_info as $skill => $level){
                if(in_array($skill, array('id', 'role_id', 'user_id')) || $level == 0){
                    continue;
                }
                $skill      = self::$skill_map[$skill];
                $skill_attr = self::$_skill_attributes[$skill];
                foreach($skill_attr as $attr => $value){
                    $attributes[$attr]  += $value * $level;
                }
            }
        }
        //被动技能加成
    }

    /**
     * @desc 使用技能(主动技能)
     *
     * @param data = array($skill    技能code或缩写
     *                     $role_id  当前角色id
     *                     $op_id    对手id
     *                     $role_type当前角色类型
     *                     $op_id    对手类型
     *                     )
     */
    public static function useSkill($data){
        //$role_info  = User_Info:://TODO
        //成长属性
        $attributes = User_Attributes::getInfoByRaceAndLevel($role_info['race_id'], $role_info['user_level'], TRUE); 
        //技能加成属性
        $attributes = self::getRoleAttributesWithSkill($role_id, $attributes);
        //构造额外需要参数
        $attributes['role_level']   = $role_info['user_level'];
        if(is_numeric($data['skill'])){
            $skill      = array_search($data['skill'], self::$skill_map);
        } else {
            $skill      = $data['skill'];
        }
        $skill_info                 = Skill_Info::getSkillByRoleId($role_id);
        $attribues['skill_level']   = $skill_info[$skill];
        //怪物防御 基本+技能

        return call_user_func(array('Skill_Config', $skill.'SkillFormula'), $attributes);
    }

}
