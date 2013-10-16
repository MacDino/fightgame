<?php
//积分抽奖
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$integral = Integral::getTodayResidueIntegral($userId);
if($integral < Integral::EXTRACTION_INTEGRAL){
	$code = 23;
	$msg = '积分不够';
    die;
}

try {
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	$data = Integral::integralLucky($userId);
	print_r($data);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}