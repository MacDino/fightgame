<?php
class Skill_Info {
    CONST TN_SKILL_INFO = 'user_skill';
    CONST TN_SKILL_ALLOWED = 'level_allow_skill_num';
    CONST TN_SKILL_POINT = 'level_skill_point';
    CONST TN_SKILL_MONEY = 'level_skill_money';

    /**
     * @desc 获取角色技能等级列表
     */
    public static function getSkillList($user_id){
        $where      = array(
            'user_id' => $user_id,
        );
        $skill_list = DB::table(self::TN_SKILL_INFO)->select($where);
        if(!empty($skill_list)){
            foreach($skill_list as $k => $v){
                $skill_list[$v['skill_id']] = $v;
                unset($skill_list[$k]);
            }
        }
        return $skill_list;
    }

    /**
     * @desc 获取用户某一技能等级
     */
    public static function getSkillInfo($user_id, $skill_id){
        $where      = array(
            'user_id'   => $user_id,
            'skill_id'  => $skill_id
        );
        $skill_info = DB::table(self::TN_SKILL_INFO)->field('skill_level')->selectOne($where);
        if(!empty($skill_info) && $skill_info['skill_level']){
            return $skill_info['skill_level'];
        }
        return FALSE;
    }

    /**
     * @desc 当前已学习技能数量
     */
    public static function getLearnedSkillNum($user_id, $skill_id){
        $where      = array(
            'user_id'   => $user_id,
            'skill_id'  => $skill_id
        );
        return DB::table(self::TN_SKILL_INFO)->total($where);
    }


    /**
     * @desc 技能学习
     */
    public static function updateSkill($user_id, $skill_id, $add_level = 1){
        $level = self::getSkillInfo($user_id, $skill_id);
        $where  = array(
            'user_id'   => $user_id,
            'skill_id'  => $skill_id
        );
        if($level){
            //update
            return DB::table(self::TN_SKILL_INFO)->update(array('skill_level' => ($level+$add_level)),$where);
        } else {
            $level  = $add_level;
            $data   = array_merge($where, array('skill_level' => $level));
            return DB::table(self::TN_SKILL_INFO)->insert($data);
        }
    }
    /**
     * @desc 获取当前等级可使用技能数
     *
     * return array
     */
    public static function getAllowedSkillNum($user_level){
        $where  = array(
            'level' => $user_level
        );
        return DB::table(self::TN_SKILL_ALLOWED)->selectOne($where);
    }
    /**
     * @desc 获取当前等级技能点数
     * return int
     */
    public static function getSkillPoint($user_level){
        $where  = array(
            'level' => $user_level
        );
        $point = DB::table(self::TN_SKILL_ALLOWED)->selectOne($where);
        return $point['point_num'] ? $point['point_num'] : 0;
    }
    /**
     * @desc 获取学习技能所需要的铜钱
     * 支持一次性多级技能提高
     */
    public static function getSkillMoney($level_to, $level_from = NULL){
        $all_money  = 0;
        if($level_from && is_numeric($level_from)){
            $where  = array(
                'skill_level >' => $skill_from, 
                'skill_level <' => $skill_to
            );
            $money      = DB::table(self::TN_SKILL_MONEY)->select($where);
            foreach($money as $v){
                $all_money  += $v['money'];
            }
        } else {
            $where  = array(
                'skill_level'   => $level_to
            );
            $money      = DB::table(self::TN_SKILL_MONEY)->selectOne($where);
            $all_money  = $money['money'];
        }
        return $all_money;
    }
}
