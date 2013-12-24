<?php
//拒绝好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID

//数据进行校验,非空,数据内
if(!$userId || !$friendId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$userInfo = User_Info::isExistUser(array($userId, $friendId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

//是否已经是好友
$isFriend = Friend_Info::getUserFrined($friendId, $userId);
if(empty($isFriend)){
	$code = 160001;
    $msg = '没有这个好友!';
    die;
}

try {
    //拒绝好友申请
    $data = Friend_Info::refuseFriend($userId, $friendId);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}