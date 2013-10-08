<?php
//获取用户信息，包括用户基本信息，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
	die;
}

try {    
    //人物基本属性,数据库读取
	$data = User_Info::getUserInfoByUserId($userId);
	
	//人物血量,魔法,计算获得
	$valueAttribute = User_Info::getUserInfoFightAttribute($userId, TRUE);
    if(!empty($valueAttribute)){
    	$data['blood'] = intval($valueAttribute[ConfigDefine::USER_ATTRIBUTE_BLOOD]);
    	$data['magic'] = intval($valueAttribute[ConfigDefine::USER_ATTRIBUTE_MAGIC]);
    }
    
    //人宠信息
    $pet = Pet::usedPet($userId);
	if(!empty($pet)){
		$petInfo = User_Info::getUserInfoByUserId($pet['pet_id']);
		$petAttribute = User_Info::getUserInfoFightAttribute($pet['pet_id'], TRUE);
		$data['pet']['name'] = $petInfo['user_name'];
//		$data['pet']['id']   = $petInfo['user_id'];
		$data['pet']['level']   = $petInfo['user_level'];
		$data['pet']['blood']   = intval($petAttribute[ConfigDefine::USER_ATTRIBUTE_BLOOD]);
		$data['pet']['magic']   = intval($petAttribute[ConfigDefine::USER_ATTRIBUTE_MAGIC]);
	}else{
		$data['pet'] = false;
	}
	
	//地图信息
	$userLastResult     = Fight_Result::getResult($userId);
//	$data['map_id'] = $mapId > 0 ? $mapId : ($userLastResult['map_id'] > 0 ? $userLastResult['map_id'] : 1);
	$data['colors'] = Fight_Setting::getSettingByUserId($userId);
//	print_r($data);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}
