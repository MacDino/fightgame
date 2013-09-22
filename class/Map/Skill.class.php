<?php
/**
 * 地图技能相关配置
 */
class Map_Skill extends Model {

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

	// 获取该地图怪物boss的最低技能数，包括攻击，防御，被动
	public static function getBossMinCount($map_id, $skill_type = null)
	{
		return self::_getSkillCount($map_id, 'boss_min_count', $skill_type);
	}

	// 获取该地图怪物boss的必须技能，包括攻击，防御，被动
	public static function getBossMustHave($map_id, $skill_type = null)
	{
		return self::_getSkillIds($map_id, 'boss_must_have', $skill_type);
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
            $res = Mysql::selectOne(self::TABLE_NAME_CONF_NUM, $where);
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
            $res = Mysql::selectOne(self::TABLE_NAME_CONF_MUST, $where);
            $return = isset($res['skill_ids']) ? json_decode($res['skill_ids'], true) : array();
        }
        return $return;
	}

	protected static function _getSkillIds($map_id, $config_type, $skill_type = null)
	{
		$where = array(
			'map_id' => $map_id,
			'config_type' => $config_type,
		);

		$data = self::select($where);

		$ret = array();
		foreach ($data as $one)
		{
			$ret[$one['skill_type']][] = $one['skill_id'];
		}

		return isset($skill_type) ? $ret[$skill_type] : $ret;
	}

	protected static function _getSkillCount($map_id, $config_type, $skill_type = null)
	{
		$where = array(
			'map_id' => $map_id,
			'config_type' => $config_type,
		);

		$data = self::select($where);

		$ret = array();
		foreach ($data as $one)
		{
			$ret[$one['skill_type']] = $one['skill_id'];
		}

		return isset($skill_type) ? $ret[$skill_type] : $ret;
	}
}
