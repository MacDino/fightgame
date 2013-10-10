<?php
//用户相关
class User_Info
{
	CONST TABLE_NAME = 'user_info';

	/** @desc 是否存在这个用户,可同时检测多个*/
	public static function isExistUser($arrayUserId){
		if(is_array($arrayUserId)){
			$num = 0;
			foreach ($arrayUserId as $userId){
				if(!is_numeric($userId))return FALSE;
				$res = MySql::selectCount(self::TABLE_NAME, array('user_id' => $userId));
				if(empty($res)){
					return FALSE;
				}else{
					$num += 1;
				}
			}
			if($num == count($arrayUserId))return TRUE;
		}else{
			return FALSE;
		}
	}

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

	/** @desc 升级判断 */
	public static function isLevel($userId){
		$userInfo = self::getUserInfoByUserId($userId);
		$newExp = $userInfo['experience'];
		$level = MySql::query("SELECT max(level) as level FROM level_info WHERE need_experience <= $newExp");
//		print_r($level);
//		echo $level[0]['level']."====".$userInfo['user_level'];
		if($level[0]['level'] > $userInfo['user_level']){
			self::addLevelNum($userId, $level[0]['level']);
			//增加技能点
			for($i=$userInfo['user_level']+1; $i<=$level[0]['level']; $i++){
				$addSkill = Skill_Info::addSkillNum($i);
				self::addPointNum($userId, $addSkill);
			}
			return $level[0]['level'];
		}else{
			return FALSE;
		}
	}
	/**
	 * 获取角色列表
	 * @param int $masterId	帐号ID
	 * @param int $area		分区
	 * @return 角色列表
	 */
	public static function listUser($masterId, $areaId){
//		echo "$masterId, $areaId";
		if(empty($masterId) || !$areaId)return FALSE;
		$res = MySql::select(self::TABLE_NAME, array('master_id' => $masterId, 'area_id' => $areaId));
		return $res;
	}

	//根据条件搜索用户 后台用
	public static function searchUser($array){
		$res = MySql::select(self::TABLE_NAME, $array);
		return $res;
	}

