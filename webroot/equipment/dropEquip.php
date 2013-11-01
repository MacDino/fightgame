<?php
//显示装备列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(2047);

$equipId     = isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] : '';

if(!$equipId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$equipInfo = Equip_Info::getEquipInfoById($equipId);
if(empty($equipInfo)){
    $code = 140001;
    $msg = '没有这个装备';
    die;
}

try {
	$data = Equip_Info::dropEquip($equipId);
	$code = 0;
	die;
} catch (Exception $e) {
	$code = 100099;
    $msg = '程序内部错误';
    die;
}
