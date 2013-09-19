<?php
//购买PK次数
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    $msg = 'user_id is required';
    die;
}
try {
    $data = User_Property::buyPackNum($userId);
} catch (Exception $e) {
	$code = $e->getCode();
	$msg = $e->getMessage();
}
