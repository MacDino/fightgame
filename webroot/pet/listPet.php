<?php
//对应前台 "角色-人宠"
//人宠列表  
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$a = array('3067');
echo json_encode($a);
$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 1;
	$msg = "没有这个用户";
}

$userInfo = User_Info::isExistUser(array($userId));
if(empty($userInfo)){
	$code = 2;
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