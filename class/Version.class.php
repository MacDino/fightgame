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
	//地图
	public static function getMapList(){
		$res = MySql::select('map_list', array(), array('map_id', 'map_name'));
		foreach ($res as $key=>$value){
			$result[$key]['id'] = $value['map_id'];
			$result[$key]['name'] = $value['map_name'];
		}
		return $result;
	}
	//怪物
	public static function getMonsterList(){
		$res = MySql::select('map_monster', array(), array('monster_id', 'monster_name'));
		foreach ($res as $key=>$value){
			$result[$key]['id'] = $value['monster_id'];
			$result[$key]['name'] = $value['monster_name'];
		}
		return $result;
	}
	
	//前后缀
	public static function getTitleList(){
		$res = ConfigDefine::titleList();
		foreach($res as $key=>$value)
		{
			$result[] = array('id'=> $key, 'name'=>$value);
		}
		return $result;
	}
	
	//动作
	public static function getActionList(){
		$res = ConfigDefine::actionList();
		foreach($res as $key=>$value)
		{
			$result[] = array('id'=> $key, 'name'=>$value);
		}
		return $result;
	}
	//技能
	public static function getSkillList(){
		$res = ConfigDefine::skillList();
		foreach($res as $key=>$value)
		{
			$result[] = array('id'=> $key, 'name'=>$value);
		}
		return $result;
	}
	//升级经验
	public static function getLevelExpList()
	{
		$res = MySql::select('level_info', array(), array('level', 'need_experience'));
		return $res;
	}
}
