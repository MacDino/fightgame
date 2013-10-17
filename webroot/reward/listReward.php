<?php
//奖励列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

try {
	$res = Reward::getList($userId);
	foreach ($res as $i=>$key){
    	$res[$i]['content'] = json_decode($key['content'], true);
    }
    $data = $res;
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}
