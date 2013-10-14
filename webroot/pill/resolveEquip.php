<?php
//分解装备
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
$equipId		= isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID,数组

$equipId = json_decode($equipId, true);
//$equipId = array('570', '571', '580');
if(!$userId || !is_array($equipId))
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$verify = Equip_Info::verifyEquipIsUsed($equipId);
if($verify > 0){
	$code = 5;
    $msg = '有装备正在使用中';
    die;
}

try {
	foreach ($equipId as $i){
		$equipInfo = Equip_Info::getEquipInfoById($i);
		$level = $equipInfo['equip_level'] / 10;
		$res = Equip_Info::resolveEquip($equipInfo['user_equip_id'], $level);
		if($res){//成功
			if(!empty($data[$level])){
				$data[$level] += 1;
			}else{
				$data[$level] = 1;
			}
		}
	}
    $code = 0;
    $msg = 'ok';  
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}