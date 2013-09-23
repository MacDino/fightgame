<?php
class Pet{
	CONST TABLE_NAME = 'friend_info';
	
	/** @desc 添加人宠 */
	public static function addPet($userId, $petId){
		$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'pet_id' => $petId, 'validity_time' => time() + User::VALIDITY_TIME ));
		return $res;
	}
	
	/** @desc 驱使人宠 */
	public static function usePet($userId, $petId){
		$res = MySql::update(self::TABLE_NAME, array('is_use' => 2), array('user_id' => $userId, 'pet_id' => $petId));
		return $res;
	}
	
	/** @desc 释放人宠 */
	public static function delPet($userId, $petId){
		$res = MySql::delete(self::TABLE_NAME, array('user_id' => $userId, 'pet_id' => $petId));
		return $res;
	}
	
	/** @desc 人宠数量 */
	public static function petNum($userId){
		$res = MySql::selectCount(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}
	
	/** @desc 人宠列表 */
	public static function listPet($userId){
		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}
	
	/** @desc 人宠自动释放 */
	public static function petAutoPet(){
		
	}
	
	/** @desc 验证是否可以添加*/
	public static function verifyPet($userId){
		$new_num = self::petNum($userId);
		$user_info = User_Info::getUserInfoByUserId($userId);
		$max_num = $user_info['pet_num'];
		if($max_num > $new_num){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}