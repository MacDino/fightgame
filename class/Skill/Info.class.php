<?php
class Skill_Info {
    CONST TN_SKILL_INFO = 'user_skill';
    CONST TN_SKILL_ALLOWED = 'level_allow_skill_num';
    CONST TN_SKILL_SPEND = 'level_skill_spend';

    /**
     * @desc 获取角色技能等级列表
     */
    public static function getSkillList($user_id, $is_use=FALSE){
        $where      = array(
            'user_id' => $user_id,
        );
        if(!empty($is_use)){//add by zhengyifeng 76387051@qq.com 2013.9.16 已装备技能
        	$where['is_use'] = $is_use;
        }
        $skill_list = DB::table(self::TN_SKILL_INFO)->select($where);
        /*if(!empty($skill_list)){
            foreach($skill_list as $k => $v){
                $skill_list[$v['skill_id']] = $v;
                unset($skill_list[$k]);
            }
        }*/
        return $skill_list;
    }
    
    //可学习技能列表,实际就是所有技能,带着消费点数和金钱,此方法有问题,需修改
    public static function getAllSkillList($user_id){
    	$skill = self::getSkillList($user_id);
    	foreach ($skill as $i){
    		$skill['money'] = self::getSkillMoney($i['skill_level']);
    	}
    	return $skill;
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
    public static function getSkillMoney($level){

        if($level && is_numeric($level_from)){
            $where  = array(
                'skill_level >' => $level+1, 
            );
            $spend      = DB::table(self::TN_SKILL_SPEND)->selectOne($where);
        }
        return $spend['money'];
    }
}
