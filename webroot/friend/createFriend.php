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
    //$msg = '传入参数不正确!';
    $msg = '1';
    die;
}

$userInfo = User_Info::isExistUser(array($userId, $friendId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
}

//查看是否还有位置添加好友
$friendNum = Friend_Info::getFriendNum($userId);
//echo $userInfo['friend_num'];
if($friendNum == $userInfo['friend_num']){
	$code = 144;
    //$msg = '好友已达上限!';
    $msg = '5';
    die;
}

//是否已经是好友
$isFriend = Friend_Info::getUserFrined($friendId, $userId);
if(!empty($isFriend))
{
	$code = 1;
    //$msg = '已经是好友!';
    $msg = '4';
    die;
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