	/** @desc 校验重名 */
	public static function verifyUserName($userName){
		$res = MySql::selectOne(self::TABLE_NAME, array('user_name' => $userName));
//		print_r($res);
		if(!empty($res)){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	/** @desc 校验数量 */
	public static function verifyUserNum($masterId){
		$res = MySql::selectCount(self::TABLE_NAME, array('master_id' => $masterId));
//		echo $res;
		if($res >= 3){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	/** @desc 删除好友,暂时不做 */
	public static function delUser($userId){
		//用户表打状态
		//好友表
		//人宠表
		//咒符表
	}

	/**
     * 创建用户基础信息
     * @param int 	$userId	用户ID
     * @param array $data	种族和用户名,其他值走默认
     * @return bool
     */
	public static function createUserInfo($data)
	{
		if(!$data || !is_array($data))return FALSE;
        if(!isset($data['user_name']) || !isset($data['race_id']))return FALSE;
        //$userInfo = self::listUser($data['master_id'], $data['area_id']);
        if($userInfo)throw new Exception('用户已存在', 100001);
        $res = MySql::insert(self::TABLE_NAME,
              array(
                  'user_name'     => $data['user_name'],
                  'race_id'       => $data['race_id'],
                  'user_level' => User::DEFAULT_USER_LEVEL,
			    	'experience' => User::DEFAULT_EXP,
			    	'money'	=> User::DEFAULT_MONEY,
			    	'ingot' => User::DEFAULT_INGOT,
			    	'skil_point' => User::DEFAULT_SKILL,
			    	'pack_num' => User::DEFAULT_PACK_NUM,
			    	'friend_num' => User::DEFAULT_FRIEND_NUM,
			    	'pet_num'	=> User::DEFAULT_PET_NUM,
			    	'reputation' => User::DEFAULT_REPUTATION,
                  	'master_id'     => $data['master_id'],
                  	'area_id'          => $data['area_id'],
                  	'sex'             => $data['sex'],
                ), TRUE);
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

		$sql = "UPDATE " . self::TABLE_NAME . " SET `$key` = `$key` $change $value WHERE user_id = $userId";
		$res = MySql::execute($sql);
		return $res;
	}

	/** @desc 整体更新 */
	public static function editUserInfo($array, $userId){
		$res = MySql::update(self::TABLE_NAME, $array, array('user_id' => $userId));
		return $res;
	}

	//增加金币
	public static function addMoney($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `money` = `money` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}

	//减少金币
	public static function subtractMoney($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `money` = `money` - '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}

	//增加元宝
	public static function addIngot($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `ingot` = `ingot` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}

	//减少元宝
	public static function subtractIngot($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `ingot` = `ingot` - '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}

	//增加经验
	public static function addExperience($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `experience` = `experience` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}

	//减少经验
	public static function subtractExperience($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `experience` = `experience` - '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}

	//增加包裹上限
	public static function addPackNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `pack_num` = `pack_num` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	//增加好友上限
	public static function addFriendNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `friend_num` = `friend_num` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	//增加人宠上限
	public static function addPetNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `pet_num` = `pet_num` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	/** 增加人物等级 */
	public static function addLevelNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `user_level` = '$num' WHERE user_id = '$userId'";
//		echo $sql;
		$res = MySql::query($sql);
		return $res;
	}
	//减少人物等级
	public static function subtractLevelNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `user_level` = `user_level` - '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	//增加PK次数
	public static function addPKNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `pk_num` = `pk_num` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	//减少PK次数
	public static function subtractPKNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `pk_num` = `pk_num` - '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	//增加技能点
	public static function addPointNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `skil_point` = `skil_point` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	//减少技能点
	public static function subtractPointNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `skil_point` = `skil_point` - '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}

	//增加声望
	public static function addReputationNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `reputation` = `reputation` + '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
		return $res;
	}
	//减少声望
	public static function subtractReputationNum($userId, $num)
	{
		if(!$userId || !$num)return FALSE;

		$sql = "UPDATE " . self::TABLE_NAME . " SET `reputation` = `reputation` - '$num' WHERE user_id = '$userId'";
		$res = MySql::query($sql);
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
		    ConfigDefine::RELEASE_PROBABILITY 		  	=> 0,//释放概率
		);

		//根据ID取出用户基本信息
		$userInfo = self::getUserInfoByUserId($userId);

		//装备加成
		$equipInfo = Equip_Info::getEquipListByUserId($userId, TRUE);//根据ID取出所有装备,假设为getEquipInfoByUserId
		foreach ($equipInfo as $p)
		{//把装备中的属性点放在一起,属性值放在一起
			//基础属性
			$equipBaseAttribute = json_decode($p['attribute_base_list'], TRUE);
			if(is_array($equipBaseAttribute)){
				foreach ($equipBaseAttribute as $m=>$n)
				{
					if(array_key_exists($m, $baseAttribute))//装备中属性点部分
					{
						$baseAttribute[$m] += $n;
					}elseif(array_key_exists($m, $valueAttribute)){//装备中属性值部分
						$valueAttribute[$m] += $n;
					}else{
					}
				}
			}
			//扩展属性
			$equipExpandAttribute = json_decode($p['attribute_list'], TRUE);
			if(is_array($equipExpandAttribute)){
				foreach ($equipExpandAttribute as $x=>$y)
				{
					if(array_key_exists($x, $baseAttribute))//装备中属性点部分
					{
						$baseAttribute[$x] += $y;
					}elseif(array_key_exists($x, $valueAttribute)){//装备中属性值部分
						$valueAttribute[$x] += $y;
					}else{
					}
				}
			}
		}

		//技能加成
		$skillAttribute = Skill_Info::getSkillList($userId);

		foreach ($skillAttribute as $a){
			$skillValue = Skill_info::getSkillAttribute($a['skill_id'], $a['skill_level'], $userInfo['race_id']);
//			print_r($skillValue);
			if(is_array($skillValue)){
				foreach ($skillValue as $x=>$y)
				{
					if(array_key_exists($x, $baseAttribute))//技能加成中属性点部分
					{
						$baseAttribute[$x] += $y;
					}elseif(array_key_exists($x, $valueAttribute)){//技能加成中属性值部分
						$valueAttribute[$x] += $y;
					}else{
					}
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
//		print_r($userAttributeValue);

		//把装备带来的属性值融合进基本属性值里
		foreach ($valueAttribute as $key => $value){
			$userAttributeValue[$key] += $value;
		}

		//体修加成
		if(array_key_exists(ConfigDefine::SKILL_TX, $skillAttribute)){
			$userAttributeValue[ConfigDefine::USER_ATTRIBUTE_BLOOD] += $userAttributeValue[ConfigDefine::USER_ATTRIBUTE_BLOOD] * 0.01 * $skillAttribute[ConfigDefine::SKILL_TX]['skill_level'];
		}

		if(Equip_Info::isEmboitement($userId, $userInfo['race_id'])){//套装增益
			$userAttributeValue = self::emboitementUserAttribute($userAttributeValue);
		}

		if(User_Property::isuseAttributeEnhance($userId)){
			$userAttributeValue = self::strengthenUserAttribute($userAttributeValue);
		}

		return $userAttributeValue;
	}

	/**
     * @desc 使用属性增强符咒
     * @param array $data	属性数组
     * @return array
     */
	public static function strengthenUserAttribute($data){

		if(!is_array($data))return FALSE;

		$res = array();
		foreach ($data as $key => $value){
			$res[$key] = $value * (1 + User::ATTEIBUTEENHANCE);
		}
		return $res;
	}

	/**
     * @desc 套装增益
     * @param array $data	属性数组
     * @return array
     */
	public static function emboitementUserAttribute($data){
		if(!is_array($data))return FALSE;

		$res = array();
		foreach ($data as $key => $value){
			$res[$key] = $value * (1 + User::EMBOITEMENT);
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
			$res[$key] = $value * (1 - User::ATTEIBUTEENHANCE);
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
			$res[$key] = $value * (1 + User::ATTEIBUTEENHANCE);
		}
		return $res;
	}

	public static function levelUp($userId, $level = NULL){
		//调用奖励

	}

	//锻造成功率 isUse 是否使用锻造符
	public static function forgeOdds($userId, $isUse = FALSE){
		//技能本身成功率
		$skillLevel = Skill_Info::getSkillInfo($userId, 2);
		$skillOdds = Skill::getQuickAttributeForEquip($skillLevel);
		//幸运加的成功率
		$lucky = self::getUserInfoFightAttribute($userId, TRUE);
		$luckyOdds = $lucky[ConfigDefine::USER_ATTRIBUTE_LUCKY];
		//锻造符加的成功率
		if(!empty($isUse)){
			$amulet = User::FORGEODDS;
		}

		return $skillOdds;
	}

	/** @desc 查找等级在10之内的用户 */
	public static function nearUser($userId){
		$sql = "select * from user_info where user_level > user_level-11 and user_level < user_level+11 and user_id != $userId";
		$res = MySql::query($sql);
		return $res;
	}

}
