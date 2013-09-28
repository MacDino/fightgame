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
	$res = Shop_IAPPurchaseLog::getLastOne($user_id, $product_id);
	$data['product_id'] = $res['product_id'];
	$data['user_id'] = $res['user_id'];
	$data['ctime']   = $res['ctime'];
	$code = 0;
} catch (Exception $e) {
	$code   = 1;
}
