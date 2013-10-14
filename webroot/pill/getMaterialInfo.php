<?php
//显示内丹材料列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

//echo $userId;exit;
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
	die;
}

try {
    $data['iron'] = Pill_Iron::getIronInfo($userId);//精铁
    $data['stone']= Pill_Stone::getStoneInfo($userId);//精华

    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}