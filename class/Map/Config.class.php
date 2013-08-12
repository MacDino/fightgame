<?php
/**
 * 地图配置类
 */
class Map_Config {

	//地图配置列表
	protected static $map_config_list = array(
		Map::MAP_HUA_GS => array(
			'name' => '花果山',
			'level' => array(1, 5),
			'race' => Race::RACE_HUMAN,
			'monsters' => array('狼', '猴', '虎', '豹', '鹿'),
			'skills' => array()
		),
		Map::MAP_CHANG_SJW => array(
			'name' => '长寿效外',
			'level' => array(6, 10),
			'race' => Race::RACE_DEMON,
			'monsters' => array('小妖', '狼精', '妖道', '恶兄长', '懒师弟'),
			'skills' => array()
		),
	);

	// 获取地图列表
	public static function getMapList()
	{
		$map_list = array();
		foreach(self::$map_config_list as $map_id => $map_config)
		{
			$map_list[$map_id] = $map_config['name'];
		}

		return $map_list;
	}

	//获取地图配置
	public static function getMapConfig($map_id, $item = null)
	{
		if ( ! isset(self::$map_config_list[$map_id]))
		{
			return false;
		}

		$map_config = self::$map_config_list[$map_id];
		return isset($item) ? $map_config[$item] : $map_config;
	}
}
