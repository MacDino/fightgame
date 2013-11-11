<?php
class NewSkillStudy{
	
	
	/** @desc 获取角色技能等级列表 加入了装备附加技能 */
    public static function getSkillList($userId, $is_use=false){
        $where      = array(
            'user_id' => $userId,
        );
        if($is_use){
        	$where['is_use']  = 1;
        }
        $res = MySql::select(self::TN_SKILL_INFO, $where, array('skill_id', 'skill_level'));
        
        return $res;
    }
    
    /** @desc 总技能等级 用于战斗力计算*/
    public static function totalSkillLevel($userId){
    	$skillLevel = 0;
    	$skillInfo = self::getSkillList($userId);
    	foreach ($skillInfo as $i){
    		$skillLevel += $i['skill_level'];
    	}
    	
    	return $skillLevel;
    }
    
     /** @desc 获取用户正在使用技能 1为攻击2为防御*/
    public static function getUserUsedSkill($userId, $type){
    	if($type == 1){
    		$sql = "SELECT skill_id, skill_level, skill_location, odds_set FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND is_use = 1 AND skill_type IN (" . Skill::SKILL_GROUP_WLGJ . "," .Skill::SKILL_GROUP_FSGJ .")";
    	}else{
    		$sql = "SELECT skill_id, skill_level, skill_location, odds_set FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND is_use = 1 AND skill_type = " . Skill::SKILL_GROUP_FYJN;
    	}
    	
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
    	$type += 1290;//短期行为,有问题
    	$skill = array();
    	$res = array();
    	$userSkill = MySql::select(self::TN_SKILL_INFO, array('user_id'=>$userId, 'skill_type'=>$type), array('skill_id', 'skill_level'));//用户已学习技能
    	if(!empty($userSkill)){
	    	foreach ($userSkill as $i=>$key) {
	        	$res[$key['skill_id']] = array('skill_level' => $key['skill_level']);
	        }
    	}
        if($type == 1291){
        	$skillList = Skill::skillListWLGJ();
        }elseif ($type == 1292){
        	$skillList = Skill::skillListFSGJ();
        }elseif ($type == 1293){
        	$skillList = Skill::skillListBDJN();
        }elseif ($type == 1294){
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
    public static function updateSkill($user_id, $skill_id, $type){
        $level = self::getSkillInfo($user_id, $skill_id);
        $where  = array(
            'user_id'   => $user_id,
            'skill_id'  => $skill_id
        );

        if(!empty($level)){
       		//增加技能等级
        	return MySql::update(self::TN_SKILL_INFO, array('skill_level' => ($level+1)), $where);
        }else{
        	//学习新技能
        	return MySql::insert(self::TN_SKILL_INFO, array('user_id' => $user_id, 'skill_id' => $skill_id, 'skill_level' => 1, 'skill_type' => 1290+$type, 'odds_set' => Skill::PROPORTION_MIDDLE));
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
    
    /** @desc 获取学习下一级技能所需要的铜钱 */
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
    		$sql = "SELECT user_id, skill_id FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND skill_location = '$skillLocation'
    				AND skill_type IN (" . Skill::SKILL_GROUP_WLGJ . "," .Skill::SKILL_GROUP_FSGJ .")";
    	elseif($type == 2){
    		$sql = "SELECT user_id, skill_id FROM " . self::TN_SKILL_INFO . " WHERE user_id = $userId AND skill_location = '$skillLocation'
    				AND skill_type = " . Skill::SKILL_GROUP_FYJN;
    	}
    	$old = MySql::query($sql);
    	if(!empty($old)){//下掉原位置的技能
    		foreach ($old as $i){
	    		MySql::update(self::TN_SKILL_INFO, 
			    		array('skill_location' => 0, 'is_use' => 0),
			    		array('user_id' => $i['user_id'], 'skill_id' => $i['skill_id']));
    		}
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
	
	/**
	 * @desc 释放概率百分比
	 * @param string $totalProbability	总释放概率
	 * @param array $skill_info			技能信息(正在使用的技能ID,技能权重)
	 */
	public static function releaseProbability($totalProbability, $skill_info){
		$skill = array();
		$num = 0;//总点数
		foreach ($skill_info as $i=>$key){
			if($key['odds_set'] == Skill::PROPORTION_HIGH){
				$skill[$key['skill_id']] = Skill::PROPORTION_HIGH_RELEASE;
				$num += Skill::PROPORTION_HIGH_RELEASE;
			}elseif ($key['odds_set'] == Skill::PROPORTION_MIDDLE){
				$skill[$key['skill_id']] = Skill::PROPORTION_MIDDLE_RELEASE;
				$num += Skill::PROPORTION_MIDDLE_RELEASE;
			}elseif ($key['odds_set'] == Skill::PROPORTION_LOW){
				$skill[$key['skill_id']] = Skill::PROPORTION_LOW_RELEASE;
				$num += Skill::PROPORTION_LOW_RELEASE;
			}
		}
		
		foreach ($skill as $o=>$key){
			$skill[$o] = $key/$num * $totalProbability * 100;
		}
		
		return $skill;
	}
	
	/** @desc 技能权重换算成比例 */
	public static function getReleaseProbability($userId, $type){
		$skillInfo   = self::getUserUsedSkill($userId, $type);//已使用技能信息
		$count = count($skillInfo);//技能总数
		
		if($type == 1){
			switch ($count){
				case 1:
					$skillProbability = 0.25;
					break;
				case 2:
					$skillProbability = 0.3;
					break;
				case 3:
					$skillProbability = 0.35;
					break;
				case 4:
					$skillProbability = 0.4;
					break;
				case 5:
					$skillProbability = 0.45;
					break;
			}
		}
	
		if($type == 2){
			switch ($count){
				case 1:
					$skillProbability = 0.2;
					break;
				case 2:
					$skillProbability = 0.25;
					break;
				case 3:
					$skillProbability = 0.3;
					break;
				case 4:
					$skillProbability = 0.35;
					break;
				case 5:
					$skillProbability = 0.4;
					break;
			}
		}
		
	//	print_r($skillInfo);
		$userInfo = User_Info::getUserInfoFightAttribute($userId, true);//用户属性
	//	print_r($userInfo);
		$equipProbability = $userInfo[ConfigDefine::RELEASE_PROBABILITY];//装备释放总概率
	//	echo $equipProbability;
		//装备带来的最高释放概率
		if($equipProbability >= 0.45 && $type == 1){
			$equipProbability = 0.45;
		}
		if($equipProbability >= 0.4 && $type == 2){
			$equipProbability = 0.4;
		}
		
		$totalProbability  = $equipProbability + $skillProbability;//最高技能释放概率=装备+技能数
	//	echo $totalProbability;
		$skillProbability = self::releaseProbability($totalProbability, $skillInfo);//技能释放概率分解
	//	print_r($skill);
		foreach ($skillInfo as $i=>$key){
			$skillInfo[$i]['probability'] = intval($skillProbability[$key['skill_id']]);//根据skill_id合成
		}
		
		return $skillInfo;
	}
    
}