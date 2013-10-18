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

$info = self::getEquipInfoById($equipId);
if(!empty($info)){
	if($info['forge_level'] >= 15){//最大次数
	    $code = 6;
	    $msg = '已经达到最大锻造次数';
	    die;    		
	}
}

try {
    $data = Equip_Info::forge($equipId);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}
