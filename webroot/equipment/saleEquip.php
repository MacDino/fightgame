<?php
//读取用户所有装备,对应前台 "角色-背包"
//返回的格式应该是 array(装备名, 等级, 是否装备, json格式的基本属性, json格式的附加属性, json格式的强化属性);
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
$equipId		= isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID,数组
//echo 111;var_dump(json_decode($equipId, true));exit;
$equipId = json_decode($equipId, true);
//print_r($equipId);
if(!$userId || !is_array($equipId))
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}
//echo 222;exit;

$verify = Equip_Info::verifyEquipIsUsed($equipId);
if($verify > 0){
	$code = 5;
    $msg = '有装备正在使用中';
    die;
}

try {
    //循环装备ID得到总价值
    $price = 0;
    foreach ($equipId as $i=>$key){
    	$price += Equip_Info::priceEquip($key);
    }
    $userInfo = User_Info::getUserInfoByUserId($userId);
//    echo $price;exit;
    //删除选中的装备,标签式删除
    foreach ($equipId as $o=>$key){
    	Equip_Info::delEquip($key);
    }
    //增加相应的金币
    $res = User_Info::addMoney($userId, $price);
    $userInfo = User_Info::getUserInfoByUserId($userId);
    $data = $userInfo['money'];
    $code = 0;
    $msg = 'ok';
//    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}