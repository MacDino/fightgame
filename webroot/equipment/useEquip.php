<?php
//显示装备列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(2047);

$userId     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
$equipId     = isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] : '';

$userInfo = User_Info::getUserInfoByUserId($userId);
$equipInfo = Equip_Info::getEquipInfoById($equipId);

if(empty($equipInfo))
{
    $code = 2;
    $msg = '没有这个装备';
    die;
}

//限制穿戴等级
if((int)$equipInfo['equip_level'] > (int)$userInfo['user_level']){
	$code = 3;
	$msg = "等级不够";
	die;
}
try {
	
	
	$data = Equip_Info::useEquip($userId, $equipId);
	$code = 0;
	$msg = 'OK';
} catch (Exception $e) {
	$code = 99;
	$msg = '内部错误';
}
