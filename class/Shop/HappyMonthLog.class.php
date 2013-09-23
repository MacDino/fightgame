<?php
class Shop_HappyMonthLog {

	const TABLE_NAME = "user_happy_month_log";

	public static function insert($data){
		if(!$data || !is_array($data))return FALSE;
        $res = MySql::insert(self::TABLE_NAME,
              array(
                  'user_id'       	=> $data['user_id'],
                  'content' 		=> $data['content'],
                  'ctime'    	 	=> time(),
                ), TRUE);
		return $res;		
	}

	/*
	 * 获取购买记录列表
	 */
	public static function getLogsByUserId($user_id){
		$where = array(
			'user_id' 	=> $user_id,
		);	
		$sort = array(
			'ctime DESC'	
		);
		$res = MySql::select(self::TABLE_NAME, $where, $sort);
		return $res;
	} 

	/*
	 * 获取最后一次领取记录
	 */
	public static function getLastOne($user_id){
		$res = self::getLogsByUserId($user_id);
		return !empty($res) ? $res[0] : array();	
	}

	/*
	 * 是否24小时内领取
	 */
	public static function isGeted($user_id){
		$res = self::getLastOne($userId);
		if ( time() <  $res['ctime'] + (24 * 3600)) {
			return false;	
		} else {
			return true;
		}	
	}
	
}
