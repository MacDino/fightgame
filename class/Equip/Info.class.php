<?php
//获取装备信息
class Equip_Info
{	
	CONST TABLE_NAME = 'user_equid';
	
	//获取用户的装备信息
	public static function getEquipListByUserId($userId, $is_used = FALSE){
        if($userId){
        	if(!$is_used){
            	$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
        	}else{
        		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId, 'is_used' => 1));
        	}
        }else{
            return false;    
        }
		return $res;
	}	

    //根据装备id返回信息
    public static function getEquipInfoById($equipId){
        if($equipId){
            $res = MySql::selectOne(self::TABLE_NAME, array('user_equid_id' => $equipId));
        }else{
            return false;    
        }
        return $res;
    }

}
