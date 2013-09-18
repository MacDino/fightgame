<?php
class User_Property{
	
	CONST TABLE_NAME = 'user_props';
	
	/** 双倍咒符 */
	CONST DOUBLE_HARVEST = 1;
	CONST DOUBLE_HARVEST_PRICE = 20;

	/** 属性增强咒符*/
	CONST ATTRIBUTE_ENHANCE = 3;
	CONST ATTRIBUTE_ENHANCE_PRICE = 20;
	/** 挂机咒符 */
	CONST AUTO_FIGHT = 6;
	CONST AUTO_FIGHT_PRICE = 50;
	/** 锻造成功咒符 */
	CONST EQUIP_FORGE = 8;
	CONST EQUIP_FORGE_PRICE = 100;
	/** 装备成长咒符 */
	CONST EQUIP_GROW = 9;


	CONST BOX_GENERAL = 1;	//普通宝箱
	CONST BOX_CHOICE  = 2;	//精品宝箱
	
	
	/**
	 * 购买符咒   适用于属性增强、双倍、挂机、装备打造等静态价格的咒符
	 * 动态价格咒符和pk咒符、背包上限需要各自调用自己的接口
	 */
	public static function buyUserProps($userId, $propsId, $num){
		if(!$userId || !$type)return FALSE;
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if(!$num || $num < 0 || !is_numeric($num)){
			throw new Exception('购买数量不正确', 1);
		}
		$propsInfo = Props_Info::getPropsInfo($propsId);
		$priceType = $propsInfo['price_type'];
		if( $priceType == Props_Config::PRICE_TYPE_DYNAMIC){
			throw new Exception('此接口只能购买固定价格的道具',1);	
		}
		if($userInfo['ingot'] < $price) {
			throw new Exception('您的元宝数不足,无法购买',1);	
		}
		/*
		 * 扣除元宝
		 */
		$res = self::addAmulet($userId, $propsId, $num);
		if($res){
			$decreingot = User_Info::updateSingleInfo($userId, 'ingot', $price, '-');
			return $decreingot;
		} 
		return false;
	}

	/*
	 * 购买装备成长符
	 */
	public static function buyEquipGrow($userId, $equipId, $num){
		if(!$userId || !$type)return FALSE;
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if(!$num || $num < 0 || !is_numeric($num)){
			throw new Exception('购买数量不正确', 1);
		}
		/*
		 * 获取装备level
		 */
		$equipInfo = Equip_info::getEquipInfoById($equipId);
		$equipLev  = $equipInfo['equip_level'];
		$price = self::getEquipGrowPrice($equipLev);
		if($userInfo['ingot'] < $price) {
			throw new Exception('您的元宝数不足,无法购买',1);	
		}
		/*
		 * 扣除元宝
		 */
		$res = self::addAmulet($userId, self::EQUIP_GROW, $num);
		if($res){
			$decreingot = User_Info::updateSingleInfo($userId, 'ingot', $price, '-');
			return $decreingot;
		} 
		return false;
	}

	/*
	 * 获取装备成长的价格
	 */
	public static function getEquipGrowPrice($equipLevel){
		if($equipLevel < 30){
			throw new Exception ('当前装备等级不够30级,不能购买装备成长符', 1);	
		}
		$price_table = Props_Config::$equip_grow_price;
		if(array_key_exists($equipLevel, $price_table)){
			return $price_table[$equipLevel];	
		}else {
			throw new Exception ('当前的装备等级不在装备成长价格表的范围内', 1);
		}
	}

	/*
	 * 增加为用户增加道具
	 */
	public static function addAmulet($userId, $type, $num)
	{
		if(!$userId || !$type)return FALSE;
		
		//是否有足够元宝
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if($userInfo['ingot'] < self::$type.'_PRICE')return FALSE;
		
		$sql = "UPDATE " . self::TABLE_NAME . " SET `property_num` =  `property_num` + " . $num . " WHERE user_id = $userId AND property_id = $type";
		$res = MySql::query($sql);
	}
	
	/**
	 * @param int $userId	用户ID
	 * @param int $type		符咒类别
	 * @return 使用符咒
	 */
	private static function UseAmulet($userId, $type)
	{
		if(!$userId || !$type)return FALSE;
		
		$num = self::getPropertyNum($userId, $type);
		if($num <= 0)return FALSE;
		
		$sql = "UPDATE " . self::TABLE_NAME . " SET `property_num` =  `property_num` - 1 WHERE user_id = $userId AND property_id = $type";
//		echo $sql;exit;
		$res = MySql::query($sql);
	}
	
