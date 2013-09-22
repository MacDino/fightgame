<?php
//用来获取大分类版本信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$VersionId     = isset($_REQUEST['version_id'])?$_REQUEST['version_id']:'';//版本ID,数组

$VersionId = json_decode($VersionId, TRUE);
if(is_array($VersionId) ){
//	echo 1111;exit;
	//地图
	if(array_key_exists('MAP_VERSION', $VersionId)){
		if(Version::MAP_VERSION > $VersionId['MAP_VERSION']){
			$data['MAP_VERSION']['code'] = Version::MAP_VERSION;
			$data['MAP_VERSION']['value'] = Version::getMapList();
		}
	}else{
		$data['MAP_VERSION']['code'] = Version::MAP_VERSION;
		$data['MAP_VERSION']['value'] = Version::getMapList();
	}
	
	//怪物
	if(array_key_exists('MONSTER_VERSION', $VersionId)){
		if(Version::MONSTER_VERSION > $VersionId['MONSTER_VERSION']){
			$data['MONSTER_VERSION']['code'] = Version::MONSTER_VERSION;
			$data['MONSTER_VERSION']['value'] = Version::getMonsterList();
		}
	}else{
		$data['MONSTER_VERSION']['code'] = Version::MONSTER_VERSION;
		$data['MONSTER_VERSION']['value'] = Version::getMonsterList();
	}
	
	//战斗过程
	if(array_key_exists('ACTION_VERSION', $VersionId)){
		if(Version::ACTION_VERSION > $VersionId['ACTION_VERSION']){
			$data['ACTION_VERSION']['code'] = Version::ACTION_VERSION;
			$data['ACTION_VERSION']['value'] = Version::getActionList();
		}
	}else{
		$data['ACTION_VERSION']['code'] = Version::ACTION_VERSION;
		$data['ACTION_VERSION']['value'] = Version::getActionList();
	}
	
	//技能
	if(array_key_exists('SKILL_VERSION', $VersionId)){
		if(Version::SKILL_VERSION > $VersionId['SKILL_VERSION']){
			$data['SKILL_VERSION']['code'] = Version::SKILL_VERSION;
			$data['SKILL_VERSION']['value'] = Version::getSkillList();
		}
	}else{
		$data['SKILL_VERSION']['code'] = Version::SKILL_VERSION;
		$data['SKILL_VERSION']['value'] = Version::getSkillList();
	}
	
	//升级经验
	if(array_key_exists('EXP_VERSION', $VersionId)){
		if(Version::EXP_VERSION > $VersionId['EXP_VERSION']){
			$data['EXP_VERSION']['code'] = Version::EXP_VERSION;
			$data['EXP_VERSION']['value'] = Version::getLevelExpList();
		}
	}else{
		$data['EXP_VERSION']['code'] = Version::EXP_VERSION;
		$data['EXP_VERSION']['value'] = Version::getLevelExpList();
	}
}else{
	$data['MAP_VERSION']['code'] = Version::MAP_VERSION;
	$data['MAP_VERSION']['value'] = Version::getMapList();
	
	$data['MONSTER_VERSION']['code'] = Version::MONSTER_VERSION;
	$data['MONSTER_VERSION']['value'] = Version::getMonsterList();
	
	$data['ACTION_VERSION']['code'] = Version::ACTION_VERSION;
	$data['ACTION_VERSION']['value'] = Version::getActionList();
	
	$data['SKILL_VERSION']['code'] = Version::SKILL_VERSION;
	$data['SKILL_VERSION']['value'] = Version::getSkillList();
	
	$data['EXP_VERSION']['code'] = Version::EXP_VERSION;
	$data['EXP_VERSION']['value'] = Version::getLevelExpList();
}
//var_dump($data);
$code = 0;
$msg = 'ok';