<?php
//好友好处
class Friend_Good
{
	CONST TABLE_NAME = 'friend_good';
	
	CONST SEND_NUM = 5;
	CONST ACCEPT_NUM = 5;
	
	/** 赠送PK符 */
	public static function sendPK($userId, $friendId){
		$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId, 'send_time' => date('Y-m-d')));
		return $res;
	}
	
	/** 接收PK符 */
	public static function acceptPK($userId, $friendId){
		$res = MySql::update(self::TABLE_NAME, array('status' => 1), array('user_id' => $friendId, 'friend_id' => $userId, 'send_time' => date('Y-m-d')));
//		print_r($res);
		if($res){
			User_Property::updateNumIncreaseAction($userId, 6302, 1);//增加道具数量
		}
		
		return $res;
	}
	
	/** 今日已赠送数量 */
	public static function sendPKNum($userId){
		$res = MySql::selectCount(self::TABLE_NAME, array('user_id' => $userId, 'send_time' => date('Y-m-d')));
		return $res;
	}
	
	/** 今日已接收数量 */
	public static function acceptPKNum($userId){
		$res = MySql::selectCount(self::TABLE_NAME, array('friend_id' => $userId, 'send_time' => date('Y-m-d'), 'status' => 1));
		return $res;
	}
	
	/** 今日是否已赠送 */
	public static function isSendPK($userId, $friendId){
		$res = MySql::selectCount(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId, 'send_time' => date('Y-m-d')));
		return $res;
	}
	
	/** 今日是否已接收 */
	public static function isAcceptPK($userId, $friendId){
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $friendId, 'friend_id' => $userId, 'send_time' => date('Y-m-d')));
		return $res;
	}

	
}