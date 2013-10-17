<?php
//显示内丹材料列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$stone     = isset($_REQUEST['stone'])?$_REQUEST['stone']:'';//精华列表

//echo $userId;exit;
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
	die;
}

try {
	if(!$stone){
		$iron = Pill_Iron::getIronInfo($userId);//精铁
	    foreach ($iron as $key=>$a){
	    	$iron[$key]['price'] = Pill_Iron::ironPrice($a['level']);
	    }
	    $data['iron'] = $iron;
	}
    
    $stone = Pill_Stone::getStoneInfo($userId);//精华
    foreach ($stone as $key=>$a){
    	$stone[$key]['price'] = Pill_Stone::stonePrice($a['stone_type']);
    }
	$data['stone'] = $stone;
	
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}