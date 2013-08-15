<?php
//获取装备信息
class Equip_Info
{	
	CONST TABLE_USER_EQUID = 'user_equid';
	
	//获取用户的装备信息
	public static function getEquipListByUserId($userId){
	        $res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}	

	//返回装备的所有属性
	public static function getEquipAttrSum($user_id){

	}
}
