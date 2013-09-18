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
    
    //使用技能 通过skill_type和skill_location来判断唯一性,没有的话直接添加,有的话添加的同时去掉原来的使用
    public static function useSkill($userId, $skillId, $skillType, $skillLocation){
    	//应该先判断是否可以有某个数量,暂时略过,再补
    	$old = MySql::selectOne(self::TN_SKILL_INFO, array('user_id' => $userId, 'skill_type' => $skillType, 'skill_location' => $skillLocation));
    	if(!empty($old)){//下掉原位置的技能
    		MySql::update(self::TN_SKILL_INFO, 
		    		array('skill_location' => 0, 
		    		array('user_id' => $old['user_id'], 'skill_id' => $old['skill_id'])));
    	}
    	$res = MySql::update(self::TN_SKILL_INFO, 
    				array('skill_location' => $skillLocation), 
    				array('user_id' => $userId, 'skill_id' => $skillId));
    	return $res;
    }
 
}
