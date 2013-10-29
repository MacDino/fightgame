<?php
//选区进入游戏,获取用户列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
	$code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
}

try {
    $data = User_Info::delUser($userId);
//    print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 99;
	$msg = '内部错误';
    die;    
}
