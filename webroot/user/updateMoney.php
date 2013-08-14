<?php
//更新金币数量
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$user_id     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
$money   		= isset($_REQUEST['money'])?$_REQUEST['money']:'';//数量
$change			= isset($_REQUEST['money'])?$_REQUEST['money']:'';//1为减少,空为增加

if(!$userId || !$money || !$change){
	$code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

//$res = User_Info::updateUserInfo($userId, array('money', $money));
//var_dump($res);exit;

try {
    User_Info::updateUserInfo($userId, array('money', $money));
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '更新金币数量失败!';
    $msg = '99';
    die;    
}