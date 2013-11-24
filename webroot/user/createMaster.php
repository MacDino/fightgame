<?php
//创建账号
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$bindType   = isset($_REQUEST['bind_type'])?$_REQUEST['bind_type']:'';//绑定用户类别
$bindValue  = isset($_REQUEST['bind_value'])?$_REQUEST['bind_value']:'';//绑定用户值
$passWord   = isset($_REQUEST['pass_word'])?$_REQUEST['pass_word']:'';//密码

if(!$bindType || !$passWord || !$bindValue)
{
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$nowMaster = User_Bind::getBindUerInfo($bindType, $bindValue);
if(!empty($nowMaster)){
	$code = 100003;
    $msg = '账号已经被使用';
    die;
}

try{
	$data['master_id'] = User_Bind::createBindUserInfo($bindType, $bindValue, $passWord);
	$code = 0;
	die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;
}