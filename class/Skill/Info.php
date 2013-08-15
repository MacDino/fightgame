<?php
class Skill_Info {
    CONST TN_SKILL_INFO = 'user_skill_info';
    CONST TN_SKILL_ALLOWED = 'level_allow_skill_num';
    CONST TN_SKILL_POINT = 'level_skill_point';

    /**
     * @desc 获取角色技能等级
     */
    public static function getSkillByRoleId($role_id){
        $where      = array(
            'role_id' => $role_id,
        );
        $skill_info = MySql::selectOne(self::TN_SKILL_INFO, $where);
        return $skill_info;
    }

    /**
     * @desc 技能学习
     */
    public static function updateSkillByRoleId(){
    }
}
