<?php
//读取用户正使用装备
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

//$UseEquipInfo = Equip::getEquipInfoByUserId($userId, FALSE);//所有装备
//var_dump($UseEquipInfo);

try {
    Equip::getEquipInfoByUserId($userId, TRUE);
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '读取用户装备失败!';
    $msg = '99';
    die;    
}