<?php
class User_Property{
	
	CONST TABLE_NAME = 'user_props';

	/** 双倍咒符 */
	CONST DOUBLE_HARVEST = 1;
	CONST DOUBLE_HARVEST_PRICE = 20;

	/** pk咒符 */
	CONST PK = 2;

	/** 属性增强咒符*/
	CONST ATTRIBUTE_ENHANCE = 3;
	CONST ATTRIBUTE_ENHANCE_PRICE = 20;

	/** 人宠增强咒符 */
	CONST PET = 4;

	/** 背包咒符 */
	CONST PACKAGE = 5;

	/** 挂机咒符 */
	CONST AUTO_FIGHT = 6;
	CONST AUTO_FIGHT_PRICE = 50;

	/** 好友上限咒符 */
	CONST FRIEND = 7;

	/** 锻造成功咒符 */
	CONST EQUIP_FORGE = 8;
	CONST EQUIP_FORGE_PRICE = 100;
	/** 装备成长咒符 */
	CONST EQUIP_GROW = 9;


	CONST BOX_GENERAL = 1;	//普通宝箱
	CONST BOX_CHOICE  = 2;	//精品宝箱
	
	
	/**
	 * 购买符咒
	 */
	public static function buyUserProps($userId, $propsId, $num){
		if(!$userId || !$propsId)return FALSE;
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if(!$num || $num < 0 || !is_numeric($num)){
			throw new Exception('购买数量不正确', 120050);
		}
		$propsInfo = Props_Info::getPropsInfo($propsId);
		if(!$propsInfo){
			throw new Exception('此道具信息找不到', 120051);
		}
		$priceType = $propsInfo['price_type'];
		$price = $propsInfo['price'];
		if( $priceType == Props_Info::PRICE_TYPE_DYNAMIC){
			throw new Exception('此接口只能购买固定价格的道具',120052);	
		}
		if($userInfo['ingot'] < $price) {
			throw new Exception('您的元宝数不足,无法购买',120053);	
		}
		$res = self::buyAction($userId, $propsId, $num);
		/*
		 * 扣除元宝
		 */
		if($res){
			$decreingot = User_Info::updateSingleInfo($userId, 'ingot', $price, '2');
		} 
		if($res && $decreingot) {
			$logWhere = array(
				'props_id' => $propsId,		
				'user_id'  => $userId,
				'num'	   => $num,
				'type'	   => Props_Log::ACTION_TYPE_BUY, 
			);
			Props_Log::insert($logWhere);
		}
		/*
		 * 宝箱类为即买即用
		 */
		if(Props_Config::isBoxProps($propsId) == Props_Config::KEY_GENERAL_BOX){
			return self::useGeneralTreasureBox($userId, $propsId);
		} elseif (Props_Config::isBoxProps($propsId) == Props_Config::KEY_CHOICE_BOX){
			return self::useChoiceTreasureBox($userId, $propsId);	
		} else {
			return TRUE;	
		}
		return FALSE;
	}

