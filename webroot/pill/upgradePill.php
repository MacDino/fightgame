<?php
//合成内丹
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillId    = isset($_REQUEST['pill_id'])?$_REQUEST['pill_id']:'';//内丹编号

if(!$userId || !$pillId){
	$code = 1;
	$msg = "传入数据错误!";
	die;
}

$pillInfo = Pill_Info::getPillInfoById($pillId);
if(empty($pillInfo)){
	$code = 8;
	$msg = "没有这个内丹";
}

if($pillInfo['pill_layer'] == 10 && $pillInfo['pill_level'] == 10){
	$code = 7;
	$msg = "已经满级";
}

if($pillInfo['pill_level'] == 10){//
	$pillInfo['pill_layer'] += 1;
	$pillInfo['pill_level'] = 1;
}

$expend = Pill_Info::compoundPillExpend($pillInfo['pill_layer'], $pillInfo['pill_level']);//消耗

$userInfo = User_Info::getUserInfoByUserId($userId);
if($expend['money'] > $userInfo['money']){
	$code = 2;
	$msg = "金钱不足!";
	die;
}

$ironNum = Iron_Info::getIronNumByLevel($userId, $pillInfo['pill_layer']);
if($expend['iron'] > $ironNum){
	$code = 3;
	$msg = "精铁不足!";
	die;
}

$stoneNum = Stone_Info::getStoneNumBytype($userId, $pillInfo['pill_type']);
if($expend['stone'] > $stoneNum){
	$code = 4;
	$msg = "精华不足!";
	die;
}

try {
    Iron_Info::subtractIron($userId, $pillInfo['pill_layer'], $ironNum);//减少精铁
    Stone_Info::subtractStone($userId, $pillInfo['pill_type'], $stoneNum);//减少阵法石
    User_Info::subtractMoney($userId, $expend['money']);//减少钱
    $data = Pill_Info::upgradePill($pillId, $pillInfo['pill_layer'], $pillInfo['pill_level']);//升级内丹
//    print_r($data);
    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}