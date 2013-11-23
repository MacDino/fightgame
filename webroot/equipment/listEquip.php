<?php
//显示装备列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
$equipType     = isset($_REQUEST['equip_type']) ? $_REQUEST['equip_type'] : '';

if(!$userId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

try {
	
	$res = Equip_Info::getEquipInfoByType($equipType, $userId);
	
    foreach ($res as $i=>$key){
    	$res[$i]['attribute_list'] = json_decode($key['attribute_list'], true);
    	foreach ($res[$i]['attribute_list'] as $o=>$value){
			$res[$i]['attribute_list'][$o] = ceil($value);
		}
    	$res[$i]['attribute_base_list'] = json_decode($key['attribute_base_list'], true);
    	foreach ($res[$i]['attribute_base_list'] as $o=>$value){
			$res[$i]['attribute_base_list'][$o] = ceil($value);
		}
    	$res[$i]['price'] = Equip_Info::priceEquip($key['user_equip_id']);
    }
	$data = $res;
	$code = 0;
	die;
} catch (Exception $e) {
	$code = 100099;
    $msg = '程序内部错误';
    die;
}
