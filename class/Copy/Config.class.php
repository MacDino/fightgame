<?php
class Copy_Config{

	const MONSTER_TYPE_LESS_THAN = 1;
	const MONSTER_TYPE_EQUAL = 2;
	const MONSTER_TYPE_MORE_THAN = 3;

	const MONSTER_SKILL_RAND_START = 0;
	const MONSTER_SKILL_RAND_END   = 5;

	const RESSURRECTION_MONEY = 5000; 	//复活金币数
	const RESSURRECTION_INGOT = 10;		//复活元宝数


	const MONSTER_GROUP_FIRST = 1;
	const MONSTER_GROUP_SECOND = 2; 


	const MONSTER_NUM = 100;

	const TABLE_NAME = "copies_level";
	const TABLE_NAME_CONFIG = "copies_monster_config";



	/*
	 * 获取某一层
	 */
    public static function getCopyLevelInfoByLevelId($copyLevelId) {
        if($copyLevelId > 0) {
            $where = array('level_id' => $copyLevelId);
            return MySql::selectOne('copies_level', $where);
        }
        return FALSE;
    }


	/*
	 * 根据副本层级id获取到相对应的怪物
	 */
	public static function getMonsterByLevelId($levelId,$userId){
		$levelInfo = self::getCopyLevelInfoByLevelId($levelId);	
		if ($levelInfo) {
			$monsterType = $levelInfo['monster_level_type'];
			$monsterLevelLimit = $levelInfo['monster_level'];
			$monsterSuffix = $levelInfo['monster_suffix'];
			$skills = $levelInfo['monster_skill'];

			$userInfo = User_Info::getUserInfoByUserId($userId);
			$userLevel = $userInfo['user_level'];
			if ($userLevel == 0 || $userLevel < 10) {
				throw new Exception ('user level is more than 10', 12001);	
			}
			if ($monsterType == self::MONSTER_TYPE_MORE_THAN){
				$monsterLevel = $userLevel + $monsterLevelLimit;
			} else if ($monsterType == self::MONSTER_TYPE_EQUAL){
				$monsterLevel = $userLevel;
			} else if ($monsterType == self::MONSTER_TYPE_LESS_THAN){
				$monsterLevel = $userLevel - $monsterLevelLimit;
			}
			/*
			 * 根据区间去地图中取怪物名
			 */
			$mapWhere = array(
				'end_level' => array(
					'opt' => '>',
					'val' => $monsterLevel,
				),
			);	
			$mapList = Map_Config::getMapList($mapWhere);
			$mapId = $mapList[0]['map_id'];
			$mapConfig = Map_Config::getMapConfig($mapId);	
			if (!$mapConfig) {
				throw new Exception('map not exists');
			}
			$monsterId = array_rand($mapConfig['monsters']);
			$mapMonster = MySql::selectOne('map_monster', array('monster_id' => $monsterId));
			$monsterRaceId = $mapMonster['race_id']; 

			$monster = array(
				'monster_id' 	=> $monsterId,
				'level' 		=> $monsterLevel,
				'suffix'		=> $monsterSuffix,
				'skills'		=> $skills,
				'race_id'		=> $monsterRaceId,
				'grow_per'		=> Monster::getGrowPercentage($mapId),
			);
			$monster += $monsterSkill = self::getMonsterSkill($monster, $levelInfo['skill_rate']);
			return $monster;
		}
		return false;
	}

	/*
	 * 根据技能ID获取技能分组和释放概率
	 */
	public static function getMonsterSkill($monster, $rateConfig){
		$skillIds = explode (',', $monster['skills']);
		$skillGroup = array();
		$skillLev = $monster['level'];
		$rateArray = json_decode($rateConfig, TRUE);

		$attackSkill = NewSkill::getAttackSkillList();
		$defineSkill = NewSkill::getDefineSkillList();
		$passiveSkill = NewSkill::getPassiveSkillList();

		foreach ($skillIds as $v) {
			$returnSkills[$v] = $skillLev; 
			if (in_array($v, $attackSkill)) {
				$skillGroup['attack'][] = $v;
			}
			if (in_array($v, $defineSkill)) {
				$skillGroup['define'][] = $v;
			}
			if (in_array($v, $passiveSkill)) {
				$skillGroup['passive'][] = $v;
			}
		}

		$result['have_skillids'] = $returnSkills;
		empty($skillGroup) && $skillGroup = array();
		foreach ($skillGroup as $k => $v) {
			foreach ($v as $skill) {
				if (in_array($skill, $attackSkill)) {
					$result['skill_rates'][$k][$skill] = $rateArray['attack'];
				}
				if (in_array($skill, $defineSkill)) {
					$result['skill_rates'][$k][$skill] = $rateArray['define'];
				}
				if (in_array($skill, $passiveSkill)) {
					$result['skill_rates'][$k][$skill] = $rateArray['passive'];
				}
			}
		}
		//print_r($result);
		return $result;
	}


