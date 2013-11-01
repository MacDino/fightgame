<?php
//出售精铁
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillId      = isset($_REQUEST['pill_id'])?$_REQUEST['pill_id']:'';//内丹ID

if(!$userId || !$pillId){
	$code = 100001;
    $msg = '缺少必传参数';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

$pillInfo = Pill_Pill::getPillInfoById($pillId);
//有没有这个内丹
if(empty($pillInfo)){
	$code = 140106;
	$msg = "没有这个内丹!";
	die;
}

//是不是这个用户的
if($pillInfo['user_id'] != $userId){
	$code = 140108;
	$msg = "此内丹不属于你!";
	die;
}

try {
    $data = Pill_Pill::usePill($userId, $pillId);
//    print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;      
}
