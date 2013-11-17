<?php
//选区进入游戏,获取用户列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId   = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//角色ID

if(!$userId)
{
	$code = 1;
    $msg = '传入参数不正确';
    die;
}

/*$user = User_Info::getUserInfoByUserId($userId);

if(empty($user)){
	$code = 2;
    $msg = '根本没有这个用户';
    die;
}*/

try {
	//技能
    $userInfo = User_Info::getUserInfoByUserId($userId);
    if($userInfo['skil_point'] > 0){
    	$data['skill'] = $userInfo['skil_point'];
    }else{
    	$data['skill'] = NULL;
    }
    
	//奖励
	$rewardInfo = Reward::getList($userId);
	if(count($rewardInfo) > 0){
		$data['reward'] = count($rewardInfo);
	}else{
		$data['reward'] = NULL;
	}
	
	//背包
	$equipNum = Equip_Info::getEquipNum($userId);
	if($equipNum >= $userInfo['pack_num']){
		$data['equip'] = 'full';
	}
	
	//人宠
	$petNum = Pet::petNum($userId);
	if($petNum >= $userInfo['pet_num']){
		$data['pet'] = 'full';
	}
	
	//宝盒
	
	//属性
	

//    print_r($data);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 99;
	$msg = '内部错误';
    die;    
}