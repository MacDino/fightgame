<?php
/*
 * 内购产品列表接口
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$userId = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;
try {
	$product = Shop_IAPProduct::getIAPProductList();
	foreach ($product as $k=>$v){
		if($v['product_id'] == 1) {
			$product[$k]['is_purchased'] = Shop_IAPProduct::userIsBuyMonthPackage($userId);
			$product[$k]['next_purchase_time'] = Shop_IAPProduct::getUserMonthPackageNextBuyTime($userId);
		}	
	}
	$data = $product;
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '套餐列表获取失败';
}
