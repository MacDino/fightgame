<?php
//读取用户所有装备,对应前台 "角色-背包"
//返回的格式应该是 array(装备名, 等级, 是否装备, json格式的基本属性, json格式的附加属性, json格式的强化属性);
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

try {
    //背包中全部装备
    $res = Equip_Info::getEquipListByUserId($userId);
    foreach ($res as $i=>$key){
    	$res[$i]['attribute_list'] = json_decode($key['attribute_list'], true);
    	$res[$i]['attribute_base_list'] = json_decode($key['attribute_base_list'], true);
    	$res[$i]['price'] = Equip_Info::priceEquip($key['user_equip_id']);
    }
    $data = $res;
    $code = 0;
    $msg = 'ok';
//    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}