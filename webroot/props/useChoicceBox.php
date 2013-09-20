<?php
/*
 * 使用精品类宝箱
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';
$propsId		= isset($_REQUEST['props_id']) ?(int)$_REQUEST['props_id'] : '';

if(!$userId || !$propsId)
{
    $code = 1;
    $msg = 'user_id and props_id are require';
    die;
}
try {
    $data = User_Property::useChoiceTreasureBox ($userId, $propsId);
} catch (Exception $e) {
	$code = $e->getCode();
	$msg = $e->getMessage();
}
