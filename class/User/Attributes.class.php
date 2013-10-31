<?php
class User_Attributes
{
	private static $baseAttribute = array(
			ConfigDefine::USER_ATTRIBUTE_POWER			=> 0,//力量
			ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER	=> 0,//魔力
			ConfigDefine::USER_ATTRIBUTE_PHYSIQUE		=> 0,//体质
			ConfigDefine::USER_ATTRIBUTE_ENDURANCE		=> 0,//耐力
			ConfigDefine::USER_ATTRIBUTE_QUICK			=> 0,//敏捷
		);
		
	private static $valueAttribute = array(
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
	
	
    //获取用户所有属性 
    public static function getUserAllAttribute($raceId, $level)
    {
        $userBaseAttribute = self::getBaseAttribute($raceId ,$level);
        if($userBaseAttribute)$userGrowUpAttribute = User_Race::getGrowUpAttributes($raceId, $userBaseAttribute);
        $userAllAttribute = $userBaseAttribute + $userGrowUpAttribute;
        return $userAllAttribute;
    }
    /**
     * 获取某种族在某等级属性点
     * @param int $raceId				种族ID
     * @param int $level				等级
     * @return array
     */
    public static function getBaseAttribute($raceId, $level)
    {
        if(!$raceId)return FALSE;
        $raceId = (int)$raceId;
        $level = (int)$level;
        
        //获取种族基本属性
        $defautlAttributes = User_Race::getDefaultAttributes($raceId);
        if(!is_array($defautlAttributes))return FALSE;
        
        //获取种族属性升级加成
        $addAttributesList = User_Race::getLeveUpAddAttributes($raceId);
        if(!is_array($addAttributesList))return FALSE;
        
        //获取种族某等级属性点
        foreach($defautlAttributes as $key => &$value)
        {
            if(isset($addAttributesList[$key]))
            {
                $value += $addAttributesList[$key]*$level;
            }
        }
        unset($value);
        $res = $defautlAttributes;
        return $res;
    }
    /**
     * 根据属性点,通过成长属性,获取属性值
     * @param int	$raceId
     * @param array $data
     * @return array
     */
    public static function getAttributesValue($raceId, $data){
    	if(!$raceId || !is_array($data))return FALSE;
    	$res = User_Race::getGrowUpAttributes($raceId, $data);
    	$res[ConfigDefine::RELEASE_PROBABILITY] = 0;
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
		if(!empty($equipInfo)){
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
		}

		//技能加成
		$skillAttribute = Skill_Info::getSkillList($userId);
		if(!empty($skillAttribute)){
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
						}
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
		
		//内丹加成
		$pillInfo = Pill_Pill::usedPill($userId);
		if(!empty($pillInfo) && $pillInfo['pill_type'] != YUHENGNEIDAN){
			$pillValue = Pill::pillAttribute($pillInfo['pill_type'], $pillInfo['pill_layer'], $pillInfo['pill_level']);
			foreach ($pillValue as $key=>$value){
				$userAttributeValue[$key] += $value;
			}
		}
		
		//人宠异性加成
		$petInfo = Pet::usedPet($userId);
		if($petInfo['sex'] != $userInfo['sex']){
			$userAttributeValue = self::isomerismUserAttribute($userAttributeValue);
		}

		//套装增益
		if(Equip_Info::isEmboitement($userId, $userInfo['race_id'])){
			$userAttributeValue = self::emboitementUserAttribute($userAttributeValue);
		}

		//符咒增益
		if(User_Property::isuseAttributeEnhance($userId)){
			$userAttributeValue = self::strengthenUserAttribute($userAttributeValue);
		}

		return $userAttributeValue;
	}

	/**
     * @desc 异性加成
     * @param array $data	属性数组
     * @return array
     */
	public static function isomerismUserAttribute($data){

		if(!is_array($data))return FALSE;

		$res = array();
		foreach ($data as $key => $value){
			$res[$key] = $value * (1 + User::ISOMERISM);
		}
		return $res;
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
	
	/**
	 * 距离属性加成
	 */
	public static function distanceAttribute($petId, $userId, $data){
		$petInfo = User_LBS::getNearUser(array($petId), $userId);
//		print_r($petInfo);
		$distance = $petInfo[0]['distance'];
		if($distance < 100){
			$coefficient = 0.1;
		}elseif ($distance >= 100 && $distance < 500){
			$coefficient = 0.05;
		}elseif ($distance <= 500 && $distance < 1000){
			$coefficient = 0.03;
		}elseif ($distance <= 1000 && $distance > 3000){
			$coefficient = 0;
		}elseif ($distance <= 3000 && $distance > 5000){
			$coefficient = -0.03;
		}elseif ($distance <= 5000 && $distance > 10000){
			$coefficient = -0.05;
		}elseif ($distance > 10000){
			$coefficient = -0.1;
		}

		$res = array();
		foreach ($data as $key => $value){
			$res[$key] = $value * (1 + $coefficient);
		}
		return $res;
		
	}
    
}
