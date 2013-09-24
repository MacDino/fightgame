<?php
//装备升级
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(2047);
$equipId = isset($_REQUEST['equip_id']) ? intval($_REQUEST['equip_id']) : 0;
$r = Equip_Info::upgrade($equipId);
var_dump($r);
