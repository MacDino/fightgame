<?php
//删除好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID

//echo $userId."===".$friendId;exit;
//数据进行校验,非空,数据内
//$_allChannelType = array('lbs', 'weixin', 'sina', 'game');
if(!$userId || !$friendId)
{
    $code = 1;
    //$msg = '传入参数不正确!';
    $msg = '1';
    die;
}
//查询好友ID是否在用户表里存在
//echo $userId;exit;
$user_info = User_Info::getUserInfoByUserId($userId);
//print_r($user_info);exit;
if(!$user_info)
{
	$code = 1;
    //$msg = '用户信息错误!';
    $msg = '2';
    die;
}

//好友ID是否存在

$friend_info = User_Info::getUserInfoByUserId($friendId);


if(!$friend_info)
{
	$code = 1;
    //$msg = '用户信息错误!或者已经超过40级!';
    $msg = '3';
    die;
}

//是否已经是好友
$is_friend = Friend_Info::getUserFrined($userId, $friendId);
if(empty($is_friend))
{
	$code = 1;
    //$msg = '没有这个好友!';
    $msg = '4';
    die;
}

try {
    //添加好友
    
    Friend_Info::deleteFriendInfo($userId, $friendId);
    //增加声望
    
} catch (Exception $e) {
    $code = 1;
    //$msg = '添加好友失败!';
    $msg = '5';
    die;    
}