<?php
//显示装备列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(2047);

$equipId     = isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] : '';

try {
	$data = Equip_Info::dropEquip($equipId);
	$code = 0;
	$msg = 'OK';
} catch (Exception $e) {
	$code = 1;
	$msg = '脱下失败';
}
