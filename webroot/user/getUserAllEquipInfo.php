<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//读取用户所有装备
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

//$AllEquipInfo = Equip::getEquipInfoByUserId($userId, FALSE);//所有装备
//var_dump($AllEquipInfo);
try {
    Equip::getEquipInfoByUserId($userId, FALSE);
    $code = 0;
    $msg = 'OK';
    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '读取用户装备信息失败!';
    $msg = '99';
    die;    
}