<?php
/*
 * 购买凭证验证接口
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
/*
 *  verify_data:
 *  {
 *		'product_id':1,
 *		'user_id':1,
 *		'receipt-data':'(base64编码后的数据)'
 *  }
 */
$jsondata = $_REQUEST['verify_data'] ? $_REQUEST['verify_data'] : '';
try{
	$data = Shop_IAPProduct::verifyReceipt($jsondata);	
} catch (Exception $e) {
	$code = $e->getCode();
	$msg = $e->getMessage();
}
