<?php
//对应前台 "角色-人宠"
//释放人宠
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$petId     = isset($_REQUEST['pet_id'])?$_REQUEST['pet_id']:'';//人宠ID

if(!$userId || !$petId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId, $petId));
if(!$userInfo){
	$code = 3;
	$msg = "没有这个用户";
	die;
}

$usedPet = Pet::usedPet($userId);
if(!empty($usedPet)){
	if($usedPet['user_id'] == $petId){
		$code = 3;
		$msg = "正在被使用";
		die;
	}
}

try {
    //显示好友
    $data = Pet::delPet($userId, $petId);
//    var_dump($data);exit;
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}