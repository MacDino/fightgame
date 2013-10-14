<?php
//内丹列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
//echo $userId;
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

try {
	$res = Pill_Pill::listPill($userId);
//	var_dump($res);
	foreach ($res as $key=>$value){
		$res[$key]['nowAttribute'] = pill::pillAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//当前属性
		$res[$key]['nextAttribute'] = pill::nextLevelAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//下一级属性
	}
//	print_r($res);
	$data = $res;
    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}