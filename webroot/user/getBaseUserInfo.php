<?php
//获取用户信息，包括用户基本信息，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
if(!$userId)
{
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

try {    
	$data = User_Info::getUserInfoByUserId($userId);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die; 
}
