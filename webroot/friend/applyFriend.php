<?php
//申请中好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo "UserId=====".$userId;exit;

//数据进行校验,非空,数据内
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

//查询用户ID是否在用户表里存在
$userInfo = User_Info::isExistUser(array($userId, $friendId));
if(!$userInfo)
{
	$code = 2;
    $msg = '用户信息错误!';
    die;
}

try {
    //显示好友
    $data = Friend_Info::getApplyFriendInfo($userId);
//    print_r($data);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}
