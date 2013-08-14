<?php
//更新元宝数量
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$user_id     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
$ingot   		= isset($_REQUEST['ingot'])?$_REQUEST['ingot']:'';//元宝
$change			= isset($_REQUEST['ingot'])?$_REQUEST['ingot']:'';//1为减少,空为增加

if(!$userId || !$ingot || !$change){
	$code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

//$res = User_Info::updateUserInfo($userId, array('ingot', $ingot));
//var_dump($res);exit;

try {
    User_Info::updateUserInfo($userId, array('ingot', $ingot));
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '更新元宝数量失败!';
    $msg = '99';
    die;    
}