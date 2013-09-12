<?php
/*
 * IAP Shop类
 */
class Shop_IAPProduct{

	const TABLE_NAME = "iap_product";
	const NORMAL_STATUS = 1;
	const SANDBOX_VERIFY_URL = "https://sandbox.itunes.apple.com/verifyReceipt";
	const BUY_VERIFY_URL     = "https://buy.itunes.apple.com/verifyReceipt";

	const PRESENT_TYPE_MONTH_PAY = 1;	//欢乐月
	const PRESENT_TYPE_INGOT = 2;		//元宝


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
	 *  产品详情
	 */
	public static function getInfoByProductId($productId){
		if(!is_numeric($productId))return FALSE;
		$res = MySql::selectOne(self::TABLE_NAME, array('product_id' => $productId));
		return $res;
	}

	/*
	 * 获取某一个套餐的元宝数
	 */
	public static function getIngotByProductId($productId){
		$res = self::getInfoByProductId($productId);	
		if(!empty($res['ingot']) && $res['ingot'] ){
			return $res['ingot'];
		}
		return 0;
	}

	/*
	 * 购买凭证验证借口
	 */
	public static function verifyReceipt($data){
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
			try{
				/*
				 * 向apple发起验证
				 */
				$verifyRes = self::sendReceiptToApple($receipt);	
				/*
				 * 验证成功时,更新购买记录表状态
				 */
				if(!empty($verifyRes) && is_array($verifyRes)){
					Shop_IAPPurchaseLog::updateVerifyStatus($res);		
					/*
					 * 更新用户元宝:套餐本身元宝+赠送元宝
					 */
					$product = self::getInfoByProductId($product_id);
					$ingot = $product['ingot'];
					$present_type = $product['present_type'];
					//赠送元宝
					if($present_type == self::PRESENT_TYPE_INGOT){
						$ingot += $product['present_num']; 
						User_Info::updateSingleInfo($user_id, 'ingot', $ingot, 2);
					} else if ($present_type == self::PRESENT_TYPE_MONTH_PAY){
					//赠送欢乐月	
							
					}
					return $verifyRes;
				}
			} catch (Exception $e){
				new Exception($e->getErrorMsg(), $e->getErrorCode());	
			}
		} else{
			throw new Exception ("请传入验证相关字段", 1);	
		}
	}

	/*
	 * 向apple发起凭证数据
	 */
	private function sendReceiptToApple($receipt){
		if (IAP_IS_SANDBOX) {     
			$endpoint = self::SANDBOX_VERIFY_URL;    
		}  else {     
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
