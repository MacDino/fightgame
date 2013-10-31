<?php
//基于地理位置显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
//echo "lng=====$lng&lat====$lat";exit;
//echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';
//数据进行校验,非空,数据内
if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确!';
    $msg = '1';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
}

try {
    if(!empty($friendId)){
    	$res[] = User_Info::getUserInfoByUserId($friendId);
    }else{
    	$res = User_LBS::getNearbyFriend($userId, 1000000000);
    }
//    print_r($res);
    $data = User_LBS::getNearUser($res, $userId);
    
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
