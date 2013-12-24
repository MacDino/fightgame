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

/*$isUseFriend = Friend_Info::isUseFriend($userId);
if($isUseFriend){
	$code = 100398;
	$msg = "你已经雇佣了别人";
	die;
}*/
Friend_Info::clearPastFriend();
$num = Friend_Info::getUseNum($friendId);
if($num == 0){
	$code = 100198;
	$msg = "他被雇佣的次数太多,需要休息,明天请早";
	die;
}

$userInfo = User_Info::getUserInfoByUserId($userId);
$friendInfo = User_Info::getUserInfoByUserId($friendId);
if($friendInfo['use_price'] == 0){
	$code = 1001299;
	$msg = "他没有设置被雇佣";
	die;
}

if($userInfo['money'] < $friendInfo['use_price']){
	$code = 1001298;
	$msg = "你的钱不够雇佣";
	die;
}

try {
    //雇佣好友
    $res = Friend_Info::useFriend( $userId, $friendId );
	User_Info::addMoney($friendId, ceil($friendInfo['use_price'] * 0.92));
	Friend_Info::addHireList($userId, 2, $friendInfo['use_price']);
	User_Info::subtractMoney($userId, $friendInfo['use_price']);
	Friend_Info::addHireList($friendId, 1, ceil($friendInfo['use_price'] * 0.92));
	Message::createEmploymentMsg($friendId, $userId, ceil($friendInfo['use_price'] * 0.92));
    $data['use_price'] = $friendInfo['use_price'];
    $data['validity_time'] = date('Y-m-d H:i:s', strtotime("+1 day"));
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;   
}