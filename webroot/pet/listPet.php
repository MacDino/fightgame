<?php
//对应前台 "角色-人宠"
//人宠列表  
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

if(!$userId){
	$code = 1;
	$msg = "没有ID";
}

$userInfo = User_Info::isExistUser($userId);
if(empty($userInfo)){
	$code = 1;
	$msg = "没有这个用户";
}

try {
    //显示好友
    $data = Pet::ListPet($userId);
//    print_r($data);
//    var_dump($data);exit;
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '99';
    die;    
}