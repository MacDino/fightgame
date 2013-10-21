<?php
//装备详情
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$equipId     = isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID
//echo $equipId;exit;
if(!$equipId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$equipInfo = Equip_Infoget::EquipInfoById($equipId);
if(empty($equipInfo))
{
    $code = 2;
    $msg = '没有这个装备';
    die;
}

try{
	$data = Equip_Info::getEquipInfoById($equipId);
	if(!empty($data['attribute_base_list'])){
		$data['attribute_base_list'] = json_decode($data['attribute_base_list'], TRUE);
	}
	if(!empty($data['attribute_list'])){
		$data['attribute_list'] = json_decode($data['attribute_list'], TRUE);
	}
	
//	print_r($data);
    $code = 0;
    $msg = 'ok';
//    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}