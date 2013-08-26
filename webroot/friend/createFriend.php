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

//查询用户ID和好友ID是否在用户表里存在
//echo $userId;exit;
$userInfo = User_Info::getUserInfoByUserId($userId);
$friendInfo = User_Info::getUserInfoByUserId($friendId);
//print_r($user_info);exit;
if(!$userInfo || !$friendInfo)
{
	$code = 1;
    //$msg = '用户信息错误!';
    $msg = '2';
    die;
}

//查看是否还有位置添加好友
$friendNum = Friend_Info::getFriendNum($userId);
if($friendNum == $userInfo['friend_num']){
	$code = 1;
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
    Friend_Info::createFriendInfo($friendId, $userId);
    echo "<script>alert('添加成功');location.href='listFriend.php?user_id=$userId'</script>";
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
