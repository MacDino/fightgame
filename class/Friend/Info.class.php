<?php
//好友关联信息
class Friend_Info
{
    CONST TABLE_NAME = 'friend_info';

    //好友来源
    
    /**
     * 查找好友信息
     * @param int $userId		用户ID
     * @return array
     */
    public static function getFriendInfo($userId)
    {
        try{
        	//数据进行校验,非空,数据内
			if(!$userId)	return FALSE;
			//查询好友信息
			$sql = "select u.user_name as user_name, u.user_level as user_level, f.friend_id as friend_id, f.is_pass as pass from user_info u, friend_info f where f.user_id = '$userId' AND f.friend_id = u.user_id AND f.is_pass = '2'";
//			echo $sql;exit;
			$friendInfo = MySql::query($sql);
			
			
           	if(is_array($friendInfo))
	        {
	            return $friendInfo;
	        }else{
	        	return FALSE;
	        }
        }catch (Exception $e){
           return FALSE;
        } 
    }
    
    /**
     * 显示申请好友信息
     * @param int $userId		用户ID
     * @return array
     */
    public static function getApplyFriendInfo($userId)
    {
        try{
        	//数据进行校验,非空,数据内
			if(!$userId)	return FALSE;
			//查询好友信息
			$sql = "select u.user_name as user_name, u.race_id as race_id, u.user_level as user_level, f.friend_id as friend_id, f.is_pass as pass from user_info u, friend_info f where f.user_id = '$userId' AND f.friend_id = u.user_id AND f.is_pass = '1'";
//			echo $sql;exit;
			$friendInfo = MySql::query($sql);
			
			
           	if(is_array($friendInfo))
	        {
	            return $friendInfo;
	        }else{
	        	return FALSE;
	        }
        }catch (Exception $e){
           return FALSE;
        } 
    }
    /**
     * 查询已有好友数量
     *
     * @param int $userId	用户ID
     * @return int
     */
    public static function getFriendNum($userId){
    	try{
        	//数据进行校验,非空,数据内
			if(!$userId)	return FALSE;
			
			//查询好友数量
			$friendInfo = Mysql::selectCount(self::TABLE_NAME, array('user_id' => $userId));
			
            return $friendInfo;
        }catch (Exception $e){
           return FALSE;
        } 
    }

    /**
     * 添加好友
     *
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
    	
    	//查询好友ID是否在用户表里存在//是否已经超过某等级 >40
		$user_info = User_Info::getUserInfoByUserId($userId);
		$friend_info = User_Info::getUserInfoByUserId($friendId);
		if(!$user_info || !$friend_info) return FALSE;
		
		//是否已添加过好友
		$is_friend = self::getUserFrined($userId, $friendId);
		if(!empty($is_friend)) return FALSE;
        
        $userId = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId), true);//默认未通过
        //echo $userId;exit;
        
        if($userId)
        {
            return TRUE;
        }else{
        	return FALSE;
        }
    }
    
    /**
     * 通过好友申请
     *
     * @param int $userId		用户ID
     * @param int $friendId		好友ID
     */
    public static function agreeFriendInfo($userId, $friendId)
    {
    	//数据进行校验,非空,数据内
    	if(!$userId || !$friendId) return FALSE;
    	
    	//查询用户ID和好友ID是否在用户表里存在
		$user_info = User_Info::getUserInfoByUserId($userId);
		$friend_info = User_Info::getUserInfoByUserId($friendId);
		if(!$user_info || !$friend_info) return FALSE;
		
		$res = MySql::update(self::TABLE_NAME, array('is_pass' => 2), array('user_id' => $userId, 'friend_id' => $friendId));//通过状态
		//通过好友申请的同时添加对方为好友,默认通过
		$result = MySql::insert(self::TABLE_NAME, array('user_id' => $friendId, 'friend_id' => $userId, 'is_pass' => 2), true);//默认通过
		if($res & $result)
        {
        	//同时增加user_id声望
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
    	$is_friend = self::getUserFrined($userId, $friendId);
    	if(empty($is_friend)) return FALSE;
    	
        $userId = MySql::delete(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId));
        
        if($userId)
        {
        	//同时减少user_id声望
            return TRUE;
        }else{
        	return FALSE;
        }
    }

    /**
     * 检测是否已经添加过这个好友
     *
     * @param int $userId		用户ID
     * @param int $friendId		好友ID
     * @return Bool 
     */
	public static function getUserFrined($userId, $friendId)
	{
		//简单检测
		if(!$userId || !$friendId)	return FALSE;
		
		$friendInfo = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId));
		
       	if($friendInfo)
       	{
            return TRUE;
        }else{
        	return FALSE;
        }
	}
	
	/**
	 * 根据自身经纬度获取附近用户
	 *
	 * @param int $userId
	 * @param int $lng
	 * @param int $lat
	 */
	public static function getNearbyFriend($userId, $lng, $lat)
	{
		//简单检测
		if(!$userId || !$lng || !$lat)	return FALSE;
		
		$_array = LBS::delta_lng_lat($lon, $lat);  

		$min_lng = $_array[0];
		$max_lng = $_array[1];
		$min_lat = $_array[2];
		$max_lat = $_array[3];
		
		$sql = "SELECT i.user_name as user_name, i.race_id as race_id, i.user_level as user_level FROM user_info i ,user_lbs l 
				WHERE longitude<=$max_lng AND longitude>=$min_lng AND latitude<=$max_lat AND latitude>=$min_lat 
				AND i.user_id!=$userId and i.user_id = l.user_id";
		$res = MySql::query($sql);
		if(is_array($res)){
			return $res;
		}
	}
}