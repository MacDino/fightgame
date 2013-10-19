<?php
//合成内丹条件
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillType    = isset($_REQUEST['pill_type'])?$_REQUEST['pill_type']:'';//内丹类型

if(!$userId || !$pillType){
	$code = 1;
	$msg = "传入数据错误!";
	die;
}

$stoneNum = Pill_Stone::getStoneNumBytype($userId, $pillType);
if(1 > $stoneNum){
	$code = 4;
	$msg = "精华不足!";
	die;
}

try {
	$userInfo = User_Info::getUserInfoByUserId($userId);
    $data['need'] = Pill_Pill::compoundPillExpend(1, 1, $pillType);//消耗,生成时都是一级
    $data['now']  = array(
    	'level' => 1,
    	'iron' => Pill_Iron::getIronNumByLevel($userId, 1),
    	'type' => $pillType,
    	'stone' => Pill_Stone::getStoneNumBytype($userId, $pillType),
    	'money' => $userInfo['money'],
	);
//    print_r($data);
    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}