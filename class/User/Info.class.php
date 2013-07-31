<?php

class User_Info
{

    CONST TABLE_NAME = 'user_info';

    //根据用户I获取用户USERID
    public static function getUserInfoByUserId($userId)
    {
        $res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        return $res;
    }

    public static function createUserInfo($userId, $data)
    {
        if(!$userId || !$data || !is_array($data))return FALSE;
        $info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        if($info)return FALSE;
        if(!isset($data['user_name']) || !isset($data['role_id']))return FALSE;
        $res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'user_name' => $data['user_name'], 'role_id' => $data['role_id'], 'user_level' => 0, 'experience' => 0, 'money' => 0, 'ingot' => 0, 'pack_num' => 40));
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
