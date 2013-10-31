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

	const MONTH_PRODUCT_ID = 3;			//欢乐月套餐产品ID

	/*
	 * 套餐列表
	 */
	public static function getIAPProductList(){
		$where = array(
			'status' => self::NORMAL_STATUS,	
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
		$data = json_decode($data, TRUE);	
		if($data && is_array($data)){
			$user_id = $data['user_id'];	
			$product_id = $data['product_id'];	
			$receipt = $data['receipt-data'];
			if(!$user_id || !$product_id || !$receipt) new Exception("缺少必传参数", 120001);
			/*
			 * 先入库记录，再验证
			 */	
			$logWhere = array(
				'user_id' 			=> $user_id,
				'product_id'		=> $product_id,
				'purchase_receipt'	=> $receipt,
			);
			$purchaseLogId = Shop_IAPPurchaseLog::insert($logWhere);
			try{
				/*
				 * 向apple发起验证
				 */
				$verifyRes = self::sendReceiptToApple($receipt, $user_id);	
				/*
				 * 验证成功时,更新购买记录表状态
				 */
				if(!empty($verifyRes) && is_array($verifyRes)){
					Shop_IAPPurchaseLog::updateVerifyStatus($purchaseLogId);		
					/*
					 * 更新用户元宝:套餐本身元宝+赠送元宝
					 */
					$product = self::getInfoByProductId($product_id);
					$ingot = $product['ingot'];
					$present_type = $product['present_type'];
					//赠送元宝
					if($present_type == self::PRESENT_TYPE_INGOT){
						$ingot += $product['present_num']; 
						User_Info::updateSingleInfo($user_id, 'ingot', $ingot, 1);
					} else if ($present_type == self::PRESENT_TYPE_MONTH_PAY){
					//赠送欢乐月	
					/*
					 * 欢乐月直接将元宝数入账
					 * 欢乐月赠送套餐需要手动领取,so这里不处理套餐赠送的逻辑 ,由另外的接口完成
					 */
						User_Info::updateSingleInfo($user_id, 'ingot', $ingot, 1);
					}

					/*
					 * 首充奖励
					 */
					if (Shop_IAPPurchaseLog::isFirst($user_id, $product_id)){
						Reward::firstCharge($user_id, $ingot);	
					}
					return $verifyRes;
				}
			} catch (Exception $e){
				new Exception($e->getErrorMsg(), $e->getErrorCode());	
			}
		} else{
			throw new Exception ("请传入验证相关字段", 120002);	
		}
	}

	/*
	 * 向apple发起凭证数据
	 */
	public function sendReceiptToApple($receipt, $user_id){
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
			throw new Exception('Invalid response data', 120003);     
		}     

		//处理验证失败
		if (!isset($data->status) || $data->status != 0) {     
			throw new Exception('Invalid receipt', 120004);     
		}     
		$userInfo = User_Info::getUserInfoByUserId($user_id);	
		$ingot = $userInfo['ingot'];

		//返回产品的信息              
		return array(     
			'quantity'       =>  $data->receipt->quantity,     
			'iap_product_id' =>  $data->receipt->product_id,     
			'transaction_id' =>  $data->receipt->transaction_id,     
			'purchase_date'  =>  $data->receipt->purchase_date,     
			'app_item_id'    =>  $data->receipt->app_item_id,     
			'bid'            =>  $data->receipt->bid,     
			'bvrs'           =>  $data->receipt->bvrs,
			'ingot'			 =>  $ingot,
		);     
	}     

	/*
	 * 领取欢乐月套餐赠送包
	 */
	public static function recordMonthPackage($userId){
		if(!$userId) {
			throw new Exception('用户ID为必传参数',120004);
		}
		$user = User_Info::getUserInfoByUserId ($userId);
		if(!$user){
			throw new Exception('无此用户',120005);
		}
		$lastPurchase = Shop_IAPPurchaseLog::getLastOne($userId, self::MONTH_PRODUCT_ID);
		if(!$lastPurchase){
			throw new Exception('未找到您的欢乐月套餐购买记录', 120006);
		}
		$ctime = strtotime($lastPurchase['ctime']);
		$endtime = strtotime("next month", $ctime);	
		if(time() > $endtime){
			throw new Exception('欢乐月套餐已过期,您不能进行赠品领取',120007);	
		}
		$pack = Props_Config::$month_package;
		/*
		 * 一天一领,防止刷包
		 */
		if(!Shop_HappyMonthLog::isGeted($userId)) {
			throw new Exception('您一天只能领取一次', 120008);	
		}	
		/*
		 * 解包 
		 */
		foreach ($pack as $k => $v){
			if($k == Props_Config::KEY_PROPS) {
				foreach ($v as $v2){
					$props_id = $v2['id'];	
					$num = $v2['num'];
					$propert = User_Property::getPropertyInfo($userId, $props_id);
					if(!$propert){
						$res = User_Property::createPropertylist($userId, $props_id, $num);
					} else {
						/*
						 * 处理pk咒符和其他咒符的不同入库表
						 */
						if($v2['is_pk'] && isset($v2['is_pk'])){
						  $res = User_Info::updateSingleInfo($userId, 'pk_num', $num, 1);	
						} else {
							$res = User_Property::addAmulet($userId, $props_id, $num);
						}
					}
				}				
			} else if ($k == Props_Config::KEY_INGOT){
				$ingot = $v;		
				$res = User_Info::updateSingleInfo($userId, 'ingot', $ingot, 1);
			}
		}
		/*
		 * 记录领取日志,
		 */
		Shop_HappyMonthLog::insert(array('user_id' => $userId, 'content' => json_encode($pack)));
		return $res;
	}
}
