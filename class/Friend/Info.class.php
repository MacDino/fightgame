<?php
//好友关联信息
class Friend_Info
{
    CONST TABLE_NAME = 'friend_info';

    /**
     * @desc 获取好友信息
     * @param int $userId		用户ID
     * @return array
     */
    public static function getFriendInfo($userId)
    {
        try{
        	//数据进行校验,非空,数据内
			if(!$userId) return FALSE;
			
			//查询好友信息
			$sql = "select u.user_id as user_id, u.sex as sex, u.race_id as race_id, u.user_name as user_name, u.user_level as user_level, f.validity_time as validity_time from user_info u, friend_info f where f.user_id = '$userId' AND f.friend_id = u.user_id AND f.is_pass = '1'";
			//
//			echo $sql;exit;
			$friendInfo = MySql::query($sql);
            return $friendInfo;
        }catch (Exception $e){
           return FALSE;
        }
    }

    /**
     * @desc 显示申请中好友信息
     * @param int $userId		用户ID
     * @return array
     */
    public static function getApplyFriendInfo($userId)
    {
        try{
        	//数据进行校验,非空,数据内
			if(!$userId)	return FALSE;
			//查询好友信息
			$sql = "select u.user_id as user_id, u.sex as sex, u.user_name as user_name, u.race_id as race_id, u.user_level as user_level from user_info u, friend_info f where f.friend_id = '$userId' AND f.user_id = u.user_id AND f.is_pass = '0'";
			//echo $sql;exit;
			$friendInfo = MySql::query($sql);
	        return $friendInfo;
        }catch (Exception $e){
           return FALSE;
        }
    }
    
    /**
     * @desc 查询已有好友数量
     * @param int $userId	用户ID
     * @return int
     */
    public static function getFriendNum($userId){
    	try{
        	//数据进行校验,非空,数据内
			if(!$userId)	return FALSE;
			//查询好友数量
			$friendInfo = Mysql::selectCount(self::TABLE_NAME, array('user_id' => $userId, 'is_pass' => 1));
			
            return $friendInfo;
        }catch (Exception $e){
           return FALSE;
        }
    }

