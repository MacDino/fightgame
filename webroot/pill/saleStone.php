<?php
//出售精华
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$stoneType = isset($_REQUEST['stone_type'])?$_REQUEST['stone_type']:'';//精华类型
$num		= isset($_REQUEST['num'])?$_REQUEST['num']:'1';//数量

if(!$userId || !$stone_type || !$num){
	$code = 1;
	$msg = "传入数据错误!";
	die;
}

$stoneNum = Stone_Info::getStoneNumBytype($userId, $stoneType);//精华数量
if($num > $stoneNum){
	$code = 4;
	$msg = "您没有这么多内丹精华!";
	die;
}

try {
	$price = Stone_Info::stonePrice($level, $num);
    $iron = Stone_Info::subtractStone($userId, $stoneType, $num);//减少精铁
    $money = User_Info::addMoney($userId, $price);//增加钱
    $data = $price;
//    print_r($data);
    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}
