<?php
//用户绑定信息
class User_Bind
{
    CONST TABLE_NAME = 'user_bind';

    private static $_allowBindType = array('mac', 'sina', 'weixin');

    public static function getBindUserId($bindType, $bindValue, $createNew = FALSE)
    {
        try{
           self::_allowBindType($bindType);
           self::_checkValue($bindType, $bindValue);
           $masterId = self::_getBindUerInfo($bindType, $bindValue);
           if(!$masterId && $createNew)
           {
               $masterId = self::_createBindUserInfo($bindType, $bindValue);  
           }
           return $masterId;
        }catch (Exception $e){
           return FALSE;
        } 
    }

    private static function _createBindUserInfo($bindType, $bindValue)
    {
        if(!$bindType || !$bindValue)return;
        $masterId = MySql::insert(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue), true);
        return $masterId;
    }
    
    //自己创建用户
    public static function createAccount($account, $passWord){
    	if(!$account || !$passWord)return;
    	$masterId = MySql::insert(self::TABLE_NAME, array('bind_type' => 'self', 'bind_value' => $bindValue, 'password' => $passWord), true);
    	return $masterId;
    }

    private static function _getBindUerInfo($bindType, $bindValue)
    {
        $loginUserInfo = MySql::selectOne(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue));
        if($loginUserInfo)
        {
        	$masterId = $loginUserInfo['matser_id'];
            return $masterId;
        }else{
        	return FALSE;
        }
    }

    private static function _checkValue($bindType, $bindValue)
    {
        //todo 检查数据    
    }

    private static function _allowBindType($bindType)
    { 
        if(!in_array($bindType, self::$_allowBindType))
        {
            throw new Exception('没有适配的绑定类型', 1);
        }
    }
}
