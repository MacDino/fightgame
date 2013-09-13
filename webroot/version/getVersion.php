<?php
//用来获取大分类版本信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

//$VersionId = array('MAP_VERSION' => 1.00, 'MONSTER_VERSION' => 1.00);
$VersionId     = isset($_REQUEST['version_id'])?$_REQUEST['version_id']:'';//版本ID,数组


if(is_array($VersionId)){
//	echo 1111;exit;
	//地图
	if(array_key_exists('MAP_VERSION', $VersionId)){
		if(Version::MAP_VERSION > $VersionId['MAP_VERSION']){
			$data['MAP_VERSION'] = Version::getMapList();
		}
	}else{
		$data['MAP_VERSION'] = Version::getMapList();
	}
	
	//怪物
	if(array_key_exists('MONSTER_VERSION', $VersionId)){
		if(Version::MAP_VERSION > $VersionId['MONSTER_VERSION']){
			$data['MONSTER_VERSION'] = Version::getMonsterList();
		}
	}else{
		$data['MONSTER_VERSION'] = Version::getMonsterList();
	}
}
//var_dump($data);
$code = 0;
$msg = 'ok';