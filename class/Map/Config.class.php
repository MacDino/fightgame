<?php
/**
 * 地图配置类
 */
class Map_Config extends Model {

	protected static $table_name = 'map_list';

	// 获取地图列表
	public static function getMapList()
	{
		$ret = array();
		$map_list = self::select();
		foreach ($map_list as $value)
		{
			$ret[$value['map_id']] = array(
                'map_name'  => $value['map_name'],
                'start_level' => $value['start_level'],
            );
		}

		return $ret;
	}

	//获取地图配置
	public static function getMapConfig($map_id, $item = null)
	{
		if ( ! $map_config = self::getOneByMapId($map_id))
		{
			return false;
		}

		$map_config['monsters'] = array();

		$monsters = DB::table('map_monster')->getByMapId($map_id);
		foreach ($monsters as $monster)
		{
			$map_config['monsters'][$monster['monster_id']] = $monster['monster_name'];
		}

		return isset($item) ? $map_config[$item] : $map_config;
	}
}
