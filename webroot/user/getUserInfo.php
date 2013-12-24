<?php
//获取用户信息，包括用户基本信息，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$longitude = isset($_REQUEST['longitude'])?$_REQUEST['longitude']:'-1';//精度
$latitude = isset($_REQUEST['latitude'])?$_REQUEST['latitude']:'-1';//纬度

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
	User_Info::updateLastLoginTime($userId);//更新最后登录时间
	if($longitude != '-1' && $latitude != '-1'){//记录经纬度
		User_LBS::recordLBS($userId, $longitude, $latitude);
	}
	Reward::login($userId);//判断登陆奖励
	if(Shop_IAPProduct::userIsBuyMonthPackage($userId)){
		Reward::monthCard($userId);//判断月卡奖励
	}
    //人物基本属性,数据库读取
	$data = User_Info::getUserInfoByUserId($userId);
	
	//人物血量,魔法,计算获得
	$valueAttribute = User_Info::getUserInfoFightAttribute($userId, TRUE);
    if(!empty($valueAttribute)){
    	$data['blood'] = intval($valueAttribute[ConfigDefine::USER_ATTRIBUTE_BLOOD]);
    	$data['magic'] = intval($valueAttribute[ConfigDefine::USER_ATTRIBUTE_MAGIC]);
    }
    
    //人宠信息
    $petInfo = Pet::usedPet($userId);
	if(!empty($petInfo)){
		$petAttribute = User_Info::getUserInfoFightAttribute($petInfo['user_id'], TRUE);
		$data['pet']['name'] = $petInfo['user_name'];
		$data['pet']['level']   = $petInfo['user_level'];
		$data['pet']['blood']   = intval($petAttribute[ConfigDefine::USER_ATTRIBUTE_BLOOD]);
		$data['pet']['magic']   = intval($petAttribute[ConfigDefine::USER_ATTRIBUTE_MAGIC]);
	}else{
		$data['pet'] = false;
	}
	
	//地图信息
	$userLastResult     = Fight_Result::getResult($userId);
	$data['map_id'] = $mapId > 0 ? $mapId : ($userLastResult['map_id'] > 0 ? $userLastResult['map_id'] : 1);
	$data['colors'] = Fight_Setting::getSettingByUserId($userId);
//	print_r($data);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;   
}
