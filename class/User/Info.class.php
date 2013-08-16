<?php    
//角色相关
class User_Info
{
	CONST TABLE_NAME = 'user_info';

	/**
     * 根据UserId获取用户基本信息
     * @param int $userId	用户ID
     * @return array
     */
	public static function getUserInfoByUserId($userId)
	{
		if(!is_numeric($userId))return FALSE;

		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}

	/**
     * 验证用户是否超过限定等级
     * @param int	 $friendId		用户ID
     * @param int	 $compare		对比方式
     * @param int	 $level			限制等级
     * @return bool
     */
	public static function getUserInfoByLevel($friendId, $compare, $level){
		if(!is_numeric($friendId) || !is_numeric($level))return FALSE;

		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $friendId, 'user_level' => array('opt' => $compare, 'val' => $level)));
		return $res;
	}

	/**
     * 创建用户基础信息
     * @param int 	$userId	用户ID
     * @param array $data	种族和用户名,其他值走默认
     * @return bool
     */
	public static function createUserInfo($userId, $data)
	{
		if(!$userId || !$data || !is_array($data))return FALSE;

		$info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
		if($info)return FALSE;

		if(!isset($data['user_name']) || !isset($data['race_id']))return FALSE;

		$res = MySql::insert(self::TABLE_NAME, array(
		'user_id' => $userId,
		'user_name' => $data['user_name'],
		'race_id' => $data['race_id'],
		'user_level' => User::DEFAULT_USER_LEVEL,
		'experience' => User::DEFAULT_EXP,
		'money' => User::DEFAULT_MONEY,
		'ingot' => User::DEFAULT_INGOT,
		'pack_num' => User::DEFAULT_PACK_NUM,
		'friend_num' => User::DEFAULT_FRIEND_NUM,
		));
		return $res;
	}

	/**
     * 更新用户基础信息,此处应该只能更新用户名,暂时不用这个function,除非是后台调整数据
     *
     * @param int $userId
     * @param array $data
     * @return bool
     */
	public static function updateUserInfo($userId, $data)
	{
		if(!$userId || !$data || !is_array($data))return FALSE;

		$info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
		if($info)return FALSE;

		$updateArray = array();

		isset($data['user_name'])?$updateArray['user_name'] = (int)$data['user_name']:'';
		isset($data['user_level'])?$updateArray['user_level'] = (int)$data['user_level']:'';
		isset($data['experience'])?$updateArray['experience'] = (int)$data['experience']:'';
		isset($data['money'])?$updateArray['money'] = (int)$data['money']:'';
		isset($data['ingot'])?$updateArray['ingot'] = (int)$data['ingot']:'';
		isset($data['ingot'])?$updateArray['ingot'] = (int)$data['friend_num']:'';
		isset($data['ingot'])?$updateArray['ingot'] = (int)$data['pack_num']:'';
		isset($data['ingot'])?$updateArray['ingot'] = (int)$data['skil_point']:'';

		$res = MySql::update(self::TABLE_NAME, $updateArray, array('user_id' => $userId));
		return $res;
	}

	/**
     * 用户信息单项更新
     * 可支持买包裹上限,买人宠上限,买好友上限,以及更新元宝数,更新声望,更新经验,更新金钱
     * @param int		 $userId	用户ID
     * @param string	 $key		变化的项
     * @param string	 $value		值
     * @param string	 $channel	+or-
     */
	public static function updateSingleInfo($userId, $key, $value, $change){
		if(!$userId || !$key || !$value || !$change)return FALSE;

		if($change == 1){
			$change = '+';
		}elseif($change == 2){
			$change = '-';
		}else{
			return FALSE;
		}

		$sql = "UPDATE " . self::TABLE_NAME . " SET $key = " . "$key $change $value WHERE user_id = $userId";
		$res = Mysql::query($sql);
		return $res;
	}

	/**
     * 获取用户在战斗时的即时属性
     * 先计算数值,然后就算比率
     * 属性组成
     * 		基本属性
     * 		装备加成
     * @param int $user_id	用户ID
     * @return array
     */
	public static function getUserInfoFightAttribute($userId, $needvalue = FALSE){
		//属性点
		$baseAttribute = array(
			ConfigDefine::USER_ATTRIBUTE_POWER			=> 0,//力量
			ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER	=> 0,//魔力
			ConfigDefine::USER_ATTRIBUTE_PHYSIQUE		=> 0,//体质
			ConfigDefine::USER_ATTRIBUTE_ENDURANCE		=> 0,//耐力
			ConfigDefine::USER_ATTRIBUTE_QUICK			=> 0,//敏捷
		);
		//属性值
		$valueAttribute = array(
			ConfigDefine::USER_ATTRIBUTE_HIT          	=> 0,//命中 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_HURT         	=> 0,//伤害 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_MAGIC        	=> 0,//魔法 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_BLOOD        	=> 0,//气血 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_PSYCHIC      	=> 0,//灵力 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_SPEED        	=> 0,//速度 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_DEFENSE      	=> 0,//防御 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_DODGE        	=> 0,//躲闪 - 成长属性
		    ConfigDefine::USER_ATTRIBUTE_LUCKY        	=> 0,//幸运 - 成长属性
		);

		//根据ID取出用户基本信息
		$userInfo = self::getUserInfoByUserId($userId);

		//根据ID取出所有装备,假设为getEquipInfoByUserId
		$equipInfo = Equip_Info::getEquipInfoByUserId($userId, TRUE);
		//把装备中的属性点放在一起,属性值放在一起
		foreach ($equipInfo as $p)
		{
			//基础属性
			$equipBaseAttribute = json_decode($p['attribute_base_list'], TRUE);
			foreach ($equipBaseAttribute as $m=>$n)
			{
				if(in_array($m, $baseAttribute))//装备中属性点部分
				{
					$baseAttribute[$m] += $n;
				}elseif(in_array($m, $valueAttribute)){//装备中属性值部分
					$valueAttribute[$m] += $n;
				}else{
				}
			}
			//扩展属性
			$equipExpandAttribute = json_decode($p['attribute_list'], TRUE);
			foreach ($equipExpandAttribute as $x=>$y)
			{
				if(in_array($x, $baseAttribute))//装备中属性点部分
				{
					$baseAttribute[$x] += $y;
				}elseif(in_array($x, $valueAttribute)){//装备中属性值部分
					$valueAttribute[$x] += $y;
				}else{
				}
			}
		}
		
		//根据种族和等级取出基本属性点
		$userBaseAttribute = User_Attributes::getBaseAttribute($userInfo['race_id'], $userInfo['user_level']);
		
		//把装备带来的属性点融合进基本属性点里
		foreach ($baseAttribute as $keyBase => $valueBase){
			$userBaseAttribute[$keyBase] += $valueBase;
		}
		
		//如果不需要输出属性值,直接在这里结束,输出属性点
		if(!$needvalue)return $userBaseAttribute;
		
		//根据种族ID和总属性点算出基本属性值
		$userAttributeValue = User_Attributes::getAttributesValue($userInfo['race_id'], $userBaseAttribute);

		//把装备带来的属性值融合进基本属性值里
		foreach ($valueAttribute as $key => $value){
			$userAttributeValue[$key] += $value;
		}

//    	var_dump($userAttributeValue);
		return $userAttributeValue;
	}

	/**
     * 使用属性增强符咒
     * @param array $data	属性数组
     * @return array 
     */
	public static function strengthenUserAttribute($data){
		if(!is_array($data))return FALSE;

		$res = array();
		foreach ($data as $key => $value){
			$res[$key] = $value * (1 + USER::ATTEIBUTEENHANCE);
		}
		return $res;
	}

	/**
     * 种族属性被克
     * @param array $data	属性数组
     * @return array 
     */
	public static function restraintAttribute($data){
		if(!is_array($data))return FALSE;

		$res = array();
		foreach ($data as $key => $value){
			$res[$key] = $value * (1 - USER::ATTEIBUTEENHANCE);
		}
		return $res;
	}

	/**
     * 种族属性相生
     * @param array $data	属性数组
     * @return array 
     */
	public static function begetsAttribute($data){
		if(!is_array($data))return FALSE;

		$res = array();
		foreach ($data as $key => $value){
			$res[$key] = $value * (1 + USER::ATTEIBUTEENHANCE);
		}
		return $res;
	}




}
