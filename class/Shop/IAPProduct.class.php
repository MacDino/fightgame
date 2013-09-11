<?php
/*
 * IAP Shop类
 */
class Shop_IAPProduct{

	const TABLE_NAME = "iap_product";
	const NORMAL_STATUS = 1;
	const SANDBOX_VERIFY_URL = "https://sandbox.itunes.apple.com/verifyReceipt";
	const BUY_VERIFY_URL     = "https://buy.itunes.apple.com/verifyReceipt";


	/*
	 * 套餐列表
	 */
	public static function getIAPProductList(){
		$where = array(
			'status' => 1,	
		);
		$res = MySql::select(self::TABLE_NAME, $where);
		return $res;
	}

	/*
	 * 购买凭证验证借口
	 */
	public static function verifyReceipt($data, $isSandBox =  false){
		$data = json_decode($data);	
		if($data && is_array($data)){
			$user_id = $data['user_id'];	
			$product_id = $data['product_id'];	
			$receipt = $data['receipt-data'];
			if(!$user_id || !$product_id || !$receipt) new Exception("缺少必传参数", 100001);
			/*
			 * 先入库记录，再验证
			 */	
			$res = Shop_IAPPurchaseLog::insert(array($user_id, $product_id, $receipt));

			/*
			 * 向apple发起验证
			 */



			/*
			 * 验证成功，返回验证结果，更新购买记录表状态
			 */
		}

	}

	/*
	 * 向apple发起凭证数据
	 */
	private function sendReceiptToApple($receipt, $isSandBox ){
		if ($isSandbox) {     
			$endpoint = self::SANDBOX_VERIFY_URL;    
		}     
		else {     
			$endpoint = self::BUY_VERIFY_URL;     
		}     

		$postData = json_encode(     
			array('receipt-data' => $receipt)     
		);     

		$ch = curl_init($endpoint);     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
		curl_setopt($ch, CURLOPT_POST, true);     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);     
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);  //这两行一定要加，不加会报SSL 错误   
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);   


		$response = curl_exec($ch);     
		$errno    = curl_errno($ch);     
		$errmsg   = curl_error($ch);     
		curl_close($ch);     
		if ($errno != 0) {     
			throw new Exception($errmsg, $errno);     
		}     

		$data = json_decode($response);     
		if (!is_object($data)) {     
			throw new Exception('Invalid response data');     
		}     

		//处理验证失败
		if (!isset($data->status) || $data->status != 0) {     
			throw new Exception('Invalid receipt');     
		}     

		//返回产品的信息              
		return array(     
			'quantity'       =>  $data->receipt->quantity,     
			'product_id'     =>  $data->receipt->product_id,     
			'transaction_id' =>  $data->receipt->transaction_id,     
			'purchase_date'  =>  $data->receipt->purchase_date,     
			'app_item_id'    =>  $data->receipt->app_item_id,     
			'bid'            =>  $data->receipt->bid,     
			'bvrs'           =>  $data->receipt->bvrs     
		);     
	}     

}
