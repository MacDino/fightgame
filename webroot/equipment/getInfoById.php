<?php
//装备信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
//error_reporting(2047);

$equipId     = isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] : 0;
try {
	$res = Equip_Info::getEquipInfoById($equipId);
    $data = json_decode($res['attribute_list'], true);
	$code = 0;
	$msg = 'OK';
} catch (Exception $e) {
	$code = 1;
	$msg = '未查询到装备信息';
}
