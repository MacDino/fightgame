<?php
//对应前台 "角色-人宠"
//驱使人宠  
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
}

$is_true = Pet::isPet($userId, $petId);
if(empty($is_true)){
	$code = 2;
	$msg = "他不是你的宠物啊";
}

try {
    $data = Pet::usePet($userId, $petId);
//    print_r($data);
//    var_dump($data);exit;
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}