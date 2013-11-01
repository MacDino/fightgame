<?php
//读取用户所有装备,对应前台 "角色-背包"
//返回的格式应该是 array(装备名, 等级, 是否装备, json格式的基本属性, json格式的附加属性, json格式的强化属性);
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$equipId		= isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID,数组
//echo 111;var_dump(json_decode($equipId, true));exit;
$equipId = json_decode($equipId, true);
//print_r($equipId);
if(!$userId || !is_array($equipId)){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}
//echo 222;exit;

$verify = Equip_Info::verifyEquipIsUsed($equipId);
if($verify > 0){
	$code = 140004;
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
    //删除选中的装备,标签式删除
    foreach ($equipId as $o=>$key){
    	Equip_Info::delEquip($key);
    }
    //增加相应的金币
    $res = User_Info::addMoney($userId, $price);
    $userInfo = User_Info::getUserInfoByUserId($userId);
    $data = $userInfo['money'];
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;    
}