<?php

class User_Info
{

    CONST TABLE_NAME = 'user_info';

    //根据用户I获取用户USERID
    public static function getUserInfoByUserId($userId)
    {
        $res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        print_r($res);exit;
        return $res;
    }
    
	//查找要添加的好友是否超过40级			@郑毅枫 2013/8/6		
	public static function getUserInfoByLevel($friend_id, $compare, $level)
	{
		if(!int($friend_id) || !int($level))return FALSE;
		$res = Mysql::selectOne(self::TABLE_NAME, array('user_id' => $friend_id, 'user_level' => array('opt' => $compare, 'val' => $level)));
		return $res;
	}

    public static function createUserInfo($userId, $data)
    {
        if(!$userId || !$data || !is_array($data))return FALSE;
        $info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        if($info)return FALSE;
        if(!isset($data['user_name']) || !isset($data['role_id']))return FALSE;
        $data = array('user_id' => $userId, 
                      'user_name' => $data['user_name'], 
                      'race_id' => $data['race_id'], 
                      'user_level' => User::DEFAULT_USER_LEVEL, 
                      'experience' => 0, 
                      'money' => User::DEFAULT_MONEY, 
                      'ingot' => User::DEFAULT_INGOT, 
                      'pack_num' => User::DEFAULT_PACK_NUM);
        $res = MySql::insert(self::TABLE_NAME, $data);
        return $res;
    }
    public static function updateUserInfo($userId, $data)
    {
        if(!$userId || !$data || !is_array($data))return FALSE;
        $info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        if($info)return FALSE;
        $updateArray = array();
        isset($data['user_level'])?$updateArray['user_level'] = (int)$data['user_level']:'';
        isset($data['experience'])?$updateArray['experience'] = (int)$data['experience']:'';
        isset($data['money'])?$updateArray['money'] = (int)$data['money']:'';
        isset($data['ingot'])?$updateArray['ingot'] = (int)$data['ingot']:'';
        $res = MySql::update(self::TABLE_NAME, $updateArray, array('user_id' => $userId));
        return $res;
    }
}
