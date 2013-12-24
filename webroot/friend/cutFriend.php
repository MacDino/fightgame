<?php
//雇佣好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友

//好友一天最多被雇佣5次

//数据进行校验,非空,数据内
if(!$userId || !$friendId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

//查询用户ID是否在用户表里存在
$userInfo = User_Info::isExistUser(array($userId, $friendId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

$testfriend = Friend_Info::testFriend($userId, $friendId);

try {
    //雇佣好友
    $res = Friend_Info::cutFriend( $userId, $friendId );
    $data = $res;
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;   
}