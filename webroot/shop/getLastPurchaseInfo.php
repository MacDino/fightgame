<?php
/*
 * 取得某个产品最后一次购买信息
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$user_id 	= $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;
$product_id = $_REQUEST['product_id'] ? $_REQUEST['product_id'] : 0;
if(!$user_id || !$product_id){
	$code = 1;
	die;
}
try {
	$data = Shop_IAPPurchaseLog::getLastOne($user_id, $product_id);
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
}
