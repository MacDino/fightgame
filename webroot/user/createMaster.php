<?php
//创建账号
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$account   = isset($_REQUEST['account'])?$_REQUEST['account']:'';//用户账号
$passWord   = isset($_REQUEST['pass_word'])?$_REQUEST['pass_word']:'';//用户密码

if(!$account || !$passWord)
{
    $code = 100001;
    die;
}

try{
	$data['master_id'] = User_Bind::createAccount($account, $passWord);
	$code = 0;
} catch (Exception $e) {
    $code = 100099;
}