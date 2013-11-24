<?php
//获取登录用户唯一身份标识
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$bindType   = isset($_REQUEST['bind_type'])?$_REQUEST['bind_type']:'';//绑定用户类别
$bindValue  = isset($_REQUEST['bind_value'])?$_REQUEST['bind_value']:'';//绑定用户值
$passWord   = isset($_REQUEST['pass_word'])?$_REQUEST['pass_word']:'';//密码

if(!$bindType || !$bindValue || !$passWord){
	$code = 100001;
    $msg = '缺少必传参数';
    die;
}


try {
    $res = User_Bind::getBindUserId($bindType, $bindValue, $passWord);
    if($res)
    {
        $data = array('master_id' => $res); 
        die;
    }
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die; 
}

