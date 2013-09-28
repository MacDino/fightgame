<?php
/*
 * 用于验证由于网络等原因验证失败的凭证
 * 时间范围为三天
 */
include dirname(__FILE__).'/'.'../config/config.inc.php';
require LIB.'MI.php';
__autoload__();

$where = array (
	'verify_status' => -1,
	'ctime'	 => array(
		'opt' => 'between',
		'val' => date("Y-m-d H:i:s", strtotime('-3 day', time())),
		'valex' => date('Y-m-d H:i:s', time()),
	),	
);

$res = Shop_IAPPurchaseLog::getList($where);
empty ($res) && $res = array();
foreach ($res as $v){
	$receipt = $v['purchase_receipt'];
	try {
		$verifyRes = Shop_IAPProduct::sendReceiptToApple($receipt);
	} catch (Exception $e){
		$e->getCode();
		echo $e->getMessage();
		continue;			
	}
	if(!empty($verifyRes) && is_array($verifyRes)) {
		Shop_IAPPurchaseLog::updateVerifyStatus($v['log_id']); 
	} else {
		continue;
	}
}



function __autoload__ (){
	#autoload函数
	if(!function_exists('autoload_sae')) 
	{
		function autoload_sae($className) 
		{
			$fileName = str_replace('_', '/',$className) . '.class.php';
			$filePath = LIB . $fileName;
			if(file_exists($filePath)) 
			{
				return require($filePath);
			}   
			$filePath = CLS . $fileName;
			if(file_exists($filePath)) 
			{
				return require($filePath);
			}   
		}                                                                                
	}
																				  
	MI::registerAutoload('autoload_sae');
	MI::registerAutoload(array('MI', 'loadClass'));

	register_shutdown_function(array("Output", "generalOutPut"));
}
