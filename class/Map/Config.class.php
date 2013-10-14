<?php
/**
 * 地图配置类
 */
class Map_Config {

	protected static $table_name = 'map_list';

	// 获取地图列表
	public static function getMapList($where) {
		$map_list   = MySql::select(self::$table_name, $where);
        return $map_list;
	}

	//获取地图配置
	public static function getMapConfig($map_id, $item = null) {
		if ( ! $map_config = self::getOneByMapId($map_id)) {
			return false;
		}
		$map_config['monsters'] = array();

        $monsters = self::getMonsterByMapId($map_id);
		foreach ($monsters as $monster) {
			$map_config['monsters'][$monster['monster_id']] = $monster['monster_name'];
		}
		return isset($item) ? $map_config[$item] : $map_config;
	}

    public static function getOneByMapId($mapId) {
        if($mapId > 0) {
            $where = array('map_id' => $mapId);
            return MySql::selectOne(self::$table_name, $where);
        }
        return FALSE;
    }

    public static function getMonsterByMapId($mapId) {
        if($mapId > 0) {
            $where = array('map_id' => $mapId);
            return MySql::select('map_monster', $where);
        }
        return FALSE;
    }
}
