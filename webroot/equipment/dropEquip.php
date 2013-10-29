<?php
//显示装备列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(2047);

$equipId     = isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] : '';

if(!$equipId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$equipInfo = Equip_Info::getEquipInfoById($equipId);
if(empty($equipInfo))
{
    $code = 2;
    $msg = '没有这个装备';
    die;
}

try {
	$data = Equip_Info::dropEquip($equipId);
	$code = 0;
	$msg = 'OK';
	die;
} catch (Exception $e) {
	$code = 99;
	$msg = '内部错误';
	die;
}
