<?php
//添加好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
//echo "UserId===".$userId."&FriendId===".$friendId;exit;

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

//查看是否还有位置添加好友
$friendNum = Friend_Info::getFriendNum($userId);
$user = User_Info::getUserInfoByUserId($userId);

//echo $user['friend_num'];
if($friendNum == $user['friend_num']){
	$code = 160002;
    $msg = '好友已达上限';
    die;
}

//查看对方是否有位置添加
$vFriendNum = Friend_Info::getFriendNum($friendId);
$vUser = User_Info::getUserInfoByUserId($friendId);
if($vFriendNum >= $vUser['friend_num']){
	$code = 160003;
    $msg = '对方好友已达上限';
    die;
}

//是否已经是好友
$isFriend = Friend_Info::getUserFrined($friendId, $userId);
$isPass = Friend_Info::getUserFrined($userId, $friendId);
if(!empty($isFriend))
{
	if(!empty($isPass)){
		$code = 160004;
	    $msg = '你们已经是好友了';
	    die;
	}else{
		$code = 160005;
	    $msg = '申请已经发出,请耐心等待';
	    die;
	}
	
}

try {
    //添加好友
    $data = Friend_Info::createFriendInfo($friendId, $userId);
    //增加声望
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;  
}
?>
