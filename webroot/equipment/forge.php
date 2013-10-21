<?php
//装备锻造
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$equipId = isset($_REQUEST['equip_id']) ? $_REQUEST['equip_id'] :"";

if(!$equipId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$info = Equip_Info::getEquipInfoById($equipId);
if(!empty($info)){
	if($info['forge_level'] >= 15){//最大次数
	    $code = 6;
	    $msg = '已经达到最大锻造次数';
	    die;    		
	}
}else{
	$code = 2;
    $msg = '没有这个装备';
    die;
}

try {
    $res = Equip_Info::forge($equipId);
    $data['status'] = $res;
	$data['info'] = Equip_Info::getEquipInfoById($equipId);
	$data['info']['attribute_list'] = json_decode($data['info']['attribute_list'], true);
	$data['info']['attribute_base_list'] = json_decode($data['info']['attribute_base_list'], true);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}
