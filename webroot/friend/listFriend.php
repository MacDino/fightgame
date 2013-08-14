<?php
//显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo "UserId=====".$userId;exit;

//数据进行校验,非空,数据内
if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确!';
    $msg = '1';
    die;
}
$reslut = Friend_Info::getFriendInfo($userId);
var_dump($reslut);
try {
    //显示好友
    Friend_Info::getFriendInfo($userId);
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '显示好友失败!';
    $msg = '99';
    die;    
}