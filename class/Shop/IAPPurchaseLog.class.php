<?php
class Shop_IAPPurchaseLog{
	const TABLE_NAME = "iap_purchase_log";

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

}
