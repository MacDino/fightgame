<?php
//用户查看装备
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId =  isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
$equipId =   isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] : '';

$equipId = json_decode($equipId, true);

if(!is_array($equipId))$equipId = (array)$equipId;
$res = Equip_Info::viewEquip($userId, $equipId);
$newEquipKey = 'new_equip_'.$userId;
Counter::decr($newEquipKey);

$code = 0;
