<?php
//获取用户信息，包括用户已穿装备，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo $userId;exit;
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
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;    
}

