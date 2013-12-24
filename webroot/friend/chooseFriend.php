<?php
//基于地理位置显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
$page   = isset($_REQUEST['page'])?$_REQUEST['page']:'1';//页码
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
    	$res[0] = User_Info::getUserInfoByUserId($friendId);
    	$lbs = User_LBS::getLBSByUserId($friendId);
    	$res[0]['longitude'] = $lbs['longitude'];
    	$res[0]['latitude'] = $lbs['latitude'];
    }else{
    	$res = User_LBS::getNearbyFriend($userId, 9999999999);
    }
    //print_r($res);
    
    //print_r($res);exit;
    $result = User_LBS::getNearUser($res, $userId);

    $total = ceil ( count($result) / 20 );
	if($page > $total){
		$page = $total;
	}
	$offset = ($page-1) * 20;
    $result = array_slice($result, $offset, 20);
//    print_r($result);
    
    $already = Friend_Info::alreadyChooseFriend($userId);
    //print_r($already);
    foreach ($result as $key=>$value){
		$friendInfo = User_Info::getUserInfoByUserId($value['user_id']);
    	$result[$key]['power'] = User_Info::powerUser($value['user_id']);//战力
	    $result[$key]['Prestige'] = $friendInfo['reputation'];//声望
	    $result[$key]['Ranking'] = PK_Challenge::rankingAll($value['user_id']);//全国排名
	    if($result[$key]['distance'] >= 1000 && $result[$key]['distance'] < 10000){
		    	$result[$key]['distance'] = round($result[$key]['distance'] / 1000, 2) . "千米";
		    }elseif($result[$key]['distance'] >= 10000 && $result[$key]['distance'] < 100000){
		    	$result[$key]['distance'] = round($result[$key]['distance'] / 1000, 1) . "千米";
		    }elseif($result[$key]['distance'] >= 100000 && $result[$key]['distance'] < 1000000){
		    	$result[$key]['distance'] = round($result[$key]['distance'] / 1000, 0) . "千米";
		    }elseif($result[$key]['distance'] >= 1000000){
		    	$result[$key]['distance'] = ">999千米";
		    }else{
		    	$result[$key]['distance'] = $result[$key]['distance'] . '米';
		    }
	    $result[$key]['Integral'] = $friendInfo['integral'];//积分
	    if(in_array($value['user_id'], $already)){
	    	$result[$key]['status'] = 1;
	    }else{
	    	$result[$key]['status'] = 0;
	    }
    }
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
