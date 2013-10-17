<?php
//显示装备列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(2047);

$userId     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
$equipType     = isset($_REQUEST['equip_type']) ? $_REQUEST['equip_type'] : '';
try {
	
	if($equipType == 'pill'){
		$pill = Pill_Pill::listPill($userId);
	    foreach ($pill as $key=>$value){
			$pill[$key]['nowAttribute'] = pill::pillAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//当前属性
			$pill[$key]['nextAttribute'] = pill::nextLevelAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//下一级属性
		}
		$data = $pill;
	}else{
		$res = Equip_Info::getEquipInfoByType($equipType, $userId);
		foreach ($res as $i=>$key){
	    	$res[$i]['attribute_list'] = json_decode($key['attribute_list'], true);
	    	$res[$i]['attribute_base_list'] = json_decode($key['attribute_base_list'], true);
	    }
    $data = $res;
	}
	
	$code = 0;
	$msg = 'OK';
} catch (Exception $e) {
	$code = 1;
	$msg = '未查询到装备信息';
}
