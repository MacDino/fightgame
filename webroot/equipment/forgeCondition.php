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
	if($info['forge_level'] >= User::MAX_FORGE){//最大次数
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


try {
	//$info = self::getEquipInfoById($equipId);
	//增加属性值
	$data['forge_level'] = $info['forge_level'] + 1;
            	
    //基本属性
    $attributeBaseList = json_decode($info['attribute_base_list'], TRUE);
    foreach($attributeBaseList as $k=>$v){
        $attributeBaseList[$k] = $v * ($data['forge_level'] * 0.015);
        $attributeBaseList[$k] = ceil($attributeBaseList[$k]);
    }
    $data['attribute_base_list'] = $attributeBaseList;
    //附加属性
    $attributeList = json_decode($info['attribute_list'], TRUE);
    foreach($attributeList as $k=>$v){
        $attributeList[$k] = $v * ($data['forge_level'] * 0.01);
        if($k == ConfigDefine::RELEASE_PROBABILITY){
				$attributeList[$k] = round($attributeList[$k], 2)*100 . "%";
    		}else{
    			$attributeList[$k] = ceil($attributeList[$k]);
    		}
        
    }
    $data['attribute_list'] = $attributeList;
	$data['odds'] = Skill::getQuickAttributeForEquip($info['forge_level']);//成功率
	$data['needMoney'] = $needMoney;//需要的钱
	$data['money'] = $nowMoney;//现有的钱
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}
