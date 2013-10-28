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
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}
