<?php
//购买人宠上限
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

//基础校验
if(!$userId)
{
    $code = 1;
    $msg = 'user_id is required';
    die;
}

try {
    $data = User_Property::isuseDoubleHarvest($userId);
} catch (Exception $e) {
	$code = $e->getCode();
	$msg = $e->getMessage();
}
