<?php
//用户绑定信息
class User_Bind
{
    CONST TABLE_NAME = 'user_bind';

    private static $_allowBindType = array('mac', 'sina', 'weixin');

    /**
     * 获取账号ID
     *
     * @param 注册方式 $bindType
     * @param 账号 $bindValue
     * @param 密码 $passWord
     * @param 是否新建 $createNew
     * @return BOOL
     */
    public static function getBindUserId($bindType, $bindValue, $passWord, $createNew = FALSE)
    {
        try{
           //self::_allowBindType($bindType);
           self::_checkValue($bindType, $bindValue, $passWord);
           $masterId = self::_getBindUerInfo($bindType, $bindValue, $passWord);
           if(!$masterId)
           {
//               $masterId = self::_createBindUserInfo($bindType, $bindValue);  
				return FALSE; 
           }
           return $masterId;
        }catch (Exception $e){
           return FALSE;
        } 
    }

    /**
     * 创建用户
     *
     * @param 注册方式 $bindType
     * @param 账号 $bindValue
     * @param 密码 $passWord
     * @return BOOL
     */
    public static function createBindUserInfo($bindType, $bindValue, $passWord)
    {
        //echo "$bindType, $bindValue, $passWord";
        if(!$bindType || !$bindValue || !$passWord)return;
        //echo 65666;
        $masterId = MySql::insert(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue, 'password' => $passWord), true);
        return $masterId;
    }
    
    private static function _getBindUerInfo($bindType, $bindValue, $passWord)
    {
        $loginUserInfo = MySql::selectOne(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue, 'password' => $passWord));
        if($loginUserInfo)
        {
        	$masterId = $loginUserInfo['master_id'];
            return $masterId;
        }else{
        	return FALSE;
        }
    }
    
    public static function getBindUerInfo($bindType, $bindValue)
    {
        $loginUserInfo = MySql::selectOne(self::TABLE_NAME, array('bind_type' => $bindType, 'bind_value' => $bindValue));
        if($loginUserInfo)
        {
            return TRUE;
        }else{
        	return FALSE;
        }
    }

    /**
     * 检验
     * @param 注册方式 $bindType
     * @param 账号 $bindValue
     * @param 密码 $passWord
     */
    private static function _checkValue($bindType, $bindValue, $passWord)
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
