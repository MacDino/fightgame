<?php
//对应前台"角色-属性"
//包括 使用中装备  角色基本属性  角色成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

//使用中装备
$equipInfo = Equip_Info::getEquipInfoByUserId($userId, TRUE);
var_dump($equipInfo);

//角色基本属性(点)
$baseAttribute = User_Info::getUserInfoFightAttribute($userId);
var_dump($baseAttribute);

//角色成长属性(值)
$valueAttribute = User_Info::getUserInfoFightAttribute($userId, TRUE);
var_dump($valueAttribute);