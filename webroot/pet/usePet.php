<?php
//对应前台 "角色-人宠"
//驱使人宠  
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

$is_true = Pet::isPet($userId, $petId);
if(empty($is_true)){
	$code = 160002;
	$msg = "他不是你的宠物啊";
}

try {
    $data = Pet::usePet($userId, $petId);
//    var_dump($data);exit;
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die; 
}