	private static function _getSkillRate($monster) {
		if ($monster['suffix'] == Monster::MONSTER_SUFFIX_BOSS) {
			return Map_Skill::getSkillRate('boss');
		}
		return Map_Skill::getSkillRate('not_boss');
	}


	public static function getCopyLevels(){
		$res = MySql::select(self::TABLE_NAME, $where);
		return $res;
	}

	/*
	 * 获取副本二、副本三、副本四等的怪物
	 */
	public static function getGroupMonsterByCopyId($copyId, $monsterGroup, $level){
		$where = array(
			'copy_id' 		=> $copyId,
			'monster_group'	=> $monsterGroup,
		);
		$monsters = MySql::select(self::TABLE_NAME_CONFIG, $where);	
		foreach ($monsters as $k => $v) {
			$returnMonster[$k]['monster_id'] = $v['monster_id'];
			$returnMonster[$k]['level'] = $level;
			$mapMonster = MySql::selectOne('map_monster', array('monster_id' => $v['monster_id']));
			$returnMonster[$k]['race_id'] = $mapMonster['race_id'];
			//技能和释放概率
			$returnMonster[$k]['prefix']	= $v['monster_prefix'];
			$returnMonster[$k]['suffix']	= $v['monster_suffix'];

			$skills = self::getGeneralMonsterSkill($v, $level, $mapMonster['race_id']);
			$returnMonster[$k] += $skills;

		}
		//print_r($returnMonster);
		return $returnMonster;
	} 

	/*
	 * 获取副本二、三、四里技能及释放概率
	 */
	public static function getGeneralMonsterSkill($monsters, $userLevel, $monsterRaceId){
		$skills = explode(',', $monsters['monster_skill']);
		$skillLev = $userLevel + $monsters['monster_skill_lev_range'];
		$attackSkill = NewSkill::getAttackSkillList($monsterRaceId);
		$defineSkill = NewSkill::getDefineSkillList();
		$passiveSkill = NewSkill::getPassiveSkillList();

		empty($skills) && $skills = array();
		foreach ($skills as $k => $v) {
			$returnSkills[$v] = $skillLev; 
			if (in_array($v, $attackSkill)) {
				$skillGroup['attack'][] = $v;
			}
			if (in_array($v, $defineSkill)) {
				$skillGroup['define'][] = $v;
			}
		}
		//print_r($skillGroup);
		$result['have_skillids'] = $returnSkills;
		empty($skillGroup) && $skillGroup = array();
		foreach ($skillGroup as $k => $v) {
			//魔族技能
			if ($monsterRaceId == User_Race::RACE_DEMON) {
				$result['skill_rates'][$k] = self::getDemonSkillRate($v);
			//仙族技能
			} elseif ($monsterRaceId == User_Race::RACE_TSIMSHIAN) {
				$result['skill_rates'][$k] = self::getTsimshianSkillRate($v);
			//人族技能
			}elseif ($monsterRaceId == User_Race::RACE_HUMAN) {
				$result['skill_rates'][$k] = self::getHumanSkillRate($v);
			}
		}
		//print_r($result);
		return $result;
		/*
		$memberInfo11 = $memberInfo12 = $memberInfo21 =  $memberInfo22 = array(
			'attributes' => array(
				'1101' => 103.1,
				'1102' => 71.4,
				'1103' => 60.4,
				'1104' => 78.1,
				'1105' => 98.1,
				'1107' => 1681.842,
				'1110' => 1009.047,
				'1108' => 918.9,
				'1106' => 599.8,
				'1113' => 355.96,
				'1112' => 92.83,
				'1111' => 853.26,
				'1109' => 11166.5,
				'1114' => 32,
			),
			'user_level' => 12,
			'user_id' => 27,
			'have_skillids' => array(
				1201 => 4,
				1202 => 12,
				1203 => 14,
				1204 => 4,
				1205 => 5,
				1206 => 7,
				1207 => 9,
				1207 => 10,
				1208 => 12,
				1209 => 90,
				1210 => 18,
				1211 => 16,
				1212 => 20,
				1213 => 32,
				1214 => 44,
				1215 => 55,
				1216 => 66,
				1217 => 77,
				1218 => 88,
				1219 => 99,
				1220 => 12,
				1221 => 22,
				1222 => 32,
				1223 => 34,
				1224 => 35,
				1225 => 36,
				1226 => 37,
				1227 => 38,
				1228 => 39,
				1229 => 100,
			),
			'skill_rates' => array(
				'attack' => array(
					1206 => 0.5,
					1207 => 0.7,
					1208 => 0.1,
					1209 => 0.1,
					1210 => 0.5,
				),
				'define' => array(
					1211 => 0.2
				)
			),
		);
		 */
	}

