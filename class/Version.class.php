<?php
/**
 * 获取定义的静态资源版本号
 * @author lishengwei
 */
class Version
{
    CONST VERSION = 1;
	CONST MAP_VERSION = 1.01;
	CONST MONSTER_VERSION = 1.02;
	CONST ACTION_VERSION = 1.03;
	CONST SKILL_VERSION = 1.03;
	CONST EXP_VERSION = 1.01;

    public static function getStaticResourceVersion(){
        return self::VERSION;
    }
	
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
	
	public static function getActionList(){
		$res = ConfigDefine::actionList();
		foreach($res as $key=>$value)
		{
			$result[] = array('id'=> $key, 'name'=>$value);
		}
		return $result;
	}
	
	public static function getSkillList(){
		$res = ConfigDefine::skillList();
		foreach($res as $key=>$value)
		{
			$result[] = array('id'=> $key, 'name'=>$value);
		}
		return $result;
	}
	
	public static function getLevelExpList()
	{
		$res = MySql::select('level_info', array(), array('level', 'need_experience'));
		return $res;
	}
}
