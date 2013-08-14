<?php
//显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

//echo $userId."===".$friendId."==".$channel;exit;
//数据进行校验,非空,数据内
//$_allChannelType = array('lbs', 'weixin', 'sina', 'game');

if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确!';
    $msg = '1';
    die;
}

//echo 555555;exit;
try {
    //添加好友
    $reslut = Friend_Info::getFriendInfo($userId);
    print_r($reslut);
    //增加声望
    
} catch (Exception $e) {
    $code = 1;
    //$msg = '添加好友失败!';
    $msg = '5';
    die;    
}