    /**
     * @desc 添加好友
     * @param int $userId		用户ID
     * @param int $friendId		好友ID
     * @param int $is_pass		是否通过好友,没有的话是未通过,有的话是直接通过(好友邀请)
     * @return Bool
     */
    public static function createFriendInfo($userId, $friendId, $is_pass = FALSE)
    {
//    	echo "UserId===".$userId."&FriendId===".$friendId;exit;
    	//数据进行校验,非空,数据内
    	if(!$userId || !$friendId) return FALSE;

		//是否已添加过好友
		$is_friend = self::getUserFrined($userId, $friendId);
		if(!empty($is_friend)) return FALSE;
		
		if(!$is_pass){
			$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId));//默认未通过
		}else{
			$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId, 'is_pass' => 1));//默认通过
			$res = MySql::insert(self::TABLE_NAME, array('user_id' => $friendId, 'friend_id' => $userId, 'is_pass' => 1));//默认通过,并且添加对方为好友
		User_Info::addReputationNum($user_info['user_id'], 2);
        	User_Info::addReputationNum($friend_info['user_id'], 2);
		}

        if($res){
            return TRUE;
        }else{
        	return FALSE;
        }
    }

    /**
     * @desc 通过好友申请
     * @param int $userId		用户ID
     * @param int $friendId		好友ID
     */
    public static function agreeFriendInfo($userId, $friendId)
    {
    	//数据进行校验,非空,数据内
    	if(!$userId || !$friendId) return FALSE;

		$res = MySql::update(self::TABLE_NAME, array('is_pass' => 1), array('user_id' => $friendId, 'friend_id' => $userId ));//通过状态
		//通过好友申请的同时添加对方为好友,默认通过
		MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId));//默认通过
		MySql::update(self::TABLE_NAME, array('is_pass' => 1), array('user_id' => $userId, 'friend_id' => $friendId ));//通过状态
		if($res)
        {
        	//同时增加user_id声望
        	User_Info::addReputationNum($user_info['user_id'], 2);
        	User_Info::addReputationNum($friend_info['user_id'], 2);
            return TRUE;
        }else{
        	return FALSE;
        }
    }

    //删除好友
    public static function deleteFriendInfo($userId, $friendId)
    {
    	//简单检测
    	if(!$userId || !$friendId)	return FALSE;

    	//好友是否存在
    	$user_info = User_Info::getUserInfoByUserId($userId);
		$friend_info = User_Info::getUserInfoByUserId($friendId);

        $res = MySql::delete(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId));
        $result = MySql::delete(self::TABLE_NAME, array('user_id' => $friendId, 'friend_id' => $userId));

        if($res && $result)
        {
        	User_Info::subtractReputationNum($user_info['user_id'], 2);
        	User_Info::subtractReputationNum($friend_info['user_id'], 2);
        	//同时减少user_id声望
            return TRUE;
        }else{
        	return TRUE;
        }
    }

    //拒绝好友
    public static function refuseFriend($userId, $friendId){
    	//简单检测
    	if(!$userId || !$friendId)	return FALSE;

    	$res = MySql::delete(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId));
    	return $res;
    }

    /**
     * @desc 检测是否已经添加过这个好友
     * @param int $userId		用户ID
     * @param int $friendId		好友ID
     * @return Bool
     */
	public static function getUserFrined($userId, $friendId)
	{
		//简单检测
		if(!$userId || !$friendId)	return FALSE;

		$friendInfo = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId, 'is_pass' => 1));
		
       	if(!empty($friendInfo)){
            return TRUE;
        }else{
        	return FALSE;
        }
	}
	
	/**
	 * 是否申请过
	 */
	public static function isCreate($userId, $friendId){
		$sql = "select * from friend_info where user_id = '$userId' and friend_id = '$friendId'";
		return MySql::query($sql);
	}

	/** @赠送PK符 */
	public static function sendPkNum(){
		//判断是否是好友
		
		//今天是否送过
		
		//是否有发送次数限制
	}
	
	public static function acceptPKNum(){
		//判断是否好友
		
		//接受次数限制
	}
	
	public static function getUseNum( $userId ){
		
		$time = date('Y-m-d');
		$begin = strtotime($time.' 00:00:00');
		$end   = strtotime($time.' 23:59:59');
		$sql = "select * from friend_info where friend_id = '$userId' and validity_time >= '$begin' and validity_time <= '$end' ";
		$res = MySql::query($sql);
		if(Shop_IAPProduct::userIsBuyMonthPackage($userId)){
			$total = 10;
		}else{
			$total = 5;
		}
		 
		$num = count($res);
		return $total-$num;
	}
	
	/*public static function isUseFriend( $userId ){
		$time = date('Y-m-d');
		$begin = strtotime($time.' 00:00:00');
		$end   = strtotime($time.' 23:59:59');
		$sql = "select friend_id,validity_time  from friend_info where friend_id = '$userId' and validity_time >= '$begin' and validity_time <= '$end' ";
		return MySql::query($sql);
	}*/
	
	public static function useFriend( $userId, $friendId ){
		$time = date('Y-m-d H:i:s', strtotime("+1 day"));
		$old_sql = "update friend_info set validity_time = 0 where user_id = '$userId' ";
		MySql::query($old_sql);
		$sql = "update friend_info set validity_time = '$time' where user_id = '$userId' and friend_id = '$friendId'";
		
		return MySql::query($sql);
	}
	
	public static function alreadyChooseFriend($userId){
		$sql = "select friend_id from friend_info where user_id = '$userId' and is_pass = 0";
		$res = MySql::query($sql);
		foreach ($res as $i=>$key){
			$result[$i] = $key['friend_id'];
		}
		return $result;
	}
	
}