	/**
	 * @param int $userId	用户ID
	 * @param int $type		符咒类别
	 * @return 获取某符咒数量
	 */
	public static function getPropertyNum($userId, $type)
	{
		if(!$userId || !$type)return FALSE;
		
		$num = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'property_id' => $type), array('property_num'));
		return $num['property_num'];
	}

	/*
	 * 获取某个道具详情
	 */
	public static function getPropertyInfo($userId, $type)
	{
		if(!$userId || !$type)return FALSE;
		
		$propert = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'property_id' => $type));
		return $propert;
	}
	
	/*
	 *  创建用户时做初始化道具
	 */
	public static function createPropertylist($userId, $type, $num = 0){
		if(!$userId || !$type)return FALSE;
		
		$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'property_id' => $type, 'property_num' => $num,'last_time' => time()));
		return $res;
	}

	/*
	 * 初始化宝箱类道具
	 */
	public static function initTreasureBox($userId){
		$treasureBoxIds = Props_Info::getTreasureBoxPropsId();
		empty($treasureBoxIds) && $treasureBoxIds = array(); 
		foreach ($treasureBoxIds as $v){
			self::createPropertylist($userId, $v['props_id']);	
		}
		return;
	}
	
	/**
	 * 显示拥有符咒信息
	 *
	 * @param int $userId	用户ID
	 * @return 显示拥有符咒信息
	 */
	public static function getUserProperty($userId)
	{
		if(!$userId)return FALSE;
		
		$propertyInfo = MySql::select(self::TABLE_NAME, array('user_id' => $userId), array('property_id', 'property_num'));
		
		if(!is_array($propertyInfo))return FALSE;
		
		return $propertyInfo;
	}
	
	/**
	 * 购买背包上限
	 * @param int $userId
	 * @return 购买背包上限
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
	 * @return 购买好友上限
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
	 * @return 购买人宠上限
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
	 * @return 购买PK次数
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
		
	/** 
	 * @return 使用属性增强咒符*/
	public static function useAttributeEnhance($userId)
	{
		if(!$userId)return FALSE;
		
		//是否已经在用
		$isUse = self::isuseAttributeEnhance($userId);
		if(!empty($isUse))return FALSE;
		
		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::ATTRIBUTE_ENHANCE);
		if(empty($isHave))return FALSE;
		
		$res = MySql::insert('attribute_enhance', array('user_id' => $userId, 'add_time' => time()));
		$res_num = self::UseAmulet($userId, self::ATTRIBUTE_ENHANCE);
		
		if(!$res && !$res_num)return FALSE;
		return $res;
	}
	/** 检测是否在使用属性增强符咒
	 * @return 检测是否在使用属性增强符咒*/
	public static function isuseAttributeEnhance($userId)
	{
		if(!$userId)return FALSE;
		
		$res = MySql::selectOne('attribute_enhance', array('user_id' => $userId));
		
		if(!$res){//没有记录
			return FALSE;
		}elseif( (time() - User::ATTEIBUTEENHANCETIME) > $res['add_time'] ){//删除过期记录
			MySql::delete('attribute_enhance', array('user_id' => $userId));
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/** 
	 * @return 使用双倍符咒*/
	public static function useDoubleHarvest($userId)
	{
		if(!$userId)return FALSE;
		
		//是否已经在用
		$isUse = self::isuseDoubleHarvest($userId);
		if(!empty($isUse))return FALSE;
		
		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::DOUBLE_HARVEST);
		if(empty($isHave))return FALSE;
		
		$res = MySql::insert('double_harvest', array('user_id' => $userId, 'add_time' => time()));
		$res_num = self::UseAmulet($userId, self::DOUBLE_HARVEST);
		return $res;
	}
	/** 检测是否在使用挂机符咒
	 * @return 检测是否在使用双倍符咒*/
	public static function isuseDoubleHarvest($userId)
	{
		if(!$userId){
			throw new Exception('缺少用户id', 1);
		}
		
		$res = MySql::selectOne('double_harvest', array('user_id' => $userId));
		
		if(!$res){//没有记录
			return FALSE;
		}elseif( (time() - User::DOUBLEHARVESTTIME) > $res['add_time'] ){//删除过期记录
			MySql::delete('double_harvest', array('user_id' => $userId));
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/** 
	 * @return 使用挂机符咒*/
	public static function useAutoFight($userId)
	{
		if(!$userId){
			throw new Exception('缺少用户id', 1);
		}

		//是否已经在用
		$isUse = self::isuseAutoFight($userId);
		if(!empty($isUse)){
			throw new Exception ('此道具已在使用', 1);	
		}

		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::AUTO_FIGHT);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 1);	
		}

		$res = MySql::insert('auto_fight', array('user_id' => $userId, 'add_time' => time()));
		$res_num = self::UseAmulet($userId, self::AUTO_FIGHT);
		return $res;
	}
	/** 检测是否在使用挂机符咒
	 * @return 检测是否在使用挂机符咒*/
	public static function isuseAutoFight($userId)
	{
		if(!$userId){
			throw new Exception('缺少用户id', 1);
		}
		
		$res = MySql::selectOne('auto_fight', array('user_id' => $userId));
		
		if(!$res){//没有记录
			return FALSE;
		}elseif( (time() - User::AUTOFIGHTTIME) > $res['add_time'] ){//删除过期记录
			MySql::delete('auto_fight', array('user_id' => $userId));
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * 使用锻造成功咒符
	 */
	public static function useEquipForge($userId)
	{
		if(!$userId){
			throw new Exception('缺少用户id', 1);
		}
		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::EQUIP_FORGE);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 1);	
		}
		$res_num = self::UseAmulet($userId, self::Equip);
		return $res;
	}
	
	
	/**
	 * 装备成长咒符
	 */
	public static function useEquipGrow($userId, $equipId)
	{
		if(!$userId){
			throw new Exception('缺少用户id', 1);
		}
		if(!$equipId){
			throw new Exception('缺少装备id', 1);
		}
		$equipInfo = Equip_info::getEquipInfoById($equipId);
		$equipLev  = $equipInfo['equip_level'];
		if($equipLev < 30){
			throw new Exception ('当前装备等级不够30级,不能购买装备成长符', 1);	
		}
		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::EQUIP_GROW);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 1);	
		}
		$res_num = self::UseAmulet($userId, self::Equip);
		return $res;
	}
		
	/**
	 * 使用普通类宝箱
	 */
	public static function useGeneralTreasureBox($userId, $propsId){
		if(!$userId){
			throw new Exception('缺少用户id', 1);
		}
		if(!$propsId){
			throw new Exception('缺少道具id', 1);
		}
		//是否还有存数
		$isHave = self::getPropertyNum($userId, $propsId);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 1);	
		}
		$res_num = self::UseAmulet($userId, $propsId);
		/*
		 * 处理抽取获得
		 */
		if($res_num){
			return self::extractEquip( $userId, $propsId, self::BOX_GENERAL) ? TRUE : FALSE;	
		}
		return FALSE;
	}

	/*
	 * 使用精品类宝箱
	 */
	public static function useChoiceTreasureBox($userId, $propsId){
		if(!$userId){
			throw new Exception('缺少用户id', 1);
		}
		if(!$equipId){
			throw new Exception('缺少装备id', 1);
		}
		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::EQUIP_GROW);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 1);	
		}
		$res_num = self::UseAmulet($userId, $propsId);
		/*
		 * 处理抽取获得
		 */
		if($res_num){
			return self::extractEquip($userId, $propsId, self::BOX_CHOICE) ? TRUE : FALSE;	
		}
		return FALSE;	
	}
	/*
	 * 抽取获得，供使用宝箱类接口调用
	 */
	private function extractEquip($userId, $propsId, $type){
		//普通
		if( $type == self::BOX_GENERAL){
			$pack = Props_Config::$treasure_box_package[0];
			$color = self::randEquipColor();	
			foreach ( $pack as $v ) {
				if($propsId == $v['id']){
					$level = $v['level'];	
				}			
			}
			$res = Equip_Create::createEquip($color, $userId, $level);
		} else if($type == self::BOX_CHOICE){
		//精品
			$pack = Props_Config::$treasure_box_package[1];
			foreach ( $pack as $v ) {
				if($propsId == $v['id']){
					$level = $v['level'];	
				}			
			}
			for( $i = 0; $i < 10; $i++ ){
				/*
				 * 至少四件橙色装备
				 */
				if( $i < 4) {
					$color = Equip::EQUIP_COLOUR_ORANGE;
				} else {
					$color = self::randEquipColor();	
				}
				$res = Equip_Create::createEquip($color, $userId, $level);
			}
		}	
		return $res;
	}
	/*
	 * 随机普通宝箱装备颜色
	 */
	public function randEquipColor(){
		$colors = array	(
			Equip::EQUIP_COLOUR_BLUE,
			Equip::EQUIP_COLOUR_PURPLE,
			Equip::EQUIP_COLOUR_ORANGE,
		);
		return $colors[mt_rand(0,2)];
	}

}
