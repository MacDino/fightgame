<?php
//读取用户所有装备,对应前台 "角色-背包"
//返回的格式应该是 array(装备名, 等级, 是否装备, json格式的基本属性, json格式的附加属性, json格式的强化属性);
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID

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
    //背包中全部装备
    $res = Equip_Info::getEquipListByUserId($userId);
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
    
    $data = $res;
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;   
}