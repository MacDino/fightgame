<?php
class Version
{
	CONST MAP_VERSION = 1.01;
	CONST MONSTER_VERSION = 1.01;
	CONST ACTION_VERSION = 1.03;
	
	public static function getVersionId(){
		
	}
	
	public static function getMapList(){
		$res = MySql::select('map_list', array(), array('map_id', 'map_name'));
		return $res;
	}
	
	public static function getMonsterList(){
		$res = MySql::select('map_Monster', array(), array('monster_id', 'monster_name'));
		return $res;
	}
}