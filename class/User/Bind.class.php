<?php
//用户绑定信息
class User_Bind
{

    CONST TABLE_NAME = 'user_bind';

    //private static $_allowBindType = array('mac', 'sina', 'weixin');
    private static $_allowBindType = array('mac');

    public static function getBindUserId($bindType, $bindValue, $createNew = FALSE)
    {
        try{
           self::_allowBindType($bindType);
           self::_checkValue($bindType, $bindValue);
           $userId = self::_getBindUerInfo($bindType, $bindValue);
           if(!$userId && $createNew)
           {
               $userId = self::_createBindUserInfo($bindType, $bindValue);  
           }
           return $userId;
        }catch (Exception $e){
           return FALSE;
           //throw new Exception($e->getMessage(), $e->getCode());
        } 
    }

    private static function _createBindUserInfo($bindType, $bindValue)
    {
        if(!$bindType || !$bindValue)return;
        $userId = MySql::insert(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue), true);
        return $userId;
    }

    private static function _getBindUerInfo($bindType, $bindValue)
    {
        $userInfo = MySql::selectOne(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue));
        if($userInfo)
        {
        	$userId = $userInfo['user_id'];
            return $userId;
        }else{
        
        	return FALSE;
        }
    }

    private static function _checkValue($bindType, $bindValue)
    {
        
    
    }

    private static function _allowBindType($bindType)
    { 
        if(!in_array($bindType, self::$_allowBindType))
        {
            throw new Exception('没有适配的绑定类型', 1);
        }
    }



}
