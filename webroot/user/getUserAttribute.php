<?php
//获取用户信息，包括用户已穿装备，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
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
    //使用中装备
    $res = Equip_Info::getEquipListByUserId($userId, 1);
    $pill = Pill_Pill::usedPill($userId);
    /*foreach ($res as $i=>$key){
    	$res[$i]['attribute_list'] = json_decode($key['attribute_list'], true);
    	$res[$i]['attribute_base_list'] = json_decode($key['attribute_base_list'], true);
    }*/
    foreach ($res as $i=>$key){
    	$res[$i]['attribute_list'] = json_decode($key['attribute_list'], true);
    	foreach ($res[$i]['attribute_list'] as $o=>$value){
    		if($o == ConfigDefine::RELEASE_PROBABILITY){
				$res[$i]['attribute_list'][$o] = round($value, 2)*100 . "%";
    		}else{
    			$res[$i]['attribute_list'][$o] = ceil($value);
    		}
		}
    	$res[$i]['attribute_base_list'] = json_decode($key['attribute_base_list'], true);
    	foreach ($res[$i]['attribute_base_list'] as $o=>$value){
			$res[$i]['attribute_base_list'][$o] = ceil($value);
		}
    	$res[$i]['price'] = Equip_Info::priceEquip($key['user_equip_id']);
    }
    $data['equipInfo'] = $res;
    
    $data['pillInfo'] = $pill;
	//角色基本属性(点)
	$data['baseAttribute'] = User_Info::getUserInfoFightAttribute($userId);
	foreach ($data['baseAttribute'] as $i=>$value){
		$data['baseAttribute'][$i] = ceil($value);
	}
	//角色成长属性(值)
	$data['valueAttribute'] = User_Info::getUserInfoFightAttribute($userId, TRUE);
	foreach ($data['valueAttribute'] as $i=>$value){
		if($i == ConfigDefine::RELEASE_PROBABILITY){
				$data['valueAttribute'][$i] = round($value, 2)*100 . "%";
    		}else{
    			$data['valueAttribute'][$i] = ceil($value);
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

