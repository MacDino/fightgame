<?php
/**
 * 地图技能相关配置
 */
class Map_Skill {

	protected static $table_name = 'map_skill';

	protected static $validates = array(
		'map_id' => 'required, integer',
		'skill_id' => 'required, integer',
		'config_type' => 'required, length:1',
		'skill_type' => 'required, in:defense|attack|passive',
	);

	protected static $skill_rates = array(
		'not_boss' => array(
			'attack' => array(1 => 0.25, 0.3, 0.35, 0.4, 0.45),
			'defense' => array(1 => 0.2, 0.25, 0.3, 0.35, 0.4),
		),

		'boss' => array(
			'attack' => array(1 => 0.7, 0.75, 0.8, 0.85, 0.9),
			'defense' => array(1 => 0.6, 0.65, 0.7, 0.75, 0.8),
		),
	);


    const TABLE_NAME_CONF_MUST = 'map_skill_conf_must';
    const TABLE_NAME_CONF_NUM  = 'map_skill_conf_num';

	public static function getSkillRate($boss_type)
	{
		return isset(self::$skill_rates[$boss_type]) ? self::$skill_rates[$boss_type] : false;
	}

	// 获取该地图允行怪物使用的所有技能，包括攻击，防御，被动
	public static function getAllSkills($map_id, $skill_type = null)
	{
		return self::_getSkillIds($map_id, 'all', $skill_type);
	}

	/**
     * 根据后缀获取最少拥有技能的数量
     * 所有后缀的值
     * **/
	public static function getSuffixMinCount($mapId, $suffix = 0) {
        $return = array();
        if($mapId > 0) {
            $where = array(
                'map_id' => intval($mapId),
            );
            $res = MySql::selectOne(self::TABLE_NAME_CONF_NUM, $where);
            $return = isset($res['can_have_num']) ? json_decode($res['can_have_num'], true) : array();
        }
        foreach ($return as $key => $val) {
            if($suffix > 0) {
                $ret[$key] = $val['suffix'][$suffix];
            }  else {
                $ret[$key] = $val['suffix'];
            }
        }
        return $ret;
	}

    /**
     * 根据后缀
     * 获取配置的后缀必须拥有的技能ids
     * **/
	public static function getSuffixMustHave($mapId, $suffixId) {
        $return = array();
        if($mapId > 0 && $suffixId > 0) {
            $where = array(
                'map_id' => $mapId,
                'type'   => 'suffix',
                'type_id' => $suffixId,
            );
            $res = MySql::selectOne(self::TABLE_NAME_CONF_MUST, $where);
            $return = isset($res['skill_ids']) ? json_decode($res['skill_ids'], true) : array();
        }
        return $return;
	}
    
    public static function getAllSuffixMustHave($mapId) {
        $return = array();
        if($mapId > 0) {
            $where = array(
                'map_id' => $mapId,
                'type'   => 'suffix',
            );
            $res = MySql::select(self::TABLE_NAME_CONF_MUST, $where);
            foreach ((array)$res as $v) {
                $vSkillIds = isset($v['skill_ids']) ? json_decode($v['skill_ids'], true) : array();
                $return[$v['type_id']] = $vSkillIds;
            }
        }
        return $return;
    }

    protected static function _getSkillIds($map_id, $config_type, $skill_type = null)
	{
		$where = array(
			'map_id' => $map_id,
			'config_type' => $config_type,
		);

		$data = MySql::select(self::$table_name, $where);

		$ret = array();
		foreach ($data as $one)
		{
			$ret[$one['skill_type']][] = $one['skill_id'];
		}

		return isset($skill_type) ? $ret[$skill_type] : $ret;
	}
    
    //不能设置为空的
    public static function saveMapSkill($mapId, $skillIds, $skillType = 'attack') {
        if($mapId < 0) {
            throw new Exception('未知地图', 1);
        }
        $skillIds = array_filter(array_unique(array_map('intval', (array)$skillIds)));
        if(!(is_array($skillIds) && count($skillIds))) {
            throw new Exception('地图的怪物使用技能必须设置', 1);
        }
        $haveSkillIds = self::getAllSkills($mapId, $skillType);
        if(is_array($haveSkillIds) && count($haveSkillIds)) {
            $commonSkill    = array_intersect($skillIds, $haveSkillIds);
            $readyDel       = array_diff($haveSkillIds,$skillIds);
            $readyAdd       = array_diff($skillIds, $haveSkillIds);
            if(is_array($readyAdd) && count($readyAdd)) {
                foreach ($readyAdd as $skillId) {
                    $data = array(
                        'map_id'        => $mapId,
                        'skill_id'      => $skillId,
                        'skill_type'    => $skillType,
                        'config_type'   => 'all',
                    );
                    MySql::insert(self::$table_name, $data);
                }
            }
            if(is_array($readyDel) && count($readyDel)) {
                $whereDel = array(
                    'map_id'        => $mapId,
                    'skill_id'      => array(
                        'opt' => 'in',
                        'val' => implode(',', $readyDel),
                    ),
                    'skill_type'    => $skillType,
                    'config_type'   => 'all',
                );
                MySql::delete(self::$table_name, $whereDel);
            }
        } else {
            foreach ($skillIds as $skillId) {
                $data = array(
                    'map_id'        => $mapId,
                    'skill_id'      => $skillId,
                    'skill_type'    => $skillType,
                    'config_type'   => 'all',
                );
                MySql::insert(self::$table_name, $data);
            }
        }
        return true;
    }
    
    public static function saveSuffixMustHave($mapId, $suffixId, $skillIds) {
        if($mapId < 0) {
            throw new Exception('未知地图', 1);
        }
        if($suffixId < 0) {
            throw new Exception('未知的后缀', 1);
        }
        $isExistInfo = self::getSuffixMustHave($mapId, $suffixId);
        $data = array(
            'map_id' => $mapId,
            'type'  => 'suffix',
            'type_id' => $suffixId,
            'skill_ids' => json_encode($skillIds),
        );
        if(is_array($isExistInfo) && count($isExistInfo)) {
            return MySql::update(self::TABLE_NAME_CONF_MUST, $data, array('map_id' => $mapId,'type' => 'suffix','type_id' => $suffixId));
        }  else {
            return MySql::insert(self::TABLE_NAME_CONF_MUST, $data);
        }
    }
    
    public static function saveSuffixMinNum($mapId, $nums) {
        if($mapId < 0) {
            throw new Exception('未知地图', 1);
        }
        $data = array(
            'map_id' => $mapId,
            'can_have_num' => json_encode($nums),
        );
        $isExistInfo = self::getSuffixMinCount($mapId);
        if(is_array($isExistInfo) && count($isExistInfo)) {
            $whereArray = array(
                'map_id' => $mapId,
            );
            return MySql::update(self::TABLE_NAME_CONF_NUM, $data, $whereArray);
        }  else {
            return MySql::insert(self::TABLE_NAME_CONF_NUM, $data);
        }
    }
}
