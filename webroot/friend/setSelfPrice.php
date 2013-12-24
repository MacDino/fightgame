<?php
//设置自己的价格

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$price   = isset($_REQUEST['price'])?$_REQUEST['price']:'';//价格

//数据进行校验,非空,数据内
if(!$userId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

//查询用户ID是否在用户表里存在
$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

try {
    $data = User_Info::setSelfPrice($userId, $price);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;   
}