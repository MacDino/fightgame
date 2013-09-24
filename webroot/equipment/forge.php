<?php
//装备锻造
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$equipId = isset($_REQUEST['equip_id']) ? intval($_REQUEST['equip_id']) : 0;
if(!$equipId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

try {
    $data = Equip_Info::forge($equipId);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 1;
    $msg = '99';
    die;    
}