	/*
	 * 获取魔族技能释放概率
	 */
	public static function getDemonSkillRate ($skill) {
		/*
		 * 技能权重
		 */
		$rank = array(
			NewSkill::SKILL_DEMON_GJ_QTGJ => 10,
			NewSkill::SKILL_DEMON_GJ_DTGJ => 10,
			NewSkill::SKILL_DEMON_GJ_JCK  => 1,
			NewSkill::SKILL_DEMON_GJ_FH	  => 1,
			NewSkill::SKILL_DEMON_GJ_QJL  => 1,
		);
		$rankSum = array_sum($rank);

		foreach ($skill as $v) {
			if($v == NewSkill::SKILL_DEMON_GJ_QTGJ) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_DEMON_GJ_QTGJ],2);
			}		
			if ($v == NewSkill::SKILL_DEMON_GJ_DTGJ) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_DEMON_GJ_DTGJ],2);
			}
			//FIXME  此处需要替换为虚弱
			if ($v == NewSkill::SKILL_DEMON_GJ_JCK) {
				$rate[$v] = round (0.45/$rankSum*$rank[NewSkill::SKILL_DEMON_GJ_JCK],2);
			}
			if ($v == NewSkill::SKILL_DEMON_GJ_FH) {
				$rate[$v] = round( 0.45/$rankSum*$rank[NewSkill::SKILL_DEMON_GJ_FH],2);
			}
			if ($v == NewSkill::SKILL_DEMON_GJ_QJL) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_DEMON_GJ_QJL],2);
			}
		}
		//print_r($rate);
		return $rate;
	}
	/*
	 * 获取仙族技能释放概率
	 */
	public static function getTsimshianSkillRate ($skill) {
		/*
		 * 技能权重
		 */
		$rank = array(
			NewSkill::SKILL_TSIMSHIAN_GJ_QTFSGJ => 10,
			NewSkill::SKILL_TSIMSHIAN_GJ_DTFSGJ => 10,
			NewSkill::SKILL_TSIMSHIAN_GJ_XR  => 1,
			NewSkill::SKILL_TSIMSHIAN_GJ_QJX => 1,
			NewSkill::SKILL_TSIMSHIAN_GJ_QJSH => 1,
		);
		$rankSum = array_sum($rank);

		foreach ($skill as $v) {
			if($v == NewSkill::SKILL_TSIMSHIAN_GJ_QTFSGJ) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_TSIMSHIAN_GJ_QTFSGJ],2);
			}		
			if ($v == NewSkill::SKILL_TSIMSHIAN_GJ_DTFSGJ) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_TSIMSHIAN_GJ_DTFSGJ],2);
			}
			//FIXME  此处需要替换为虚弱
			if ($v == NewSkill::SKILL_TSIMSHIAN_GJ_XR) {
				$rate[$v] = round (0.45/$rankSum*$rank[NewSkill::SKILL_TSIMSHIAN_GJ_XR],2);
			}
			if ($v == NewSkill::SKILL_TSIMSHIAN_GJ_QJX) {
				$rate[$v] = round( 0.45/$rankSum*$rank[NewSkill::SKILL_TSIMSHIAN_GJ_QJX],2);
			}
			if ($v == NewSkill::SKILL_TSIMSHIAN_GJ_QJSH) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_TSIMSHIAN_GJ_QJSH],2);
			}
		}
		//print_r($rate);
		return $rate;
	}

	/*
	 * 获取人族技能释放概率
	 */
	public static function getHumanSkillRate ($skill) {
		/*
		 * 技能权重
		 */
		$rank = array(
			NewSkill::SKILL_HUMAN_GJ_DTWLGJ => 10,
			NewSkill::SKILL_HUMAN_GJ_WGK => 5,
			NewSkill::SKILL_HUMAN_GJ_FGK  => 1,
			NewSkill::SKILL_HUMAN_GJ_JL => 1,
			NewSkill::SKILL_HUMAN_GJ_DJX => 1,
		);
		$rankSum = array_sum($rank);

		foreach ($skill as $v) {
			if($v == NewSkill::SKILL_HUMAN_GJ_DTWLGJ) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_HUMAN_GJ_DTWLGJ],2);
			}		
			if ($v == NewSkill::SKILL_HUMAN_GJ_WGK) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_HUMAN_GJ_WGK],2);
			}
			//FIXME  此处需要替换为虚弱
			if ($v == NewSkill::SKILL_HUMAN_GJ_FGK) {
				$rate[$v] = round (0.45/$rankSum*$rank[NewSkill::SKILL_HUMAN_GJ_FGK],2);
			}
			if ($v == NewSkill::SKILL_HUMAN_GJ_JL) {
				$rate[$v] = round( 0.45/$rankSum*$rank[NewSkill::SKILL_HUMAN_GJ_JL],2);
			}
			if ($v == NewSkill::SKILL_HUMAN_GJ_DJX) {
				$rate[$v] = round(0.45/$rankSum*$rank[NewSkill::SKILL_HUMAN_GJ_DJX],2);
			}
		}
		//print_r($rate);
		return $rate;
	}

}
