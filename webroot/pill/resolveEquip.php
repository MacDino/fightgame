<?php
//分解装备
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
$equipId		= isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID,数组

$equipId = json_decode($equipId, true);
if(!$userId || !is_array($equipId)){
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

$verify = Equip_Info::verifyEquipIsUsed($equipId);
if($verify > 0){
	$code = 140004;
    $msg = '有装备正在使用中';
    die;
}

try {
	foreach ($equipId as $i){
		$equipInfo = Equip_Info::getEquipInfoById($i);
		if($equipInfo['equip_level'] == 0){
			$code = 140102;
		    $msg = '0级装备不能分解';
		    die;
		}
		$level = $equipInfo['equip_level'] / 10;
		$res = Equip_Info::resolveEquip($userId, $i, $level);

		if($res){//成功
			if(!empty($res)){
				$data['level'] = $level;
				$data['num'] = 1;
			}
		}
	}

    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;       
}