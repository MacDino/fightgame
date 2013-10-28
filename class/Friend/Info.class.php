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
			$sql = "select u.user_id as user_id, u.race_id as user_race, u.user_name as user_name, u.user_level as user_level, f.friend_id as friend_id, f.is_pass as pass from user_info u, friend_info f where f.user_id = '$userId' AND f.friend_id = u.user_id AND f.is_pass = '1'";
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
			$sql = "select u.user_name as user_name, u.race_id as race_id, u.user_level as user_level, f.friend_id as friend_id, f.is_pass as pass from user_info u, friend_info f where f.user_id = '$userId' AND f.friend_id = u.user_id AND f.is_pass = '0'";
//			echo $sql;exit;
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

		$res = MySql::update(self::TABLE_NAME, array('is_pass' => 1), array('user_id' => $userId, 'friend_id' => $friendId ));//通过状态
		//通过好友申请的同时添加对方为好友,默认通过
		$result = MySql::insert(self::TABLE_NAME, array('user_id' => $friendId, 'friend_id' => $userId, 'is_pass' => 1));//默认通过
		if($res && $result)
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

		$friendInfo = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId));

       	if(!empty($friendInfo)){
            return TRUE;
        }else{
        	return FALSE;
        }
	}

	
}