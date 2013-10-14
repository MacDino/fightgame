<?php
//出售精铁
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$level      = isset($_REQUEST['level'])?$_REQUEST['level']:'';//精铁等级
$num		= isset($_REQUEST['num'])?$_REQUEST['num']:'1';//数量

if(!$userId || !$level || !$num){
	$code = 1;
	$msg = "传入数据错误!";
	die;
}

$ironNum = Pill_Iron::getIronNumByLevel($userId, $level);//精铁数量
if($num > $ironNum){
	$code = 4;
	$msg = "您没有这么多精铁!";
	die;
}

try {
	$price = Pill_Iron::ironPrice($level, $num);
    $iron = Pill_Iron::subtractIron($userId, $level, $num);//减少精铁
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
