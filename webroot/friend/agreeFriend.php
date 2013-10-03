<?php
//通过好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
//echo "UserId===".$userId."&FriendId===".$friendId;exit;

//数据进行校验,非空,数据内
if(!$userId || !$friendId)
{
    $code = 1;
    $msg = '传入参数不正确!';
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

//查看是否还有位置添加好友
$friendNum = Friend_Info::getFriendNum($userId);
//var_dump($friendNum);exit;
if($friendNum == $userInfo['friend_num']){
	$code = 3;
    $msg = '好友已达上限!';
    die;
}

try {
    //添加好友
    $data = Friend_Info::agreeFriendInfo($userId, $friendId);
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '添加好友失败!';
    die;    
}