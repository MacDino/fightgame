<?php
//选区进入游戏,获取用户列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$masterId   = isset($_REQUEST['master_id'])?$_REQUEST['master_id']:'';//帐号ID
$area	  = isset($_REQUEST['area'])?$_REQUEST['area']:'';//分区
//echo "masterId==$masterId&&area==$area";

if(!$masterId || !$area)
{
	$code = 1;
//    $msg = '传入参数不正确';
	$msg = '1';
    die;
}

try {
    //获取用户
    $data = User_Info::listUser($masterId, $area);
} catch (Exception $e) {
    $code = 0;
//    $msg = '获取账户失败!';
	$msg = '999';
    die;    
}
?>

