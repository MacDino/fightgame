<?php
//赠送PK符
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
$isFriend = Friend_Info::getUserFrined($userId, $friendId);
if(empty($isFriend)){
	$code = 160001;
    $msg = '没有这个好友!';
    die;
}

$isAccept = Friend_Good::isAcceptPK($userId, $friendId);
//echo $isAccept;
if(empty($isAccept)){
	$code = 160015;
	$msg = "今天他没有送过你PK符";
	die;
}else{
	if($isAccept['status']){
		$code = 160014;
		$msg = "今天已经接收过他的赠送了";
		die;
	}
}

$acceptPkNum = Friend_Good::acceptPKNum($userId);
if($acceptPkNum >= Friend_Good::ACCEPT_NUM){
	$code = 160012;
	$msg = "你今天已经接收足够多的PK符了";
	die;
}

try {
    //拒绝好友申请
    $data = Friend_Good::acceptPK($userId, $friendId);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}