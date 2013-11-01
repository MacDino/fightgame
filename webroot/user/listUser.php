<?php
//选区进入游戏,获取用户列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$masterId   = isset($_REQUEST['master_id'])?$_REQUEST['master_id']:'';//帐号ID
$area	  = isset($_REQUEST['area'])?$_REQUEST['area']:'';//分区
//echo "masterId==$masterId&&area==$area";

if(!$masterId || !$area){
	$code = 100001;
    $msg = '缺少必传参数';
    die;
}

try {
    //获取用户
    $data = User_Info::listUser($masterId, $area);
//    print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;    
}
?>

