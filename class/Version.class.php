<?php
/**
 * 获取定义的静态资源版本号
 * @author lishengwei
 */
class Version
{
    CONST VERSION = 1;
	CONST MAP_VERSION = 1.01;
	CONST MONSTER_VERSION = 1.04;
	CONST ACTION_VERSION = 1.03;
	CONST SKILL_VERSION = 1.03;
	CONST TITLE_VERSION = 1.03;
	CONST EQUIP_VERSION = 1.03;
	CONST EXP_VERSION = 1.01;
	CONST ATTRIBUTE_VERSION = 1.04;
	CONST PROPS_VERSION = 1.03;

    public static function getStaticResourceVersion(){
        return self::VERSION;
    }

	public static function getVersionId(){

	}
	//地图
	public static function getMapList(){
		$res = MySql::select('map_list', array(), array('map_id', 'map_name','start_level','end_level'));
		foreach ($res as $key=>$value){
			$result[$key]['id'] = $value['map_id'];
			$result[$key]['name'] = $value['map_name'];
            $result[$key]['start_level'] = $value['start_level'];
            $result[$key]['end_level'] = $value['end_level'];
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

	//基本属性
	public static function getAttributeList(){
		$res = ConfigDefine::attributeList();
		foreach($res as $key=>$value)
		{
			$result[] = array('id'=> $key, 'name'=>$value);
		}
		return $result;
	}

	//装备属性
	public static function getEquipList(){

		$res = ConfigDefine::equipList();
		foreach($res as $key=>$value)
		{
			$result[] = array('id'=> $key, 'name'=>$value);
		}
		return $result;
	}

	//道具列表
	public static function getPropsList()
	{
		$res = MySql::select('props', array(), array('static_code', 'props_name'));
		foreach($res as $key=>$value)
		{
			$result[] = array('id'=> $value['static_code'], 'name'=>$value['props_name']);
		}
		$pill = ConfigDefine::pillList();
		foreach ($pill as $key=>$value){
			$result[] = array('id'=> $key, 'name'=>$value);
		}
		return $result;
	}
}
