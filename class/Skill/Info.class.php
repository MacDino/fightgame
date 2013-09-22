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
    	$skill = array();
    	$userSkill = self::getSkillList($user_id);//用户已学习技能
    	foreach ($userSkill as $i=>$key) {
        	$res[$key['skill_id']] = array('skill_level' => $key['skill_level']);
        }
    	$skillList = ConfigDefine::skillList();//所有技能
//    	var_dump($res);
    	foreach ($skillList as $i=>$key){
    		if(array_key_exists($i, $res)){//已学习
				$skill[$i]['skill_level'] = $res[$i]['skill_level'];
    			$skill[$i]['money'] = self::getSkillMoney($res[$i]['skill_level']);
    		}else{//未学习
    			$skill[$i]['skill_level'] = 0;
    			$skill[$i]['money'] = self::getSkillMoney(0);
    		}
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
     * @desc 获取学习下一级技能所需要的铜钱
     */
    public static function getSkillMoney($level=0){
        $where  = array(
            'skill_level >' => $level+1, 
        );
        $spend      = MySql::selectOne(self::TN_SKILL_SPEND, array('skill_level' => $level+1));
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
    
    /** @desc 重击属性加成 */
	public static function zhongjiAttr($type = FALSE){
		if(!$type){
			MySql::delete('skill_attributes', array('skill_id' => ConfigDefine::SKILL_ZJ));
		}else{
			$num1 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += (1.01 + $i*0.02);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_ZJ, 'skill_level' => $i, 'race_id' => 3, 'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HIT => $num1))));
			}
			$num2 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += (1.01 + $i*0.02);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_ZJ, 'skill_level' => $i, 'race_id' => 2, 'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HIT => $num2))));
			}
			$num3 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += (2.01 + $i*0.02);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_ZJ, 'skill_level' => $i, 'race_id' => 1, 'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HIT => $num3))));
			}
		}
	}
	
	/** @desc 连击属性加成 */
	public static function lianjiAttr($type = FALSE){
		if(!$type){
			MySql::delete('skill_attributes', array('skill_id' => ConfigDefine::SKILL_LJ));
		}else{
			$num1 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += (2.02 + $i*0.01);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_LJ, 'skill_level' => $i, 'race_id' => 3, 'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HURT => $num1))));
			}
			$num2 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += (2.01 + $i*0.02);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_LJ, 'skill_level' => $i, 'race_id' => 2, 'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HURT => $num2))));
			}
			$num3 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += (2.5 + $i*0.014);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_LJ, 'skill_level' => $i, 'race_id' => 1, 'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HURT => $num3))));
			}
		}
	}
	
	/** @desc 灵犀一指属性加成 */
	public static function lingxiyizhiAttr($type = FALSE){
		if(!$type){
			MySql::delete('skill_attributes', array('skill_id' => ConfigDefine::SKILL_LXYZ));
		}else{
			$num1 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += ($i*2);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_LXYZ, 'skill_level' => $i, 'race_id' => 3, 
				'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HURT => $num1, ConfigDefine::USER_ATTRIBUTE_HIT => $num1 * 2))));
			}
			$num2 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += ($i*2);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_LXYZ, 'skill_level' => $i, 'race_id' => 2, 
				'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HURT => $num2, ConfigDefine::USER_ATTRIBUTE_HIT => $num1 * 2))));
			}
			$num3 = 0;
			for ($i=1; $i<100; $i++){
				$num1 += ($i*2);
				MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_LXYZ, 'skill_level' => $i, 'race_id' => 1, 
				'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_HURT => $num3, ConfigDefine::USER_ATTRIBUTE_HIT => $num1 * 2))));
			}
		}
	}
	
	/** @desc 三昧真火属性加成 */
	public static function weimeizhenhuoAttr($type = FALSE){
		if(!$type){
			MySql::delete('skill_attributes', array('skill_id' => ConfigDefine::SKILL_SWZH));
		}else{
			for ($o=1; $o<4; $o++){
				for ($i=1; $i<100; $i++){
					MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_SWZH, 'skill_level' => $i, 'race_id' => $o, 
					'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_PSYCHIC => $i*2))));
				}
			}
		}
	}
	
	/** @desc 呼风唤雨属性加成 */
	public static function hufenghuanyuAttr($type = FALSE){
		if(!$type){
			MySql::delete('skill_attributes', array('skill_id' => ConfigDefine::SKILL_HFHY));
		}else{
			for ($o=1; $o<4; $o++){
				for ($i=1; $i<100; $i++){
					MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_HFHY, 'skill_level' => $i, 'race_id' => $o, 
					'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_PSYCHIC => $i*1))));
				}
			}
		}
	}
	
	/** @desc 五雷决属性加成 */
	public static function wuleijueAttr($type = FALSE){
		if(!$type){
			MySql::delete('skill_attributes', array('skill_id' => ConfigDefine::SKILL_WLJ));
		}else{
			for ($o=1; $o<4; $o++){
				for ($i=1; $i<100; $i++){
					MySql::insert('skill_attributes', array('skill_id' => ConfigDefine::SKILL_WLJ, 'skill_level' => $i, 'race_id' => $o, 
					'attribute' => json_encode(array(ConfigDefine::USER_ATTRIBUTE_PSYCHIC => $i*1))));
				}
			}
		}
	}
	
	/** @desc 得到技能加成 根据技能ID 技能等级 种族ID*/
	public static function getSkillAttribute($skillId, $skillLevel, $raceId){
		$res = MySql::selectOne('skill_attributes', array('skill_id'=>$skillId, 'skill_level'=>$skillLevel, 'race_id'=>$raceId), array('attribute'));
		return json_decode($res['attribute'], TRUE);
	}
 
}
