<?php
//装备锻造
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$equipId = isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] :"";

if(!$equipId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$info = Equip_Info::getEquipInfoById($equipId);
if(!empty($info)){
	if($info['forge_level'] >= 15){//最大次数
	    $code = 140002;
	    $msg = '已经达到最大锻造次数';
	    die;    		
	}
}else{
	$code = 140001;
    $msg = '没有这个装备';
    die;
}

$nowMoney = User_Info::getUserMoney($info['user_id']);
$needMoney = Equip_Info::forgePrice($info['forge_level']);
if($needMoney > $nowMoney){
	$code = 140003;
    $msg = '金钱不足';
    die;
}

try {
    $res = Equip_Info::forge($equipId);
    User_Info::subtractBindMoney($info['user_id'], $needMoney);
    $data['status'] = $res;
	$data['info'] = Equip_Info::getEquipInfoById($equipId);
	$data['info']['attribute_list'] = json_decode($data['info']['attribute_list'], true);
	$data['info']['attribute_base_list'] = json_decode($data['info']['attribute_base_list'], true);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;   
}
