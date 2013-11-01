<?php
//装备信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$equipId     = isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] : '';

if(!$equipId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$info = Equip_Info::getEquipInfoById($equipId);
if(empty($info)){
	$code = 140001;
    $msg = '没有这个装备';
    die;
}

try {
	$res = Equip_Info::getEquipInfoById($equipId);
    $data = json_decode($res['attribute_list'], true);
	$code = 0;
	die;
} catch (Exception $e) {
	$code = 100099;
    $msg = '程序内部错误';
    die;
}
