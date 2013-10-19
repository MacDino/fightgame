<?php
//出售精铁
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$pillId      = isset($_REQUEST['pill_id'])?$_REQUEST['pill_id']:'';//内丹ID

if(!$userId || !$pillId){
	$code = 1;
	$msg = "传入数据错误!";
	die;
}

$pillInfo = Pill_Pill::getPillInfoById($pillId);
//有没有这个内丹
if(empty($pillInfo)){
	$code = 8;
	$msg = "没有这个内丹!";
	die;
}

//是不是这个用户的
if($pillInfo['user_id'] != $userId){
	$code = 9;
	$msg = "此内丹不属于你!";
	die;
}

try {
    $data = Pill_Pill::usePill($userId, $pillId);
//    print_r($data);
    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}
