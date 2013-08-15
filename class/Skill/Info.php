<?php
class Skill_Info {
    CONST TN_SKILL_INFO = 'user_skill_info';
    CONST TN_SKILL_ALLOWED = 'level_allow_skill_num';
    CONST TN_SKILL_POINT = 'level_skill_point';

    /**
     * @desc 获取角色技能等级
     */
    public static function getSkillByUserId($user_id){
        $where      = array(
            'user_id' => $user_id,
        );
        $skill_info = DB::table(self::TN_SKILL_INFO)->select($where);
        return $skill_info;
    }

    /**
     * @desc 技能学习
     */
    public static function updateSkill($user_id, $skill_code){
        //最高技能等级限制
        //判断技能点
        //判断铜钱
    }
}
