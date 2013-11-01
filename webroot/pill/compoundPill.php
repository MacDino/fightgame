<?php
//合成内丹
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillType    = isset($_REQUEST['pill_type'])?$_REQUEST['pill_type']:'';//内丹类型

if(!$userId || !$pillType){
	$code = 100001;
    $msg = '缺少必传参数';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

$expend = Pill_Pill::compoundPillExpend(1, 1);//消耗,生成时都是一级
$money = User_Info::getUserMoney($userId);
if($expend['money'] > $money){
	$code = 140003;
	$msg = "金钱不足!";
	die;
}

$ironNum = Pill_Iron::getIronNumByLevel($userId, 1);//1级精铁
if($expend['iron'] > $ironNum){
	$code = 140103;
	$msg = "精铁不足!";
	die;
}

$stoneNum = Pill_Stone::getStoneNumBytype($userId, $pillType);
if($expend['stone'] > $stoneNum){
	$code = 140101;
	$msg = "精华不足!";
	die;
}

try {
    Pill_Iron::subtractIron($userId, 1, $expend['iron']);//减少精铁
    Pill_Stone::subtractStone($userId, $pillType, $expend['stone']);//减少阵法石
    User_Info::subtractBindMoney($userId, $expend['money']);//减少钱
    $data = Pill_Pill::compoundPill($userId, $pillType);//生成内丹
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;   
}
