<?php
//基于地理位置显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
//echo "lng=====$lng&lat====$lat";exit;
//echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';
//数据进行校验,非空,数据内
if(!$userId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

try {
    if(!empty($friendId)){
    	$res[] = User_Info::getUserInfoByUserId($friendId);
    }else{
    	$res = User_LBS::getNearbyFriend($userId, 1000000000);
    }
//    print_r($res);
    $result = User_LBS::getNearUser($res, $userId);
    if(!empty($result)){
    	$data['list'] = $result;
    }else{
    	$data = null;
    }
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;    
}
