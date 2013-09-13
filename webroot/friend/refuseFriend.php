<?php
//拒绝好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID

//数据进行校验,非空,数据内
if(!$userId || !$friendId)
{
    $code = 1;
    //$msg = '传入参数不正确!';
    $msg = '1';
    die;
}
//查询好友ID是否在用户表里存在
//echo $userId;exit;
$userInfo = User_Info::getUserInfoByUserId($userId);
//print_r($user_info);exit;
if(!$userInfo)
{
	$code = 1;
    //$msg = '用户信息错误!';
    $msg = '2';
    die;
}

//好友ID是否存在
$friendInfo = User_Info::getUserInfoByUserId($friendId);
if(!$friendInfo)
{
	$code = 1;
    //$msg = '用户信息错误!';
    $msg = '3';
    die;
}

//是否已经是好友
$isFriend = Friend_Info::getUserFrined($userId, $friendId);
if(empty($isFriend))
{
	$code = 1;
    //$msg = '没有这个好友!';
    $msg = '4';
    die;
}

try {
    //拒绝好友申请
    $data = Friend_Info::deleteFriendInfo($userId, $friendId);
    //减少声望
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '拒绝申请失败!';
    $msg = '99';
    die;    
}