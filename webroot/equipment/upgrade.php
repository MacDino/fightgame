<?php
//装备升级
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$equipId = isset($_REQUEST['equip_id']) ? intval($_REQUEST['equip_id']) : 0;
if(!$equipId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$info = self::getEquipInfoById($equipId);
if(!empty($info)){
	if($info['equip_level'] >= 100){
		$code = 6;
	    $msg = '已经达到最高等级';
	    die;
	}elseif ($info['equip_level'] < 30){
		$code = 7;
	    $msg = '当前装备等级不够30级,不能使用成长符';
	    die;
	}
}


try {
    $res = Equip_Info::upgrade($equipId);
    if($res){
    	$data = Equip_Info::getEquipInfoById($equipId);
    }
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;
}
