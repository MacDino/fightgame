<?php
//升级内丹条件
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillId    = isset($_REQUEST['pill_id'])?$_REQUEST['pill_id']:'';//内丹ID

if(!$userId || !$pillId){
	$code = 1;
	$msg = "传入数据错误!";
	die;
}

$pillInfo = Pill_Pill::getPillInfoById($pillId);
if(empty($pillInfo)){
	$code = 8;
	$msg = "没有这个内丹";
}

if($pillInfo['pill_layer'] == 10 && $pillInfo['pill_level'] == 10){
	$code = 7;
	$msg = "已经满级";
}

if($pillInfo['pill_level'] == 10){//
	$pillInfo['pill_layer'] += 1;
	$pillInfo['pill_level'] = 1;
}else{
	$pillInfo['pill_level'] += 1;
}
//print_r ($pillInfo);
try {
	$userInfo = User_Info::getUserInfoByUserId($userId);
    $data['need'] = Pill_Pill::compoundPillExpend($pillInfo['pill_layer'], $pillInfo['pill_level']);
    $data['now']  = array(
    	'iron'  => Pill_Iron::getIronNumByLevel($userId, $pillInfo['pill_level']),
    	'stone' => Pill_Stone::getStoneNumBytype($userId, $pillInfo['pill_type']),
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