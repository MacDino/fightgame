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
    $code = 140001;
    $msg = '没有这个装备';
    die;
}

//限制穿戴等级
if((int)$equipInfo['equip_level'] > (int)$userInfo['user_level']){
	$code = 140007;
	$msg = "您的等级不够";
	die;
}
try {
	$data = Equip_Info::useEquip($userId, $equipId);
	$code = 0;
	die;
} catch (Exception $e) {
	$code = 100099;
    $msg = '程序内部错误';
    die;
}
