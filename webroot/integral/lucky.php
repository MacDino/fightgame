<?php
//积分抽奖
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
//echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

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

$integral = Integral::getResidueIntegral($userId);
if($integral < Integral::EXTRACTION_INTEGRAL){
	$code = 150050;
	$msg = '积分不够';
    die;
}

try {
	$data = Integral::integralLucky($userId);
//	print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;   
}