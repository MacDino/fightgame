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
    foreach ($res as $k=>$v){
    	$lbs = User_LBS::getLBSByUserId($v['user_id']);
    	$res[$k]['longitude'] = $lbs['longitude'];
    	$res[$k]['latitude'] = $lbs['latitude'];
    }
//    print_r($res);exit;
    if(!empty($res)){
    	$result = User_LBS::getNearUser($res, $userId);
    	//print_r($result);
    	
    	foreach ($result as $key=>$value){
	    	$result[$key]['is_send'] = Friend_Good::isSendPK($userId, $value['user_id']);
	    	$friendInfo = User_Info::getUserInfoByUserId($value['user_id']);
	    	$result[$key]['use_time'] = $result[$key]['validity_time'];
	    	$result[$key]['price'] = $friendInfo['use_price'];
	    	$result[$key]['use_num'] = Friend_Info::getUseNum($value['user_id']);
	    	$result[$key]['distance'] = Friend_Info::formatDistance($result[$key]['distance']);
	    	/*if( >= 1000 && $result[$key]['distance'] < 10000){
		    	$result[$key]['distance'] = round($result[$key]['distance'] / 1000, 2) . "千米";
		    }elseif($result[$key]['distance'] >= 10000 && $result[$key]['distance'] < 100000){
		    	$result[$key]['distance'] = round($result[$key]['distance'] / 1000, 1) . "千米";
		    }elseif($result[$key]['distance'] >= 100000 && $result[$key]['distance'] < 1000000){
		    	$result[$key]['distance'] = round($result[$key]['distance'] / 1000, 0) . "千米";
		    }elseif($result[$key]['distance'] >= 1000000){
		    	$result[$key]['distance'] = ">999千米";
		    }else{
		    	$result[$key]['distance'] = $result[$key]['distance'] . '米';
		    }*/
	    	$result[$key]['power'] = ceil(User_Info::powerUser($value['user_id']));//战力
		    $result[$key]['Prestige'] = $friendInfo['reputation'];//声望
		    $result[$key]['Ranking'] = PK_Challenge::rankingAll($value['user_id']);//全国排名
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
    //$data['use_friend'] = Friend_Info::isUseFriend($userId);
    
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}
