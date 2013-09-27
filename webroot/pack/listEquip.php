<?php
//显示装备列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(2047);

$userId     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
$equipType     = isset($_REQUEST['equip_type']) ? $_REQUEST['equip_type'] : '';
try {
	$data = Equip_Info::getEquipInfoByType($equipType, $userId);
	$code = 0;
	$msg = 'OK';
} catch (Exception $e) {
	$code = 1;
	$msg = '未查询到装备信息';
}
