<?php
class Pet{
	CONST TABLE_NAME = 'user_pet';
	
	/** @desc 添加人宠 */
	public static function addPet($userId, $petId){
		$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'pet_id' => $petId, 'validity_time' => time() + User::VALIDITY_TIME ));
		return $res;
	}
	
	/** @desc 驱使人宠 */
	public static function usePet($userId, $petId){
		//正在使用的人宠
		$old = self::usedPet($userId);
		if(!empty($old)){
			MySql::update(self::TABLE_NAME, array('is_use' => 0), array('user_id' => $userId, 'pet_id' => $old['pet_id']));
		}
		$res = MySql::update(self::TABLE_NAME, array('is_use' => 1), array('user_id' => $userId, 'pet_id' => $petId));
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
	
	/** @desc 删除过期人宠 */
	private static function atuoDelPet($userId){
		$sql = "DELETE FROM user_pet WHERE `validity_time` < " . time() . " AND user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	
	/** @desc 人宠列表 */
	public static function listPet($userId){
		self::atuoDelPet($userId);
		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
		
		foreach ($res as $i=>$value){
			$result[$i] = User_Info::getUserInfoByUserId($value['pet_id']);
			$result[$i]['is_used'] = $value['is_use'];
			$result[$i]['validity_time'] = $value['validity_time'];
		}
		return $result;
	}
		
	/** @desc 验证是否可以添加*/
	public static function verifyPet($userId){
		self::atuoDelPet($userId);
		$new_num = self::petNum($userId);
		$user_info = User_Info::getUserInfoByUserId($userId);
		$max_num = $user_info['pet_num'];
		if($max_num > $new_num){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	//正在使用的人宠
	public static function usedPet($userId){
		self::atuoDelPet($userId);
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'is_use' => 1));
		return $res;
	}
	
	//是否是人宠
	public static function isPet($userId, $petId){
		self::atuoDelPet($userId);
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'pet_id' => $petId));
		return count($res);
	}
}