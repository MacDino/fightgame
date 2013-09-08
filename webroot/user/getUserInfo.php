<?php
//获取用户信息，包括用户基本信息，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

try {
    //使用中装备
    $equipInfo = Equip_Info::getEquipListByUserId($userId, TRUE);
	//角色基本属性(点)
	$baseAttribute = User_Info::getUserInfoFightAttribute($userId);
	//角色成长属性(值)
	$valueAttribute = User_Info::getUserInfoFightAttribute($userId, TRUE);
	
	$res = array('equipInfo'=>$equipInfo, 'baseAttribute'=>$baseAttribute, 'valueAttribute'=>$valueAttribute);
	$data = json_encode($res);
	
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}
