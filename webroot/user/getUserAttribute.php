<?php
//获取用户信息，包括用户已穿装备，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo $userId;exit;
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
	die;
}

try {
    //使用中装备
    $res = Equip_Info::getEquipListByUserId($userId, 1);
    foreach ($res as $i=>$key){
    	$res[$i]['attribute_list'] = json_decode($key['attribute_list'], true);
    	$res[$i]['attribute_base_list'] = json_decode($key['attribute_base_list'], true);
    }
    $data['equipInfo'] = $res;
	//角色基本属性(点)
	$data['baseAttribute'] = User_Info::getUserInfoFightAttribute($userId);
	//角色成长属性(值)
	$data['valueAttribute'] = User_Info::getUserInfoFightAttribute($userId, TRUE);
//	print_r($data);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}

