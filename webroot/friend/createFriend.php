<?php
//创建角色
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
$channel  	= isset($_REQUEST['channel'])?$_REQUEST['channel']:'';//来源渠道
//echo $userId."===".$friendId."==".$channel;exit;
//数据进行校验,非空,数据内
/*$_allChannelType = array('lbs', 'weixin', 'sina', 'game');
if(!is_int($userId) || !is_int($friendId) || !in_array($channel, $_allChannelType))
{
    $code = 1;
    $msg = '传入参数不正确!';
    die;
}*/

//查询好友ID是否在用户表里存在

$user_info = User_Info::getUserInfoByUserId($userId);
//echo $user_id;exit;
if(!$user_info)
{
	$code = 1;
    $msg = '用户信息错误!';
    die;
}

//好友ID是否存在&是否满足等级限制 <40
$friend_info = User_Info::getUserInfoByLevel($friendId, '<', 40);
if(!$friend_info)
{
	$code = 1;
    $msg = '用户信息错误!或者已经超过40级!';
    die;
}

//是否已经是好友
$is_friend = Friend::getUserFrined($userId, $friendId);
if(!empty($is_friend))
{
	$code = 1;
    $msg = '已经是好友!';
    die;
}

try {
    //添加好友
    Friend::createFriendInfo($userId, $friendId, $channel);
    //增加声望
    
} catch (Exception $e) {
    $code = 1;
    $msg = '添加好友失败!';
    die;    
}