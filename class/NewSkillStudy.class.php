<?php
class NewSkillStudy{
	
	CONST TN_SKILL_INFO = 'user_skill';
	CONST TN_SKILL_SPEND = 'level_skill_spend';
	
	/** @desc 获取角色技能等级列表 */
    public static function getSkillList($userId, $skillType){
        $where      = array(
            'user_id' 		=> $userId,
        );

        //if(!empty($skillType)){
        $where['skill_type'] = $skillType;
        //}
        $res = MySql::select(self::TN_SKILL_INFO, $where, array('skill_id', 'skill_level', 'odds_set'));
        
        return $res;
    }
    
    /** @desc 可学习技能列表,带着金钱 */
    public static function getStudySkillList($userId, $skillType){
    	
    	if($skillType == 1){//种族技能
    		$userInfo = User_Info::getUserInfoByUserId($userId);
    		$skillList = self::raceSkill($userInfo['race_id']);
    	}else{
    		$skillList = self::raceSkill();
    	}
    	
    	$userSkill = self::getReleaseProbability($userId, $skillType);//已学习
		//print_r($userSkill);
    	/*if(!empty($userSkill)){
	    	foreach ($userSkill as $i=>$key) {
	        	$skill[$key['skill_id']] = $key['skill_level'];
	        }
    	}*/


    	$o = (int)'-1';
    	foreach ($skillList as $i=>$key){
    		$o++;
    		if(array_key_exists($i, $userSkill)){
    			$res[$o]['skill_id']		= $i;
				$res[$o]['skill_level'] 	= $userSkill[$i]['skill_level'];
				$res[$o]['odds_set'] 		= $userSkill[$i]['odds_set'];
				$res[$o]['probability'] 	= $userSkill[$i]['probability'];
    			$res[$o]['money'] 			= self::getSkillMoney($userSkill[$i]['skill_level']);
    		}else{
    			$res[$o]['skill_id']		= $i;
    			$res[$o]['skill_level'] 	= 0;
    			$res[$o]['money'] 			= self::getSkillMoney(0);
    			$res[$o]['odds_set'] 		= 0;
				$res[$o]['probability'] 	= 0;
    		}
    	}
    	
    	return $res;
    }
    
    /** @desc 获取学习下一级技能所需要的铜钱 */
    public static function getSkillMoney($level=0){
        $spend      = MySql::selectOne(self::TN_SKILL_SPEND, array('skill_level' => $level+1));
        return $spend['money'];
    }
    
    
    
