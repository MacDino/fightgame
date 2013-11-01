<?php
//升级内丹条件
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillId    = isset($_REQUEST['pill_id'])?$_REQUEST['pill_id']:'';//内丹ID

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
if(empty($pillInfo)){
	$code = 140106;
	$msg = "没有这个内丹";
	die;
}

if($pillInfo['pill_layer'] == 10 && $pillInfo['pill_level'] == 10){
	$code = 140107;
	$msg = "此内丹已经满级";
	die;
}

//下一级内丹等级
if($pillInfo['pill_level'] == 10){
	$pillInfo['pill_layer'] += 1;
	$pillInfo['pill_level'] = 1;
}else{
	$pillInfo['pill_level'] += 1;
}

try {
	$userInfo = User_Info::getUserInfoByUserId($userId);
    $data['need'] = Pill_Pill::compoundPillExpend($pillInfo['pill_layer'], $pillInfo['pill_level'], $pillInfo['pill_type']);
    $data['now']  = array(
    	'level' => $pillInfo['pill_layer'],
    	'iron'  => Pill_Iron::getIronNumByLevel($userId, $pillInfo['pill_layer']),
    	'type'  => $pillInfo['pill_type'],
    	'stone' => Pill_Stone::getStoneNumBytype($userId, $pillInfo['pill_type']),
    	'money' => $userInfo['money'],
    );
//    print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;    
}