<?php
//读取用户基础信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

//$BaseInfo = User_Info::getUserInfoByUserId($userId);//基础信息
//var_dump($BaseInfo);
try {
    User_Info::getUserInfoByUserId($userId);
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '读取用户属性信息失败!';
    $msg = '99';
    die;    
}