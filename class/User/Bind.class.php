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
           $loginUserId = self::_getBindUerInfo($bindType, $bindValue);
           if(!$loginUserId && $createNew)
           {
               $loginUserId = self::_createBindUserInfo($bindType, $bindValue);  
           }
           return $loginUserId;
        }catch (Exception $e){
           return FALSE;
        } 
    }

    private static function _createBindUserInfo($bindType, $bindValue)
    {
        if(!$bindType || !$bindValue)return;
        $loginUserId = MySql::insert(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue), true);
        return $loginUserId;
    }

    private static function _getBindUerInfo($bindType, $bindValue)
    {
        $loginUserInfo = MySql::selectOne(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue));
        if($loginUserInfo)
        {
        	$loginUserId = $loginUserInfo['login_user_id'];
            return $loginUserId;
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
