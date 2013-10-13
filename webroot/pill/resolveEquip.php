<?php
//分解装备
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
$equipId		= isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID,数组

$equipId = json_decode($equipId, true);

if(!$userId || !is_array($equipId))
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}