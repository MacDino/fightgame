<?php
class Skill_Info {
    CONST TN_SKILL_INFO = 'user_skill';
    CONST TN_SKILL_ALLOWED = 'level_allow_skill_num';
    CONST TN_SKILL_SPEND = 'level_skill_spend';
    
    CONST DENGJIDUAN = 10;//每隔多少级技能点数增加
    CONST ZENGZHANGLV= 1;//每次增加多少

    
    /** @desc 技能点增加规律 */
    public static function addSkillNum($level){
    	$num = ceil($level/self::DENGJIDUAN);
    	$res = $num + self::ZENGZHANGLV;
    	return $res;
    }
    
    /**
     * @desc 获取角色技能等级列表
     */
    public static function getSkillList($user_id){
        $where      = array(
            'user_id' => $user_id,
            'is_use'  => 1,
        );
        $res = MySql::select(self::TN_SKILL_INFO, $where);
        return $res;
    }
    
    /** @desc 获取用户正在使用技能 1为攻击2为防御*/
    public static function getUserUsedSkill($userId, $type){
    	if($type == 1){
    		$sql = "SELECT skill_id, skill_level, skill_location, odds_set FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND is_use = 1 AND skill_type IN (" . Skill::SKILL_GROUP_WLGJ . "," .Skill::SKILL_GROUP_FSGJ .")";
    	}else{
    		$sql = "SELECT skill_id, skill_level, skill_location, odds_set FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND is_use = 1 AND skill_type = " . Skill::SKILL_GROUP_FYJN;
    	}
    	
//    	echo $sql;
    	$res = MySql::query($sql);
    	return $res;
    }
    
    /** @desc 可使用技能列表 */
    public static function getCanDoSkillList($userId, $type){
    	if($type == 1){
    		$sql = "SELECT skill_id, skill_level, is_use FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND skill_type IN (" . Skill::SKILL_GROUP_WLGJ . "," .Skill::SKILL_GROUP_FSGJ .")";
    	}else{
    		$sql = "SELECT skill_id, skill_level, is_use FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND skill_type = " . Skill::SKILL_GROUP_FYJN;
    	}
    	
    	$res = MySql::query($sql);
    	return $res;
    }
    
    /** @desc 可学习技能列表,带着金钱 */
    public static function getStudySkillList($userId, $type){
    	$skill = array();
    	$res = array();
    	$userSkill = self::getSkillList($userId);//用户已学习技能
    	if(!empty($userSkill)){
	    	foreach ($userSkill as $i=>$key) {
	        	$res[$key['skill_id']] = array('skill_level' => $key['skill_level']);
	        }
    	}
        
        if($type == 1){
        	$skillList = Skill::skillListWLGJ();
        }elseif ($type == 2){
        	$skillList = Skill::skillListFSGJ();
        }elseif ($type == 3){
        	$skillList = Skill::skillListBDJN();
        }elseif ($type == 4){
        	$skillList = Skill::skillListFYJN();
        }
    	$o = (int)'-1';
    	foreach ($skillList as $i=>$key){
    		$o++;
    		if(array_key_exists($i, $res)){//已学习
    			$skill[$o]['skill_id']		= $i;
				$skill[$o]['skill_level'] = $res[$i]['skill_level'];
    			$skill[$o]['money'] = self::getSkillMoney($res[$i]['skill_level']);
    		}else{//未学习
    			$skill[$o]['skill_id']		= $i;
    			$skill[$o]['skill_level'] = 0;
    			$skill[$o]['money'] = self::getSkillMoney(0);
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
        $skill_info = MySql::selectOne(self::TN_SKILL_INFO, $where, array('skill_level'));
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
        return MySql::selectCount(self::TN_SKILL_INFO, $where);
    }


    /**
     * @desc 技能学习
     */
    public static function updateSkill($user_id, $skill_id){
        $level = self::getSkillInfo($user_id, $skill_id);
        $where  = array(
            'user_id'   => $user_id,
            'skill_id'  => $skill_id
        );

        //增加技能等级
        return MySql::update(self::TN_SKILL_INFO, array('skill_level' => ($level+1)), $where);
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
        return MySql::selectOne(self::TN_SKILL_ALLOWED, $where);
    }
    /**
     * @desc 获取当前等级技能点数
     * return int
     */
    public static function getSkillPoint($user_level){
        $where  = array(
            'level' => $user_level
        );
        $point = MySql::selectOne(self::TN_SKILL_ALLOWED, $where);
        return $point['point_num'] ? $point['point_num'] : 0;
    }
    /**
     * @desc 获取学习下一级技能所需要的铜钱
     */
    public static function getSkillMoney($level=0){
        $spend      = MySql::selectOne(self::TN_SKILL_SPEND, array('skill_level' => $level+1));
        return $spend['money'];
    }
    
    /**
     * @desc 使用技能
     * 通过type和skill_location来判断唯一性,没有的话直接添加,有的话添加的同时去掉原来的使用状态和位置
     */ 
    public static function useSkill($userId, $skillId, $type, $skillLocation){
    	//应该先判断是否可以有某个数量,暂时略过,再补
    	if($type == 1)
    		$sql = "SELECT user_id, skill_id FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND 'skill_location' = $skillLocation
    				AND skill_type IN (" . Skill::SKILL_GROUP_WLGJ . "," .Skill::SKILL_GROUP_FSGJ .")";
    	elseif($type == 2){
    		$sql = "SELECT user_id, skill_id FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND 'skill_location' = $skillLocation
    				AND skill_type = " . Skill::SKILL_GROUP_FYJN;
    	}
    	$old = MySql::query($sql);
    	if(!empty($old)){//下掉原位置的技能
    		MySql::update(self::TN_SKILL_INFO, 
		    		array('skill_location' => 0, 'is_use' => 0),
		    		array('user_id' => $old['user_id'], 'skill_id' => $old['skill_id']));
    	}
    	$res = MySql::update(self::TN_SKILL_INFO, 
    				array('skill_location' => $skillLocation, 'is_use' => 1), 
    				array('user_id' => $userId, 'skill_id' => $skillId));
    	return $res;
    }
    
    /** @desc 技能权重设置 */
	public static function setSkillOdds($userId, $skillId, $oddsSet){
		$res = MySql::update(self::TN_SKILL_INFO, array('odds_set' => $oddsSet), array('user_id' => $userId, 'skill_id' => $skillId));
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