    /** @desc 总技能等级 用于战斗力计算*/
    public static function totalSkillLevel($userId){
    	$skillLevel = 0;
    	$skillInfo = self::getSkillList($userId, 1);
    	foreach ($skillInfo as $i){
    		$skillLevel += $i['skill_level'];
    	}
    	
    	return $skillLevel;
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
     * @desc 技能学习
     */
    public static function updateSkill($user_id, $skill_id, $skill_type){
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
			if($skill_type == 1){
				return MySql::insert(self::TN_SKILL_INFO, array('user_id' => $user_id, 'skill_id' => $skill_id, 'skill_level' => 1, 'skill_type' => $skill_type, 'odds_set' => Skill::PROPORTION_MIDDLE));
			}else{
				return MySql::insert(self::TN_SKILL_INFO, array('user_id' => $user_id, 'skill_id' => $skill_id, 'skill_level' => 1, 'skill_type' => $skill_type, 'odds_set' => Skill::PROPORTION_CLOSE));
			}
        }
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
    
    /** @desc 技能权重设置 */
	public static function setSkillOdds($userId, $skillId, $oddsSet){
		$res = MySql::update(self::TN_SKILL_INFO, array('odds_set' => $oddsSet), array('user_id' => $userId, 'skill_id' => $skillId));
		if($res){
			$result = self::getReleaseProbability($userId);
		}
		return array('status'=>$res, 'Probability'=>$result[$skillId]['probability']);
	}
	
	public static function ReleaseProbability($userId){
		$attack = array();
		$defense = array();
		$defenseSkill = array(NewSkill::SKILL_HUMAN_FY_FJ => 0, NewSkill::SKILL_TSIMSHIAN_FY_ZJ => 0, NewSkill::SKILL_DEMON_FY_FZ);
		$skillInfo = self::getReleaseProbability($userId, 1);
		
		foreach ($skillInfo as $k => $v){
			if(array_key_exists($k, $defenseSkill)){
				$defense[$k]['skill_id'] =  $k;
				$defense[$k]['skill_level'] =  $v['skill_level'];
				$defense[$k]['probability'] =  $v['probability'];
			}else{
				$attack[$k]['skill_id'] =  $k;
				$attack[$k]['skill_level'] =  $v['skill_level'];
				$attack[$k]['probability'] =  $v['probability'];
			}
		}
		return array('defense' => $defense, 'attack' => $attack);
	}
	
	/** @desc 技能权重换算成比例 */
	public static function getReleaseProbability($userId, $skillType){
		$skillInfo = self::getSkillList($userId, $skillType);
        //print_r($skillInfo);exit;
		
		//最高释放概率
		$high = 0.45;//基础释放概率
		$userInfo = User_Info::getUserInfoFightAttribute($userId, true);//用户属性
		$equipProbability = $userInfo[ConfigDefine::RELEASE_PROBABILITY];//装备释放总概率
		if($equipProbability > 0.45){$equipProbability = 0.45;}
		if($skillType == 0){
			$high = 0;
		}else{
			$high += $equipProbability;
		}
		
		$total = 0;
		foreach ($skillInfo as $k=>$v){
			$total += $v['odds_set'];
		}
		
		foreach ($skillInfo as $i=>$o){
			$skillInfo[$i]['probability'] = sprintf("%01.2f", $high/$total*$o['odds_set']*100);
		}
		foreach ($skillInfo as $key=>$value){
			$res[$value['skill_id']] = array(
				'skill_level' => $value['skill_level'],
				'odds_set' 	  => $value['odds_set'],
				'probability' => $value['probability'],
			);
		}
		return $res;
	}
	
	/** @desc 种族技能 */
	public static function raceSkill($raceId=false){
		if($raceId == 1){
			$res = array(
				NewSkill::SKILL_HUMAN_GJ_DTWLGJ 	=> 0,
				NewSkill::SKILL_HUMAN_GJ_WGK 		=> 0,
				NewSkill::SKILL_HUMAN_GJ_FGK 		=> 0,
				NewSkill::SKILL_HUMAN_GJ_JL 		=> 0,
				NewSkill::SKILL_HUMAN_GJ_DJX 		=> 0,
				NewSkill::SKILL_HUMAN_FY_FJ 		=> 0,
			);
		}elseif($raceId == 2){
			$res = array(
				NewSkill::SKILL_TSIMSHIAN_GJ_DTFSGJ => 0,
				NewSkill::SKILL_TSIMSHIAN_GJ_QTFSGJ => 0,
				NewSkill::SKILL_TSIMSHIAN_GJ_XR 	=> 0,
				NewSkill::SKILL_TSIMSHIAN_GJ_QJX 	=> 0,
				NewSkill::SKILL_TSIMSHIAN_GJ_QJSH 	=> 0,
				NewSkill::SKILL_TSIMSHIAN_FY_ZJ 	=> 0,
			);
		}elseif($raceId == 3){
			$res = array(
				NewSkill::SKILL_DEMON_GJ_DTGJ 		=> 0,
				NewSkill::SKILL_DEMON_GJ_QTGJ 		=> 0,
				NewSkill::SKILL_DEMON_GJ_JCK 		=> 0,
				NewSkill::SKILL_DEMON_GJ_FH 		=> 0,
				NewSkill::SKILL_DEMON_GJ_QJL 		=> 0,
				NewSkill::SKILL_DEMON_FY_FZ 		=> 0,
			);
		}else{
			$res = array(
				NewSkill::SKILL_COMMON_BD_WFX 		=> 0,
				NewSkill::SKILL_COMMON_BD_FFX 		=> 0,
				NewSkill::SKILL_COMMON_BD_WGX 		=> 0,
				NewSkill::SKILL_COMMON_BD_FGX 		=> 0,
				NewSkill::SKILL_COMMON_BD_TX		=> 0,
				NewSkill::SKILL_COMMON_BD_DZ		=> 0,
			);
		}
		return $res;
	}
	
	public static function getSkillAttr($userId){
		$attrArray = array(
			ConfigDefine::USER_ATTRIBUTE_POWER			=> 0,//力量
			ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER	=> 0,//魔力
			ConfigDefine::USER_ATTRIBUTE_PHYSIQUE		=> 0,//体质
			ConfigDefine::USER_ATTRIBUTE_ENDURANCE		=> 0,//耐力
			ConfigDefine::USER_ATTRIBUTE_QUICK			=> 0,//敏捷
			ConfigDefine::USER_ATTRIBUTE_HIT          	=> 0,//命中 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_HURT         	=> 0,//伤害 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_MAGIC        	=> 0,//魔法 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_BLOOD        	=> 0,//气血 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_PSYCHIC      	=> 0,//灵力 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_SPEED        	=> 0,//速度 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_DEFENSE      	=> 0,//防御 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_DODGE        	=> 0,//躲闪 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_LUCKY        	=> 0,//幸运 - 成长属性
		    ConfigDefine::RELEASE_PROBABILITY 		  	=> 0,//释放概率
		);
		$skillInfo = self::getSkillList($userId, 1);
        //print_r($skillInfo);
		foreach ($skillInfo as $k=>$v){
			$skillfunction = "skill".$v['skill_id'];
            //echo $skillfunction;
			$res = call_user_func(array('NewSkillAttr', $skillfunction), $v['skill_level']);
			foreach ($res as $i => $o){
				if(array_key_exists($i, $attrArray)){
					$attrArray[$i] += $o;
				}
			}
		}
        //echo 11111;
        //print_r($attrArray);exit;
		return $attrArray;
	}
	
	/**
	 * 体修公式
	 *
	 * @param unknown_type $raceId
	 * @param unknown_type $level
	 * @param unknown_type $physique
	 * @return unknown
	 */
	public static function getTixiuAttr($raceId, $level, $physique){
		
		if($raceId == 1){
			$blood = (($physique - 10)*5 +150)*(1+$level/100);
		}elseif ($raceId == 2){
			$blood = (($physique - 12)*6 +172)*(1+$level/100);
		}elseif ($raceId == 3){
			$blood = (($physique - 12)*4.5 +154)*(1+$level/100);
		}
		return $blood;
	}
	
	/**
	 * 是否有技能点未使用
	 *
	 * @param int $user_id
	 */
	public static function isSkill($user_id){
		$userInfo = User_Info::getUserInfoByUserId($user_id);
		if($userInfo['skil_point'] > 0){
			return true;
		}else{
			return false;
		}
	}
    
}