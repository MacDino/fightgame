<?php
//好友关联信息
class Friend_Info
{
    CONST TABLE_NAME = 'friend_info';
    
    CONST FRIEND_NUM = '10';//好友数量原始上限,可增加

    //好友来源
    //private static $_allChannelType = array('lbs', 'weixin', 'sina', 'game');
    
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
			$friendInfo = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
			
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
     * @return Bool
     */
    public static function createFriendInfo($userId, $friendId)
    {
    	//数据进行校验,非空,数据内
    	if(!$userId || !$friendId) return FALSE;
    	
    	//查询好友ID是否在用户表里存在//是否已经超过某等级 >40
		$user_info = User_Info::getUserInfoByUserId($userId);
		$friend_info = User_Info::getUserInfoByLevel($friendId, '<', 40);
		if(!$user_info || !$friend_info) return FALSE;
		
		//是否已添加过好友
		$is_friend = self::getUserFrined($userId, $friendId);
		if(!empty($is_friend)) return FALSE;
        
        $userId = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'friend_id' => $friendId, 'channel' => $channel), true);
        //echo $userId;exit;
        
        if($userId)
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
}