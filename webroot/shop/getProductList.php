<?php
/*
 * 内购产品列表接口
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
try {
	$data = Shop_IAPProduct::getIAPProductList();
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '套餐列表获取失败';
}