	/*
	 * 购买装备成长符
	 */
	public static function buyEquipGrow($userId, $equipId, $num){
		if(!$userId || !$equipId)return FALSE;
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if(!$num || $num < 0 || !is_numeric($num)){
			throw new Exception('购买数量不正确', 120050);
		}
		/*
		 * 获取装备level
		 */
		$equipInfo = Equip_info::getEquipInfoById($equipId);
		$equipLev  = $equipInfo['equip_level'];
		$price = self::getEquipGrowPrice($equipLev);
		if($userInfo['ingot'] < $price) {
			throw new Exception('您的元宝数不足,无法购买',120053);	
		}
		/*
		 * 扣除元宝
		 */
		$res = self::buyAction($userId, self::EQUIP_GROW, $num);
		if($res){
			$decreingot = User_Info::updateSingleInfo($userId, 'ingot', $price, '-');
			$logWhere = array(
				'props_id' => $propsId,		
				'user_id'  => $userId,
				'num'	   => $num,
				'type'	   => Props_Log::ACTION_TYPE_BUY, 
			);
			Props_Log::insert($data);
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
	public static function create($userId, $propsId, $num)
	{
		if(!$userId || !$propsId)	return FALSE;
		$sets = array (
			'user_id'		=> $userId,
			'property_id'	=> $propsId,
			'property_num'  => $num,
		);
		return MySql::insert(self::TABLE_NAME, $sets);
	}
	
	/*
	 * 更新用户道具数量  增加
	 */
	public static function updateNumIncreaseAction($userId, $propsId, $num)
	{
		if(!$userId || !$propsId)	return FALSE;
		$sql = "UPDATE " . self::TABLE_NAME . " SET `property_num` =  `property_num` + " . $num . " WHERE user_id = $userId AND property_id = $propsId";
		return MySql::execute($sql);
	}
	/*
	 * 更新用户道具数量  减少
	 */
	public static function updateNumDecreaseAction($userId, $propsId)
	{
		if(!$userId || !$propsId)	return FALSE;
		$num = self::getPropertyNum($userId, $propsId);
		if($num <= 0)return FALSE;

		$userProps = self::getUserPropsInfoByUnionKey($userId, $propsId);
		if (!$userProps) {
			throw new Exception ('未找到您当前的道具记录', 120054);
		}
		$sql = "UPDATE " . self::TABLE_NAME . " SET `property_num` =  `property_num` - 1 WHERE user_id = $userId AND property_id = $propsId";
		return MySql::execute($sql);
	}

	/*
	 * 购买数据库操作 
	 */
	public static function buyAction($userId, $propsId, $num) {
		$userProp = self::getUserPropsInfoByUnionKey($userId, $propsId);
		if ($userProp && is_array($userProp)) {
			$res = self::updateNumIncreaseAction($userId, $propsId, $num);	
		} else {
			$res = self::create($userId, $propsId, $num);	
		}
		return $res;
	}


	/*
	 * 根据联合主键取得道具信息
	 */
	public static function getUserPropsInfoByUnionKey ( $userId, $propsId ) {
		if(!$userId || !$propsId)	return FALSE;
		$where = array (
			'user_id' 		=> $userId,
			'property_id'	=> $propsId,
		);
		$res = MySql::selectOne(self::TABLE_NAME, $where);
		return $res;	
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
	
	/*
	 * 使用背包
	 */
	public static function usePackNum($userId, $propsId) {
		if(!$userId || !$propsId) return FALSE;

		$num = self::getPropertyNum($userId, $propsId);
		if($num <= 0) {
			throw new Exception ('背包数量不足', 120054);
		}

		//验证是否已到最大购买数
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if($userInfo['pack_num'] >= User::DEFAULT_PACK_MAX){
			throw new Exception ('已经达到上限', 120100);
		}

		$res = self::updateNumDecreaseAction($userId, $propsId);
		if ($res) {
			$res_num = User_Info::updateSingleInfo($userId, 'pack_num', 1, '1');
		}
		$logWhere = array(
			'props_id' => $propsId,		
			'user_id'  => $userId,
			'num'	   => 1,
			'type'	   => Props_Log::ACTION_TYPE_USE, 
		);
		Props_Log::insert($logWhere);
		return $res;	
	}
	
	/*
	 * 使用好友上限
	 */
	public static function useFriendNum($userId, $propsId) {
		if(!$userId || !$propsId) return FALSE;

		$num = self::getPropertyNum($userId, $propsId);
		if($num <= 0) {
			throw new Exception ('好友上限数量不足', 120055);
		}

		//验证是否已到最大购买数
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if($userInfo['friend_num'] >= User::DEFAULT_FRIEND_MAX){
			throw new Exception ('已经达到上限', 120100);
		}

		$res = self::updateNumDecreaseAction($userId, $propsId);
		if ($res) {
			$res_num = User_Info::updateSingleInfo($userId, 'friend_num', 1, '1');
		}
		$logWhere = array(
			'props_id' => $propsId,		
			'user_id'  => $userId,
			'num'	   => 1,
			'type'	   => Props_Log::ACTION_TYPE_USE, 
		);
		Props_Log::insert($logWhere);
		return $res;	
	}
	
	/*
	 * 使用人宠
	 */
	public static function usePetNum($userId, $propsId) {
		if(!$userId || !$propsId) return FALSE;

		$num = self::getPropertyNum($userId, $propsId);
		if($num <= 0) {
			throw new Exception ('人宠上限数量不足', 120056);
		}

		//验证是否已到最大购买数
		$userInfo = User_Info::getUserInfoByUserId($userId);
		if($userInfo['pet_num'] >= User::DEFAULT_PET_MAX){
			throw new Exception ('已经达到上限', 120100);
		}

		$res = self::updateNumDecreaseAction($userId, $propsId);
		if ($res) {
			$res_num = User_Info::updateSingleInfo($userId, 'pet_num', 1, '1');
		}
		$logWhere = array(
			'props_id' => $propsId,		
			'user_id'  => $userId,
			'num'	   => 1,
			'type'	   => Props_Log::ACTION_TYPE_USE, 
		);
		Props_Log::insert($logWhere);
		return $res;	
	}
	
	/*
	 * 使用pk咒符
	 */
	public static function usePkNum($userId, $propsId) {
		if(!$userId || !$propsId) return FALSE;

		$num = self::getPropertyNum($userId, $propsId);
		if($num <= 0) {
			throw new Exception ('pk咒符数量不足', 120057);
		}

		$todayNum = Props_Log::getTodayUseNum($userId, $propsId);
		if($todayNum >= User::PK_BUY_NUM){
			throw new Exception ('已经达到每天上限', 120100);
		}

		$res = self::updateNumDecreaseAction($userId, $propsId);
		if ($res) {
			$res_num = User_Info::updateSingleInfo($userId, 'pk_num', 1, '1');
		}
		$logWhere = array(
			'props_id' => $propsId,		
			'user_id'  => $userId,
			'num'	   => 1,
			'type'	   => Props_Log::ACTION_TYPE_USE, 
		);
		Props_Log::insert($logWhere);
		return $res;	
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
		$res_num = self::updateNumDecreaseAction($userId, self::ATTRIBUTE_ENHANCE);
		
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
		if(!$userId) {
			throw new Exception('缺少用户id', 120059);
		}
		
		//是否已经在用
		$isUse = self::isuseDoubleHarvest($userId);
		if(!empty($isUse)){
			throw new Exception ('此道具已在使用', 120060);	
		}
		
		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::DOUBLE_HARVEST);
		if(empty($isHave))return FALSE;
		
		$res = MySql::insert('double_harvest', array('user_id' => $userId, 'add_time' => time()));
		$res_num = self::updateNumDecreaseAction($userId, self::DOUBLE_HARVEST);
		return $res;
	}
	/** 检测是否在使用挂机符咒
	 * @return 检测是否在使用双倍符咒*/
	public static function isuseDoubleHarvest($userId)
	{
		if(!$userId){
			throw new Exception('缺少用户id', 120059);
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
			throw new Exception('缺少用户id', 120059);
		}

		//是否已经在用
		$isUse = self::isuseAutoFight($userId);
		if(!empty($isUse)){
			throw new Exception ('此道具已在使用', 120060);	
		}

		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::AUTO_FIGHT);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 120070);	
		}

