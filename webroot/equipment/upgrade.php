<?php
//装备升级
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$equipId = isset($_REQUEST['equip_id']) ? intval($_REQUEST['equip_id']) : '';

if(!$equipId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

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
    $res = Equip_Info::upgrade($equipId);
    if($res){
    	$data = Equip_Info::getEquipInfoById($equipId);
    }
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;
}
