<?php
/*
 * 购买符咒   适用于属性增强、双倍、挂机、装备打造、宝箱等
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';
$propsId	    = isset($_REQUEST['props_id'])?(int)$_REQUEST['props_id']:'';
$num	    	= isset($_REQUEST['num'])?(int)$_REQUEST['num']:1;			

if(!$userId || !$propsId)
{
    $code = 1;
    $msg = 'user_id and props_id are require';
    die;
}
try {
    $data = User_Property::buyUserProps($userId, $propsId, $num);
} catch (Exception $e) {
	$code = $e->getCode();
	$msg = $e->getMessage();
}