		$res = MySql::insert('auto_fight', array('user_id' => $userId, 'add_time' => time()));
		$res_num = self::updateNumDecreaseAction($userId, self::AUTO_FIGHT);
		return $res;
	}
	/** 检测是否在使用挂机符咒
	 * @return 检测是否在使用挂机符咒*/
	public static function isuseAutoFight($userId)
	{
		if(!$userId){
			throw new Exception('缺少用户id', 120059);
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
			throw new Exception('缺少用户id', 120059);
		}
		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::EQUIP_FORGE);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 120070);	
		}
		$res = self::updateNumDecreaseAction($userId, self::EQUIP_FORGE);
		if($res) {
			$logWhere = array(
				'props_id' => $propsId,		
				'user_id'  => $userId,
				'num'	   => 1,
				'type'	   => Props_Log::ACTION_TYPE_USE, 
			);
			Props_Log::insert($logWhere);
		}
		return $res;
	}
	
	
	/**
	 * 装备成长咒符
	 */
	public static function useEquipGrow($userId, $equipId)
	{
		if(!$userId){
			throw new Exception('缺少用户id', 120059);
		}
		if(!$equipId){
			throw new Exception('缺少装备id', 120071);
		}
		$equipInfo = Equip_info::getEquipInfoById($equipId);
		$equipLev  = $equipInfo['equip_level'];
		if($equipLev < 30){
			throw new Exception ('当前装备等级不够30级,不能使用装备成长符', 120072);	
		}
		//是否还有存数
		$isHave = self::getPropertyNum($userId, self::EQUIP_GROW);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 120070);	
		}
		$res = self::updateNumDecreaseAction($userId, self::Equip_GROW);
		if ($res){
			$logWhere = array(
				'props_id' => $propsId,		
				'user_id'  => $userId,
				'num'	   => 1,
				'type'	   => Props_Log::ACTION_TYPE_USE, 
			);
			Props_Log::insert($logWhere);
		}
		return $res;
	}
		
	/**
	 * 使用普通类宝箱
	 */
	public static function useGeneralTreasureBox($userId, $propsId){
		if(!$userId){
			throw new Exception('缺少用户id', 120059);
		}
		if(!$propsId){
			throw new Exception('缺少道具id', 120090);
		}
		//是否还有存数
		$isHave = self::getPropertyNum($userId, $propsId);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 120070);	
		}
		$res_num = self::updateNumDecreaseAction($userId, $propsId);
		/*
		 * 处理抽取获得
		 */
		if($res_num){
			$logWhere = array(
				'props_id' => $propsId,		
				'user_id'  => $userId,
				'num'	   => 1,
				'type'	   => Props_Log::ACTION_TYPE_USE, 
			);
			Props_Log::insert($logWhere);
			return self::extractEquip( $userId, $propsId, self::BOX_GENERAL);	
		}
		return FALSE;
	}

	/*
	 * 使用精品类宝箱
	 */
	public static function useChoiceTreasureBox($userId, $propsId){
		if(!$userId){
			throw new Exception('缺少用户id', 120059);
		}
		if(!$propsId){
			throw new Exception('缺少道具id', 120090);
		}
		//是否还有存数
		$isHave = self::getPropertyNum($userId, $propsId);
		if(!$isHave || empty($isHave)){
			throw new Exception('该道具数量不足，您无法使用', 120070);	
		}
		$res_num = self::updateNumDecreaseAction($userId, $propsId);
		/*
		 * 处理抽取获得
		 */
		if($res_num){
			$logWhere = array(
				'props_id' => $propsId,		
				'user_id'  => $userId,
				'num'	   => 1,
				'type'	   => Props_Log::ACTION_TYPE_USE, 
			);
			Props_Log::insert($logWhere);
			return self::extractEquip($userId, $propsId, self::BOX_CHOICE);	
		}
		return FALSE;	
	}
	/*
	 * 抽取获得，供使用宝箱类接口调用
	 */
	private function extractEquip($userId, $propsId, $type){
		//普通
		if( $type == self::BOX_GENERAL){
			$pack = Props_Config::$treasure_box_package[Props_Config::KEY_GENERAL_BOX];
			$color = self::randGeneralEquipColor();	
			foreach ($pack as $v) {
				if($propsId == $v['id']){
					$level = $v['level'];	
				}			
			}
			$res = Equip_Create::createEquip($color, $userId, $level);
		} else if($type == self::BOX_CHOICE){
		//精品
			$pack = Props_Config::$treasure_box_package[Props_Config::KEY_CHOICE_BOX];
			foreach ( $pack as $v ) {
				if($propsId == $v['id']){
					$level = $v['level'];	
				}			
			}
			for( $i = 0; $i < 10; $i++ ){
				/*
				 * 两件套装
				 */
				if($i < 2) {
					$equipQuality = Equip::EQUIP_QUALITY_HOLY;
				}
				/*
				 * 至少四件橙色装备
				 */
				if( $i < 4) {
					$color = Equip::EQUIP_COLOUR_ORANGE;
				} else {
					$color = self::randChoiceEquipColor();	
				}
				$res[] = Equip_Create::createEquip($color, $userId, $level, 0, $equipQuality);
			}
		}	
		return $res;
	}
	/*
	 * 随机普通宝箱装备颜色
	 * 蓝色以上装备
	 */
	public function randGeneralEquipColor(){
		$colors = array	(
			Equip::EQUIP_COLOUR_BLUE 	=> 0.3,
			Equip::EQUIP_COLOUR_PURPLE	=> 0.3,
			Equip::EQUIP_COLOUR_ORANGE	=> 0.4,
		);
		$res = PerRand::getRandResultKey($colors);
		return $res;
	}
	/*
	 * 随机精品宝箱装备颜色
	 * 蓝色以上装备
	 */
	public function randChoiceEquipColor(){
		$colors = array	(
			Equip::EQUIP_COLOUR_BLUE 	=> 0.6,
			Equip::EQUIP_COLOUR_PURPLE	=> 0.4,
		);
		$res = PerRand::getRandResultKey($colors);
		return $res;
	}

}
