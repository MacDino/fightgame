<?php
//对应前台 "角色-人宠"
//释放人宠
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$petId     = isset($_REQUEST['pet_id'])?$_REQUEST['pet_id']:'';//人宠ID

if(!$userId || !$petId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$userInfo = User_Info::isExistUser(array($userId, $petId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

$usedPet = Pet::usedPet($userId);
if(!empty($usedPet)){
	if($usedPet['user_id'] == $petId){
		$code = 160101;
		$msg = "TA正在被驱使";
		die;
	}
}

try {
    //显示好友
    $data = Pet::delPet($userId, $petId);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;  
}