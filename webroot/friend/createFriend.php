<?php
//创建角色
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['userId'])?$_REQUEST['userId']:'';//用户ID
$friendId   = isset($_REQUEST['friendId'])?$_REQUEST['friendId']:'';//好友ID
$channel  = isset($_REQUEST['channel'])?$_REQUEST['channel']:'';//来源渠道

//数据进行校验,非空,数据内
$_allChannelType = array('lbs', 'weixin', 'sina', 'game');
if(!is_int($userId) || !is_int($friendId) || !in_array($channel, $_allChannelType))
{
    $code = 1;
    $msg = '传入参数不正确!';
    die;
}

//查询好友ID是否在用户表里存在//是否已经超过某等级 >40
$user_info = Mysql::query("select user_id from user_info where user_id = '$userId'");
$friend_info = Mysql::query("select user_id from user_info where user_id = '$friendId' and user_level < '40'");
if(!$user_info || !$friend_info)
{
	$code = 1;
    $msg = '用户信息错误!';
    die;
}

//是否已经是好友
if(!empty(Friend::getUserFrined($userId, $friendId)))
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