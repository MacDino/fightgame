<?php
//获取用户信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';


$bindType   = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:'';//绑定用户类别
$bindValue  = isset($_REQUEST['user_value'])?$_REQUEST['user_value']:'';//绑定用户值$

if(!$bindType || !$bindValue)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}
$userId = User_Bind::getBindUserId($bindType, $bindValue, TRUE);

if(!$userId)
{
    $code = 1;
    $msg = '获取用户信息失败!';
    die;
}
$userInfo = User_Info::getBindUserId($userId);
if(!$userInfo)
{
    $code = 100001;
    $msg = '获取用户角色信息失败!';
    $data = array('user_id' => $userId);
    die;
}
