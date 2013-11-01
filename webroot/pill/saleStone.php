<?php
//出售精华
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$stoneType = isset($_REQUEST['stone_type'])?$_REQUEST['stone_type']:'';//精华类型
$num		= isset($_REQUEST['num'])?$_REQUEST['num']:'1';//数量

if(!$userId || !$stoneType || !$num){
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

$stoneNum = Pill_Stone::getStoneNumBytype($userId, $stoneType);//精华数量
if($num > $stoneNum){
	$code = 140105;
	$msg = "您没有这么多内丹精华!";
	die;
}

try {
	$price = Pill_Stone::stonePrice($level, $num);
    $iron = Pill_Stone::subtractStone($userId, $stoneType, $num);//减少精铁
    $money = User_Info::addMoney($userId, $price);//增加钱
    $data = $price;
//    print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}
