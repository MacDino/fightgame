<?php
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
	$res = Shop_IAPProduct::verifyReceipt($jsondata);	
} catch (Exception $e) {

}
