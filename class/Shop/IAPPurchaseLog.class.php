<?php
class Shop_IAPPurchaseLog{
	const TABLE_NAME = "iap_purchase_log";
	const VERIFY_SUCCESS_STATUS = 1;

	public static function insert($data){
		if(!$data || !is_array($data))return FALSE;
        $res = MySql::insert(self::TABLE_NAME,
              array(
                  'product_id'    	 => $data['product_id'],
                  'user_id'       	 => $data['user_id'],
                  'purchase_receipt' => $data['purchase_receipt'],
                  'ctime'    	 	=> date("Y-m-d H:i:s", time()),
                ), TRUE);
		return $res;		
	}

	/*
	 * 更新购买凭证验证状态
	 */
	public static function updateVerifyStatus($log_id){
		if(!$log_id || !$log_id > 0) return FALSE;
		$data = array(
			'verify_status' => self::VERIFY_SUCCESS_STATUS,
		);
		return self::update($log_id, $data);
	}

	public static function update($log_id, $data){
		$res = MySql::update(self::TABLE_NAME, $data, array('log_id' => $log_id));
		return $res;
	}

	/*
	 * 获取购买记录列表
	 */
	public static function getPurchaseLogByUserIdAndProductId($user_id, $product_id){
		$where = array(
			'user_id' 	=> $user_id,
			'product_id'=> $product_id,
			'verify_status' => self::VERIFY_SUCCESS_STATUS,	
		);	
		$sort = array(
			'ctime DESC'	
		);
		$res = MySql::select(self::TABLE_NAME, $where, NULL, $sort);
		return $res;
	} 
	
	public static function count ($where){
		$res = MySql::selectCount(self::TABLE_NAME, $where);	
		return $res;
	}

	public static function getCountByUserIdAndProductId($user_id, $product_id){
		$where = array(
			'user_id' 	=> $user_id,
			'product_id'=> $product_id,
			'verify_status' => self::VERIFY_SUCCESS_STATUS,	
		);	
		$count = self::count($where);
		return $count;	
	}

	/*
	 * 是否是首次购买
	 */
	public static function isFirst($user_id, $product_id){
		$count = self::getCountByUserIdAndProductId($user_id, $product_id);	
		if ($count > 1) {
			return FALSE;	
		}
		return TRUE;
	}


	/*
	 * 获取最后一次购买记录
	 */
	public static function getLastOne($user_id, $product_id){
		$res = self::getPurchaseLogByUserIdAndProductId($user_id, $product_id);
		return !empty($res) ? $res[0] : array();	
	}
	
	/*
	 * 获取列表 
	 */
	public static function getList($where){
		if(empty($where)) {
			return '';
		}
		$res = MySql::select(self::TABLE_NAME, $where);
		return $res;
	}
}
