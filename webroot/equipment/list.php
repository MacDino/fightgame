<?php
//显示装备列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';

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
	$data = Equip_Info::getEquipListByUserId($userId);
	$code = 0;
	die;
} catch (Exception $e) {
	$code = 100099;
    $msg = '程序内部错误';
    die;
}
