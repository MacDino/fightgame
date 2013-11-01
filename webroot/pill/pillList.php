<?php
//内丹列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo $userId;
if(!$userId){
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

try {
	$res = Pill_Pill::listPill($userId);
//	var_dump($res);
	foreach ($res as $key=>$value){
//		print_r($value);
		$res[$key]['nowAttribute'] = Pill::pillAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//当前属性
		$res[$key]['nextAttribute'] = Pill::nextLevelAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//下一级属性
	}
	$data = $res;
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}