<?php
//获取用户信息，包括用户已穿装备，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

try {
    //使用中装备
    $data['equipInfo'] = Equip_Info::getEquipListByUserId($userId, 1);
	//角色基本属性(点)
//	$baseAttribute = User_Info::getUserInfoFightAttribute($userId);
	//角色成长属性(值)
//	$valueAttribute = User_Info::getUserInfoFightAttribute($userId, TRUE);
	
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}
