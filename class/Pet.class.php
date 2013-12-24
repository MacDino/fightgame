<?php
class Pet{
	CONST TABLE_NAME = 'user_pet';
	
	/** @desc 添加人宠 */
	public static function addPet($userId, $petId){
		$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'pet_id' => $petId, 'validity_time' => date('Y-m-d H:i:s', strtotime("+1 day")) ));
		return $res;
	}
	
	/** @desc 驱使人宠 */
	public static function usePet($userId, $petId){
		//正在使用的人宠
		$old = self::usedPet($userId);
		if(!empty($old)){
			MySql::update(self::TABLE_NAME, array('is_use' => 0), array('user_id' => $userId, 'pet_id' => $old['user_id']));
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
	private static function atuoDelPet(){
		$sql = "DELETE FROM user_pet WHERE `validity_time` < '" . date('Y-m-d H:i:s') . "'";
		$res = MySql::query($sql);
		return $res;
	}
	
	/** @desc 人宠列表 */
	public static function listPet($userId){
		self::atuoDelPet();
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
		self::atuoDelPet();
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
		self::atuoDelPet();
		$pet = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'is_use' => 1));
//		print_r($pet);
		$res = MySql::selectOne('user_info', array('user_id' => $pet['pet_id']));
		return $res;
	}
	
	//是否是人宠
	public static function isPet($userId, $petId){
		self::atuoDelPet();
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'pet_id' => $petId));
		if(!empty($res)){
			return 1;
		}else{
			return 0;
		}
	}
	
	public static function getMaster($userId){
		
		$sql = "select user_id from user_pet where pet_id = '$userId' and validity_time > '" . date('Y-m-d H:i:s') ."'";
		$res = MySql::query($sql);
		
		if(!empty($res)){
			foreach ($res as $k=>$v){
				$res[$k] = User_Info::getUserInfoByUserId($v['user_id']);
		    	$lbs = User_LBS::getLBSByUserId($v['user_id']);
		    	$res[$k]['longitude'] = $lbs['longitude'];
		    	$res[$k]['latitude'] = $lbs['latitude'];
			}
			
			$result = User_LBS::getNearUser($res, $userId);
			$total = ceil ( count($result) / 20 );
			if($page > $total){
				$page = $total;
			}
			$offset = ($page-1) * 20;
		    $result = array_slice($result, $offset, 20);
		    
			return $result;
    	}else{
    		return false;
    	}
	}
}