<?php
//添加好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
//echo "UserId===".$userId."&FriendId===".$friendId;exit;

//数据进行校验,非空,数据内
if(!$userId || !$friendId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId, $friendId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
}

//查看是否还有位置添加好友
$friendNum = Friend_Info::getFriendNum($userId);
$user = User_Info::getUserInfoByUserId($userId);
if($friendNum == $user['friend_num']){
	$code = 144;
    $msg = '好友已达上限!';
    die;
}

//查看对方是否有位置添加
$vFriendNum = Friend_Info::getFriendNum($friendId);
$vUser = User_Info::getUserInfoByUserId($friendId);
if($vFriendNum >= $vUser['friend_num']){
	$code = 4;
    $msg = '对方好友已达上限!';
    die;
}

//是否已经是好友
$isFriend = Friend_Info::getUserFrined($friendId, $userId);
$isPass = Friend_Info::getUserFrined($userId, $friendId);
if(!empty($isFriend))
{
	if(!empty($isPass)){
		$code = 8;
	    $msg = '已经是好友!';
	    die;
	}else{
		$code = 9;
	    $msg = '申请已经发出,请耐心等待!';
	    die;
	}
	
}

try {
    //添加好友
    $data = Friend_Info::createFriendInfo($friendId, $userId);
    //增加声望
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '添加好友失败!';
    $msg = '99';
    die;    
}
?>
