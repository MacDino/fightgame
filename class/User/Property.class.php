<?php
class User_Property{
	
	/**
	 * 购买背包上限
	 * @param int $userId
	 * @return bool
	 */
	public static function buyPackNum($userId)
	{
		if(!$userId)return FALSE;
		
		//验证是否已到最大购买数
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if($userInfo['pack_num'] >= User::DEFAULT_PACK_MAX)return FALSE;
		
		//验证是否有足够元宝购买
		if($userInfo['ingot'] < User::PACK_PRICE)return FALSE;
		
		$res_num = User_Info::updateSingleInfo($userId, 'pack_num', 5, '+');//增加包裹数
		$res_ingot = User_Info::updateSingleInfo($userId, 'ingot', User::PACK_PRICE, '-');//减少相应元宝 
		
		if($res_ingot && $res_num)return TRUE;
	}
	
	/**
	 * 购买好友上限
	 * @param int $userId
	 * @return bool
	 */
	public static function buyFriendNum($userId)
	{
		if(!$userId)return FALSE;
		
		//验证是否已到最大购买数
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if($userInfo['friend_num'] >= User::DEFAULT_FRIEND_MAX)return FALSE;
		
		//验证是否有足够元宝购买
		if($userInfo['ingot'] < User::FRIEND_PRICE)return FALSE;
		
		$res_num = User_Info::updateSingleInfo($userId, 'friend_num', 1, '+');//增加包裹数
		$res_ingot = User_Info::updateSingleInfo($userId, 'ingot', User::FRIEND_PRICE, '-');//减少相应元宝 
		
		if($res_ingot && $res_num)return TRUE;
	}
	
	/**
	 * 购买人宠上限
	 * @param int $userId
	 * @return bool
	 */
	public static function buyPetNum($userId)
	{
		if(!$userId)return FALSE;
		
		//验证是否已到最大购买数
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if($userInfo['pet_num'] >= User::DEFAULT_PET_MAX)return FALSE;
		
		//验证是否有足够元宝购买
		if($userInfo['ingot'] < User::PET_PRICE)return FALSE;
		
		$res_num = User_Info::updateSingleInfo($userId, 'pet_num', 1, '+');//增加包裹数
		$res_ingot = User_Info::updateSingleInfo($userId, 'ingot', User::PET_PRICE, '-');//减少相应元宝 
		
		if($res_ingot && $res_num)return TRUE;
	}
	
	/**
	 * 购买PK次数
	 * @param int	$userId		用户ID
	 * @param int	$num		购买次数,默认为1
	 */
	public static function buyPkNum($userId, $num = FALSE)
	{
		if(!$userId)return FALSE;
		
		$num = isset($num)?$num:"1";
		
		//根据流水表检测已经购买次数
		$alreadyBuyNum = 2;
		if($alreadyBuyNum >= User::PK_BUY_NUM)return FALSE;
		
		$res_num = User_Info::updateSingleInfo($userId, 'pk_num', $num, '+');
		$res_ingot = User_Info::updateSingleInfo($userid, 'ingot', User::PET_PRICE * $num, '-');
		
		if($res_num && $res_ingot)return TRUE;
	}
		
	/** 购买属性增强咒符*/
	public static function buyAttributeEnhance($userId)
	{
		if(!$userId)return FALSE;
		
		//是否已经在用
		$isuse = self::isuseAttributeEnhance($userId);
		if(!empty($isuse))return FALSE;
		
		$res = MySql::insert('attribute_enhance', array('user_id' => $userId, 'add_time' => time()));
		return $res;
	}
	/** 检测是否在使用属性增强符咒*/
	public static function isuseAttributeEnhance($userId)
	{
		if(!$userId)return FALSE;
		
		$res = MySql::selectOne('attribute_enhance', array('user_id' => $userId));
		
		if(!$res){//没有记录
			return FALSE;
		}elseif( (time() - User::ATTEIBUTEENHANCETIME) > $res['add_time'] ){//过期记录
			MySql::delete('attribute_enhance', array('user_id' => $userId));//删除记录
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/** 购买双倍符咒*/
	public static function buyDoubleHarvest($userId)
	{
		if(!$userId)return FALSE;
		
		//是否已经在用
		$isuse = self::isuseDoubleHarvest($userId);
		if(!empty($isuse))return FALSE;
		
		$res = MySql::insert('double_harvest', array('user_id' => $userId, 'add_time' => time()));
		return $res;
	}
	/** 检测是否在使用双倍符咒*/
	public static function isuseDoubleHarvest($userId)
	{
		if(!$userId)return FALSE;
		
		$res = MySql::selectOne('double_harvest', array('user_id' => $userId));
		
		if(!$res){//没有记录
			return FALSE;
		}elseif( (time() - User::DOUBLEHARVESTTIME) > $res['add_time'] ){//过期记录
			MySql::delete('double_harvest', array('user_id' => $userId));//删除记录
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/** 购买挂机符咒*/
	public static function buyAutoFight($userId)
	{
		if(!$userId)return FALSE;
		
		//是否已经在用
		$isuse = self::isuseAutoFight($userId);
		if(!empty($isuse))return FALSE;
		
		$res = MySql::insert('auto_fight', array('user_id' => $userId, 'add_time' => time()));
		return $res;
	}
	/** 检测是否在使用挂机符咒,若过期自动删除*/
	public static function isuseAutoFight($userId)
	{
		if(!$userId)return FALSE;
		
		$res = MySql::selectOne('auto_fight', array('user_id' => $userId));
		
		if(!$res){//没有记录
			return FALSE;
		}elseif( (time() - User::AUTOFIGHTTIME) > $res['add_time'] ){//过期记录
			MySql::delete('auto_fight', array('user_id' => $userId));//删除记录
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * 装备成长咒符
	 */
		
	/**
	 * 上古遗迹(宝箱)
	 */
}