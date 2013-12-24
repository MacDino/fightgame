<?php
//装备升级
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$equipId = isset($_REQUEST['equip_id']) ? intval($_REQUEST['equip_id']) : '';

if(!$equipId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}
$info = Equip_Info::getEquipInfoById($equipId);
if(!empty($info)){
	if($info['equip_level'] >= 100){
		$code = 140005;
	    $msg = '已经达到最高等级';
	    die;
	}elseif ($info['equip_level'] < 30){
		$code = 140006;
	    $msg = '当前装备等级不够30级,不能使用成长符';
	    die;
	}
}else{
    $code = 140001;
    $msg = '没有这个装备';
    die;
}
try {
    //基本属性
    $attributeBaseList = json_decode($info['attribute_base_list'], TRUE);
    foreach($attributeBaseList as $k=>$v){
        $attributeBaseList[$k] = ceil($attributeBaseList[$k]);
    }
    $data['attribute_base_list'] = $attributeBaseList;
    //附加属性
    $attributeList = json_decode($info['attribute_list'], TRUE);
    foreach($attributeList as $k=>$v){
        if($k == ConfigDefine::RELEASE_PROBABILITY){
			$attributeList[$k] = round($attributeList[$k], 2)*100 . "%";
		}else{
			$attributeList[$k] = ceil($attributeList[$k]);
		}
    }
    $data['attribute_list'] = $attributeList;
	$data['prop_num'] = User_Property::getPropertyNum($info['user_id'], 33);
	$data['need_num'] = ($info['equip_level'] - 20) / 10;
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;
}
