<?php
/*
 * 购买装备成长咒符
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';
$equipId	    = isset($_REQUEST['equip_id'])?(int)$_REQUEST['equip_id']:'';
$num	    	= isset($_REQUEST['num'])?(int)$_REQUEST['num']:0;			

if(!$userId || !$propsId)
{
    $code = 1;
    $msg = 'user_id and equip_id are require';
    die;
}
try {
    $data = User_Property::buyUserProps($userId, $equipId, $num);
} catch (Exception $e) {
	$code = $e->getCode();
	$msg = $e->getMessage();
}
