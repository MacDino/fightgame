<?php
//显示内丹材料列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$type     = isset($_REQUEST['type'])?$_REQUEST['type']:'';//精华列表

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
	if($type == 'stone'){
		$stone = Pill_Stone::getStoneInfo($userId);//精华
	    foreach ($stone as $key=>$a){
	    	$stone[$key]['price'] = Pill_Stone::stonePrice($a['stone_type']);
	    }
		$data['stone'] = $stone;
	}elseif($type == 'pill'){
		$pill = Pill_Pill::listPill($userId);
	    foreach ($pill as $key=>$value){
			$pill[$key]['nowAttribute'] = Pill::pillAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//当前属性
			$pill[$key]['nextAttribute'] = Pill::nextLevelAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//下一级属性
		}
		$data['pill'] = $pill;
	}else{
		$iron = Pill_Iron::getIronInfo($userId);//精铁
	    foreach ($iron as $key=>$a){
	    	$iron[$key]['price'] = Pill_Iron::ironPrice($a['level']);
	    }
	    $data['iron'] = $iron;
	    
	    $stone = Pill_Stone::getStoneInfo($userId);//精华
	    foreach ($stone as $key=>$a){
	    	$stone[$key]['price'] = Pill_Stone::stonePrice($a['stone_type']);
	    }
		$data['stone'] = $stone;
		
		$pill = Pill_Pill::listPill($userId);
	    foreach ($pill as $key=>$value){
			$pill[$key]['nowAttribute'] = Pill::pillAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//当前属性
			$pill[$key]['nextAttribute'] = Pill::nextLevelAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//下一级属性
		}
		$data['pill'] = $pill;
	}
	
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}