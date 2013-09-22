<?php
//显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$lng     = isset($_REQUEST['lng'])?$_REQUEST['lng']:'';//用户ID
$lat     = isset($_REQUEST['lat'])?$_REQUEST['lat']:'';//用户ID
//echo "lng=====$lng&lat====$lat";exit;

//数据进行校验,非空,数据内
if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确!';
    $msg = '1';
    die;
}

try {
    //显示好友
    $data = Friend_Info::getNearbyFriend($userId, $lng, $lat);
//    print_r($data);
//    var_dump($data);exit;
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}
