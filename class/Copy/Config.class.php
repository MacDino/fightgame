<?php
class Copy_Config{

	const MONSTER_TYPE_LESS_THAN = 1;
	const MONSTER_TYPE_EQUAL = 2;
	const MONSTER_TYPE_MORE_THAN = 3;

	const MONSTER_SKILL_RAND_START = 0;
	const MONSTER_SKILL_RAND_END   = 5;


	const MONSTER_NUM = 100;

	const TABLE_NAME = "copies_level";

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
			return $monster;
		}
		return false;
	}

	/*
	 * 根据技能ID获取技能分组和释放概率
	 */
	public static function getMonsterSkill($monster){
		$skillIds = explode (',', $monster['skills']);
		$skillGroup = array();
		foreach ($skillIds as $v) {
			$group = Skill::getSkillGroupBySkillCode($v);	
			if($group == Skill::SKILL_GROUP_WLGJ || $group == Skill::SKILL_GROUP_FSGJ){
				$skillGroup['attack'][] = $v;
			}
			if($group == Skill::SKILL_GROUP_FYJN){
				$skillGroup['defense'][] = $v;
			}
			if($group == Skill::SKILL_GROUP_BDJN){
				$skillGroup['passive'][] = $v;
			}
		}

		$ret = array('attack' => array(), 'defense' => array(), 'passive' => array());  				
		$skill_rate_list    = self::_getSkillRate($monster);

		foreach ($ret as $skill_type => &$skills) {

			$min_count = self::MONSTER_SKILL_RAND_START;
			$max_count = ($skill_type == 'passive') ? count($skillGroup[$skill_type]) : 5;

			$skill_count = mt_rand($min_count, $max_count);  
			$copy_skills = $skillGroup[$skill_type];
			if (!$copy_skills) {
				continue;	
			}
			shuffle($copy_skills);		
			$rand_skills = array_slice($copy_skills, 0, $skill_count);
			$rand_skills = array_flip($rand_skills);
			$min_skill_level = max(1, $monster['level'] - 10);
			$max_skill_level = $monster['level'] + 10;
			foreach ($rand_skills as $k => $v){
				$rand_skills[$k] = mt_rand($min_skill_level, $max_skill_level);
			}
			$skills = array(
				'list' => $rand_skills,
			);	
			//获取技能概率
			$rand_skill_count = count($rand_skills);
			foreach ($rand_skills as $skill => $skillV) {
				$skills['rate'][$skill] = $skill_rate_list[$skill_type][$rand_skill_count];
			}
		}
		return $ret;
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
}
