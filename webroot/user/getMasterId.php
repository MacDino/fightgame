<?php
//获取登录用户唯一身份标识
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$bindType   = isset($_REQUEST['bind_type'])?$_REQUEST['bind_type']:'';//绑定用户类别
$bindValue  = isset($_REQUEST['bind_value'])?$_REQUEST['bind_value']:'';//绑定用户值

if(!$bindType || !$bindValue)
{
	$code = 1;
    $msg = '传入参数不正确';
    die;
}


try {
    $res = User::getLoginUserId($bindType, $bindValue);
    if($res)
    {
        $data = array('master_id' => $res); 
        die;
    }
} catch (Exception $e) {
    $code = 99;
	$msg = '内部错误';
	die;
}

