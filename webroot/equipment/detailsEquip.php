<?php
//装备详情
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$equipId     = isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID
//echo $equipId;exit;
if(!$equipId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$equipInfo = Equip_Info::getEquipInfoById($equipId);
if(empty($equipInfo)){
    $code = 140001;
    $msg = '没有这个装备';
    die;
}

try{
	$data = Equip_Info::getEquipInfoById($equipId);
	if(!empty($data['attribute_base_list'])){
		$data['attribute_base_list'] = json_decode($data['attribute_base_list'], TRUE);
		foreach ($data['attribute_base_list'] as $i=>$value){
			$data['attribute_base_list'][$i] = ceil($value);
		}
	}
	if(!empty($data['attribute_list'])){
		$data['attribute_list'] = json_decode($data['attribute_list'], TRUE);
		foreach ($data['attribute_list'] as $i=>$value){
			if($i == ConfigDefine::RELEASE_PROBABILITY){
				$data['attribute_list'][$i] = round($value, 2)*100 . "%";
    		}else{
    			$data['attribute_list'][$i] = ceil($value);
    		}
		}
	}
	
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;    
}