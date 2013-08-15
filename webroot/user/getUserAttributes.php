<?php
//读取用户属性信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

//$res = User_Info::getUserInfoFightAttribute($userId);
//var_dump($res);
try {
    User_Info::getUserInfoFightAttribute($userId);
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '读取用户属性信息失败!';
    $msg = '99';
    die;    
}