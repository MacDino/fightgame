<?php
//对应前台 "角色-人宠"
//人宠列表  
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

try {
    //显示好友
    $data = Pet::ListPet($userId);
//    print_r($data);
//    var_dump($data);exit;
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}