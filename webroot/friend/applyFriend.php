<?php
//申请中好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo "UserId=====".$userId;exit;

//数据进行校验,非空,数据内
if(!$userId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

//查询用户ID是否在用户表里存在
$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

try {
    //显示好友
    $res = Friend_Info::getApplyFriendInfo($userId);
    $result = User_LBS::getNearUser($res, $userId);
    foreach ($result as $key=>$value){
		$friendInfo = User_Info::getUserInfoByUserId($value['user_id']);
    	$result[$key]['power'] = User_Info::powerUser($value['user_id']);//战力
	    $result[$key]['Prestige'] = $friendInfo['reputation'];//声望
	    $result[$key]['Ranking'] = PK_Challenge::rankingAll($value['user_id']);//全国排名
	    $result[$key]['Integral'] = $friendInfo['integral'];//积分
    }
    if(!empty($result)){
    	$data['list'] = $result;
    }else{
    	$data = null;
    }
//    print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}
