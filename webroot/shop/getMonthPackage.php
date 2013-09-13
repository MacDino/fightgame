<?php
/*
 * 领取套餐赠品接口
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$user_id = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;
try{
	$data = Shop_IAPProduct::recordMonthPackage($user_id);	
} catch (Exception $e) {
	$code = $e->getCode();
	$msg = $e->getMessage();
}
