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

	// 获取该地图普通后缀怪物的最低技能数, 包括攻击，防御，被动
	public static function getSuffixMinCount($map_id, $skill_type = null)
	{
		return self::_getSkillCount($map_id, 'suffix_min_count', $skill_type);
	}

	// 获取该地图怪物boss的必须技能，包括攻击，防御，被动
	public static function getBossMustHave($map_id, $skill_type = null)
	{
		return self::_getSkillIds($map_id, 'boss_must_have', $skill_type);
	}

	// 获取该地图怪物普通后缀的必须技能，包括攻击，防御，被动
	public static function getSuffixMustHave($map_id, $skill_type = null)
	{
		return self::_getSkillIds($map_id, 'suffix_must_have', $skill_type);
	}

	public static function setBossMinCount($map_id, $count, $skill_type)
	{
		$params = array(
			'map_id' => $map_id,
			'skill_type' => $skill_type,
			'config_type' => 'boss_min_count',
		);

		//首先检查是否已存在旧的最小值
		if (self::select($params))
		{
			return self::update(array('skill_id' => $count), $params);
		}

		$params['skill_id'] = $count;
		return self::insert($params);
	}

	public static function setSuffixMinCount($map_id, $count, $skill_type)
	{
		$params = array(
			'map_id' => $map_id,
			'skill_type' => $skill_type,
			'config_type' => 'suffix_min_count',
		);

		//首先检查是否已存在旧的最小值
		if (self::select($params))
		{
			return self::update(array('skill_id' => $count), $params);
		}

		$params['skill_id'] = $count;
		return self::insert($params);
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
