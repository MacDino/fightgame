<?php
//显示积分
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

try {
//	Integral::fightIntegral(27 ,40);
	$data['total'] = Integral::getTodayIntegral($userId);
	$data['now'] = Integral::getTodayResidueIntegral($userId);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}