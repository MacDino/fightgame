<?php
//获取用户信息，包括用户已穿装备，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$equipId     = isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID
//echo $userId;exit;
if(!$equipId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}
try{
	
	$data = Equip_Info::getEquipInfoById($equipId);
	if(!empty($data['attribute_base_list'])){
		$data['attribute_base_list'] = json_decode($data['attribute_base_list'], TRUE);
	}
	if(!empty($data['attribute_list'])){
		$data['attribute_list'] = json_decode($data['attribute_list'], TRUE);
	}
	
//	print_r($data);
    $code = 0;
    $msg = 'ok';
//    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}