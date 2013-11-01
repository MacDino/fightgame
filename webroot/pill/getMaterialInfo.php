<?php
//显示内丹材料列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$type     = isset($_REQUEST['type'])?$_REQUEST['type']:'';//精华列表
//echo $userId;exit;
if(!$userId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 100098;
	$msg = "读取用户信息错误";
	die;
}

try {
	if($type == 'stone'){//精华列表
		$stone = Pill_Stone::getStoneInfo($userId);//精华
	    foreach ($stone as $key=>$a){
	    	$stone[$key]['price'] = Pill_Stone::stonePrice($a['stone_type']);
	    }
		$data['stone'] = $stone;
	}elseif($type == 'pill'){//内丹列表
		$pill = Pill_Pill::listPill($userId);
	    foreach ($pill as $key=>$value){
			$pill[$key]['nowAttribute'] = Pill::pillAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//当前属性
			$pill[$key]['nextAttribute'] = Pill::nextLevelAttribute($value['pill_type'], $value['pill_layer'], $value['pill_level']);//下一级属性
		}
		$data['pill'] = $pill;
	}else{//精华,内丹,精铁列表
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
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;  
}