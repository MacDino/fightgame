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


try {
	
	$attributeList = json_decode($info['attribute_base_list'], TRUE);
	$forgeAttributeList = Equip_Config::forgeAttributeList();
        //增加属性值
    foreach($attributeList AS $k=>$v){
            if(isset($forgeAttributeList[$info['equip_type']][$k])){
                $res[$k] = $v;
        }
    }
	
	
	$data['odds'] = Skill::getQuickAttributeForEquip($info['forge_level']);;//成功率
	$data['add'] =  $res;//增加的属性
	$data['needMoney'] = $needMoney;//需要的钱
	$data['money'] = $nowMoney;//现有的钱
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;     
}
