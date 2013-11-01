<?php
//合成内丹条件
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillType    = isset($_REQUEST['pill_type'])?$_REQUEST['pill_type']:'';//内丹类型

if(!$userId || !$pillType){
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

$stoneNum = Pill_Stone::getStoneNumBytype($userId, $pillType);
if(1 > $stoneNum){
	$code = 140101;
	$msg = "精华不足!";
	die;
}

try {
	$user = User_Info::getUserInfoByUserId($userId);
    $data['need'] = Pill_Pill::compoundPillExpend(1, 1, $pillType);//消耗,生成时都是一级
    $data['now']  = array(
    	'level' => 1,
    	'iron' => Pill_Iron::getIronNumByLevel($userId, 1),
    	'type' => $pillType,
    	'stone' => Pill_Stone::getStoneNumBytype($userId, $pillType),
    	'money' => $user['money'],
	);
//    print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;    
}