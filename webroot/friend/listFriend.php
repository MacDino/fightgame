<?php
//显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo "UserId=====".$userId;exit;

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
    //显示好友
    $res = Friend_Info::getFriendInfo($userId);
    if(!empty($res)){
    	$result = User_LBS::getNearUser($res, $userId);
    	foreach ($result as $key=>$value){
	    	$result[$key]['is_send'] = Friend_Good::isSendPK($userId, $value['user_id']);
	    	$friendInfo = User_Info::getUserInfoByUserId($value['user_id']);
	    	$result[$key]['power'] = User_Info::powerUser($value['user_id']);//战力
		    $result[$key]['Prestige'] = $friendInfo['reputation'];//声望
		    $result[$key]['Ranking'] = PK_Challenge::rankingFriend($value['user_id']);//排名
		    $result[$key]['Integral'] = $friendInfo['integral'];//积分
	    	
	    	$isAccept = Friend_Good::isAcceptPK($userId, $value['user_id']);
	    	if(!empty($isAccept)){
//	    		print_r($isAccept);
	    		if($isAccept['status'] == 1){
	    			$result[$key]['is_accept'] = 1;
	    		}else{
	    			$result[$key]['is_accept'] = 0;
	    		}
	    	}else{
	    		$result[$key]['is_accept'] = '';
	    	}
	    }
    }else{
    	$result = null;
    }
    
    
    $data['send'] = Friend_Good::SEND_NUM - Friend_Good::sendPKNum($userId);//剩余赠送次数
    $data['accept'] = Friend_Good::ACCEPT_NUM - Friend_Good::acceptPKNum($userId);//剩余接收次数
    $data['list'] = $result;//好友列表
    
    
    
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}
