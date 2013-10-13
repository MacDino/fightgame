<?php
//合成内丹
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillType    = isset($_REQUEST['pill_type'])?$_REQUEST['pill_type']:'';//内丹类型

if(!$userId || !$pillType){
	$code = 1;
	$msg = "传入数据错误!";
	die;
}

$expend = Pill_Info::compoundPillExpend(1, 1);//消耗,生成时都是一级

$userInfo = User_Info::getUserInfoByUserId($userId);
if($expend['money'] > $userInfo['money']){
	$code = 2;
	$msg = "金钱不足!";
	die;
}

$ironNum = Iron_Info::getIronNumByLevel($userId, 1);//1级精铁
if($expend['iron'] > $ironNum){
	$code = 3;
	$msg = "精铁不足!";
	die;
}

$stoneNum = Stone_Info::getStoneNumBytype($userId, $pillType);
if($expend['stone'] > $stoneNum){
	$code = 4;
	$msg = "精华不足!";
	die;
}

try {
    Iron_Info::subtractIron($userId, 1, $ironNum);//减少精铁
    Stone_Info::subtractStone($userId, $pillType, $stoneNum);//减少阵法石
    User_Info::subtractMoney($userId, $expend['money']);//减少钱
    $data = Pill_Info::compoundPill($userId, $pillType);//生成内丹
//    print_r($data);
    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}
