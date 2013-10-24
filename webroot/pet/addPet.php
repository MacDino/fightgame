<?php
//对应前台 "角色-人宠"
//新增人宠  
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$petId     = isset($_REQUEST['pet_id'])?$_REQUEST['pet_id']:'';//人宠ID

if(!$userId || !$petId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId, $friendId));
if(!$userInfo){
	$code = 3;
	$msg = "没有这个用户";
}

$is_space = Pet::verifyPet($userId);//是否还有位置
if(!$is_space){
	$code = 2;
	$msg = "没有足够的位置添加"; 
}
try {
    //显示好友
    $data = Pet::addPet($userId, $petId);
//    print_r($data);
    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}