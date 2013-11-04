<?php

class NewSkill
{
	CONST SKILL_DEFAULT_PT 			= 1201;//普通攻击
	CONST SKILL_COMMON_BD_WFX 		= 1202;//被动技能-物防修
	CONST SKILL_COMMON_BD_FFX 		= 1203;//被动技能-法防修
	CONST SKILL_COMMON_BD_WGX 		= 1204;//被动技能-物攻修
	CONST SKILL_COMMON_BD_FGX 		= 1205;//被动技能-法攻修
	CONST SKILL_HUMAN_GJ_DTWLGJ 	= 1206;//人族-攻击-单体物理攻击
	CONST SKILL_HUMAN_GJ_WGK 		= 1207;//人族-攻击-物攻控
	CONST SKILL_HUMAN_GJ_FGK 		= 1208;//人族-攻击-法攻控
	CONST SKILL_HUMAN_GJ_JL 		= 1209;//人族-攻击-加蓝
	CONST SKILL_HUMAN_GJ_DJX 		= 1210;//人族-攻击-单加血
	CONST SKILL_HUMAN_FY_FJ 		= 1211;//人族-防御-反击
	CONST SKILL_TSIMSHIAN_GJ_DTFSGJ = 1212;//仙族-攻击-单体法术攻击
	CONST SKILL_TSIMSHIAN_GJ_QTFSGJ = 1213;//仙族-攻击-群体法术攻击
	CONST SKILL_TSIMSHIAN_GJ_XR 	= 1214;//仙族-攻击-虚弱
	CONST SKILL_TSIMSHIAN_GJ_QJX 	= 1215;//仙族-攻击-群加血
	CONST SKILL_TSIMSHIAN_GJ_QJSH 	= 1216;//仙族-攻击-群加伤害
	CONST SKILL_TSIMSHIAN_FY_ZJ 	= 1217;//仙族-防御-招架
	CONST SKILL_DEMON_GJ_DTGJ 		= 1218;//魔族-攻击-单体攻击
	CONST SKILL_DEMON_GJ_QTGJ 		= 1219;//魔族-攻击-群体攻击
	CONST SKILL_DEMON_GJ_JCK 		= 1220;//魔族-攻击-解除控
	CONST SKILL_DEMON_GJ_FH 		= 1221;//魔族-攻击-复活
	CONST SKILL_DEMON_GJ_QJL 		= 1222;//魔族-攻击-群加灵
	CONST SKILL_DEMON_FY_FZ 		= 1223;//魔族-攻击-反震
    
    private static $_skillConfig = NULL;
    CONST SKILL_CONFIG_TABLE = 'skill_config';
    
    private static $_addition = 1;//攻击加成
	private static $_rand5UserLevelGetTop3Average = 0;//随机5次用户等级，取最大三个值的平均值
	private static $_randUserAttributePower = 0;
	private static $_randUserAttributeHurt = 0;

	/**
	 * 判断命中
	 */
	public static function getHit($attackMemberObj, $defineMemberObj, $attackSkillInfo)
	{
		if(NewFight::DEBUG)return TRUE;
		$functionName = '_'.key($attackSkillInfo).'GetHit';
		 
		if(!method_exists('NewSkill', $functionName))
		{
			return TRUE;
		}else{
			return call_user_func('NewSkill::'.$functionName, $attackMemberObj, $defineMemberObj, $attackSkillInfo);
		}
	}
	
	/**
	 * 获取攻击伤害
	 * 
	 * //计算的攻击值中已减去防御属性值，并且已经乘以暴击系数，并且已计算出被动技能值，即计算出的值可以直接减血使用
	 */
	//todo 判断是否为攻击类，封类，恢复类，增益类
	public static function getAttack($attackMemberObj, $attackSkillInfo)
	{
		for($i=1;$i<=$attackSkillInfo['hand_num'];$i++)
		{
		self::$_rand5UserLevelGetTop3Average = self::_rand5UserLevelGetTop3Average($attackMemberObj->getMemberLevel());
		self::$_addition = self::_attackAddition($attackMemberObj->getMemberId());
		self::$_randUserAttributePower = self::_randUserAttributePower($attackMemberObj->getMemberAttributePower());
		self::$_randUserAttributeHurt = self::_randUserAttributePower($attackMemberObj->getMemberAttributeHurt());
		 
		$functionName = '_'.$attackSkillInfo['skill_id'].'GetAttack';
		 
		if(!method_exists('NewSkill', $functionName))
		{
		$hurt = 0;
		}else{
		$hurt = call_user_func('NewSkill::'.$functionName, $attackMemberObj, $attackSkillInfo, $i);
		}
		$return[] = array('hurt' => $hurt, 'addition' => self::$_addition);
		}
		var_dump($return);
		return $return;
		 
		}
	
	private static function _1201GetHit($attackMemberObj, $defineMemberObj, $attackSkillInfo)
	{
		$randHit = PerRand::getRandValue($attackMemberObj->getMemberAttributeHit()*0.2, $attackMemberObj->getMemberAttributeHit()*1);
		$randDodge = PerRand::getRandValue($defineMemberObj->getMemberAttributeDodge()*0.8, $defineMemberObj->getMemberAttributeDodge()*1);
		return $randHit - $randDodge >=1 ?TRUE:FALSE; 
	}
	
	private static function _1207GetHit($attackMemberObj, $defineMemberObj, $attackSkillInfo)
	{
		$ration = (current($attackSkillInfo) - $defineMemberObj->getMemberLevel())*0.02 + PerRand::getRandValue(0.05, 0.8);
		if($ration <=0 )return FALSE;
		if(PerRand::getRandResultKey(array($ration)))
		{
			return TRUE;
		}
		return FALSE;
	}
    
    
    /**
     * 伤害结果加成
     * @param float 伤害结果 $hurt
     */
    public static function hurtAddition($hurt)
    {
    	$functionName = '_'.key(self::$_attackSkillInfo).'HutrAddition';
    	 
    	if(!method_exists('NewSkill', $functionName))
    	{
    		return $hurt;
    	}else{
    		return call_user_func('NewSkill::'.$functionName, $hurt);
    	}
    }
    
    private static function _1201GetAttack($attackMemberObj)
    {
    	$hurt = self::$_rand5UserLevelGetTop3Average + $attackMemberObj->getMemberAttributeHit()/3 
    		+ $attackMemberObj->getMemberAttributeHurt() + self::$_randUserAttributePower;
    	return $hurt;
    }
    /**
     * 暴击系数
     */
    private static function _attackAddition($userId = 0)
    {
    	$ratioValue = 1;
    	$ratio = 0.05;
    	if(NewFight::DEBUG)$ratio = 1;
    	
    	$violentPill = Pill_Pill::usedPill($userId);//暴击内丹
    	if($violentPill['pill_type'] == Pill::YUHENGNEIDAN){
    		$isViolent = 1;
    		$violentInfo = Pill::pillAttribute($violentPill['pill_type'], $violentPill['pill_layer'], $violentPill['pill_level']);
    	}
    	if($isViolent == 1){
    		$ratio += $violentInfo['probability'];
    	}
    	
    	$ratioKey = PerRand::getRandResultKey(array($ratio));
    	
    	if($ratioKey || $ratioKey === 0)$ratioValue = 2;
    	if($isViolent == 1){
    		$ratioValue += $violentInfo['value'];
    	}
    	return $ratioValue;
    }
   
    
    /**
     * 获取防御值
     */
    //todo 判断是否为防御技能
    //todo 确认哪些是物理攻击，哪些是法术攻击
    public static function getDefine($defineMemberObj, $attackSkillId)
    {    	
    	switch ($attackSkillId)
    	{
    		case self::SKILL_DEFAULT_PT:
    			$define = $defineMemberObj->getMemberAttributeDfense();
    			break;
    		case self::SKILL_TSIMSHIAN_GJ_DTFSGJ:
    			$define = $defineMemberObj->getMemberAttributePsychic();
    			break;
    		default:
    			$define = 0;
    			break;
    	} 
    	return $define;
    }
    
    


    public static function getSkillConfig($skillId, $skillLevel)
    {
        if(!is_array(self::$_skillConfig))
        {
            $skillConfigList = MySql::select(self::SKILL_CONFIG_TABLE);
            if(is_array($skillConfigList) && $skillConfigList)
            {
                foreach($skillConfigList as $skillConfig)
                {
                    $attack_num = 1;
                    if($skillConfig['attack_num_each_level'] > 0)
                    {
                        $attack_num = floor($skilLevel/$skillConfig['attack_num_each_level']);
                        if($attack_num < 1)$attack_num = 1;
                    }
                    unset($skillConfig['attack_num_each_level']);
                    $skillConfig['hit_member_num'] = $attack_num;
                    if($skillConfig['is_consume_attack_num'])
                    {
                        $consume_1109 = $skillConfig['consume_1109'] * $attack_num;
                        $consume_1108 = $skillConfig['consume_1108'] * $attack_num;
                    }else{
                        $consume_1109 = $skillConfig['consume_1109'];
                        $consume_1108 = $skillConfig['consume_1108'];
                    }
                    unset($skillConfig['is_consume_attack_num']);
                    unset($skillConfig['consume_1109']);
                    unset($skillConfig['consume_1108']);
                    $skillConfig['consume'] = array(1109 => $consume_1109, 1108 => $consume_1108);
                    $skillConfig['target'] = json_decode($skillConfig['target'], true);
                    $skillList[$skillConfig['skill_id']] = $skillConfig;
                }
                self::$_skillConfig = $skillList;
            }
        }
        return self::$_skillConfig[$skillId];
    }
    //判断用户是否可以使用这个技能，前置
	public static function isMemberCanUseSkill($memberObj, $skillId)
	{
		$functionName = '_'.$skillId.'IsUserCanUseSkill';
		if(!method_exists('NewSkill', $functionName))return TRUE;
		return call_user_func('NewSkill::'.$functionName, $memberObj);
	}
	//判断加蓝是否可用
	private static function _1209IsUserCanUseSkill($memberObj)
	{
		
		$userMagic = NewFight::getUserCurrentMagic($userKey);
		if($memberObj->_currentMagic >= 50)return TRUE;
		return FALSE;
	}
	//判断复活是否可用
	private static function _1221IsUserCanUseSkill($memberObj)
	{
		$teamKey = NewFIght::getUserTeamKey($userKey);
		$teamDiedUserNum = NewFight::getTeamDiedUserNum($teamKey);
		return $teamDiedUserNum?TRUE:FALSE;
	}
	//获取防御技能列表
	public static function getDefineSkillList($raceId = NULL)
	{
		$skillList =  array(
							User_Race::RACE_HUMAN => array(
                                                           self::SKILL_HUMAN_FY_FJ,
                                                           ),
							User_Race::RACE_TSIMSHIAN => array(
                                                               self::SKILL_TSIMSHIAN_FY_ZJ,
                                                               ),
							User_Race::RACE_DEMON => array(
                                                           self::SKILL_DEMON_FY_FZ,
                                                           ),
                            );
		return isset($skillList[$raceId])?$skillList[$raceId]:$skillList;
	}
	//获取攻击技能列表
	public static function getAttackSkillList($raceId = NULL)
	{
		$skillList =  array(
                            User_Race::RACE_HUMAN => array(
                                                           self::SKILL_HUMAN_GJ_DTWLGJ,
                                                           self::SKILL_HUMAN_GJ_WGK,
                                                           self::SKILL_HUMAN_GJ_FGK,
                                                           self::SKILL_HUMAN_GJ_JL,
                                                           self::SKILL_HUMAN_GJ_DJX,
                                                           ),
                            User_Race::RACE_TSIMSHIAN => array(
                                                               self::SKILL_TSIMSHIAN_GJ_DTFSGJ,
                                                               self::SKILL_TSIMSHIAN_GJ_QTFSGJ,
                                                               self::SKILL_TSIMSHIAN_GJ_XR,
                                                               self::SKILL_TSIMSHIAN_GJ_QJX,
                                                               self::SKILL_TSIMSHIAN_GJ_QJSH,
                                                               ),
                            User_Race::RACE_DEMON => array(
                                                           self::SKILL_DEMON_GJ_DTGJ,
                                                           self::SKILL_DEMON_GJ_QTGJ,
                                                           self::SKILL_DEMON_GJ_JCK,
                                                           self::SKILL_DEMON_GJ_FH,
                                                           self::SKILL_DEMON_GJ_QJL,
                                                           ),
                            );
		return isset($skillList[$raceId])?$skillList[$raceId]:$skillList;
	}
	
	//获取被动技能列表
	public static function getPassiveSkillList()
	{
		return array(
                     self::SKILL_COMMON_BD_FFX,
                     self::SKILL_COMMON_BD_FGX,
                     self::SKILL_COMMON_BD_WFX,
                     self::SKILL_COMMON_BD_WGX,
                     );
	}	
	//随机获取用用户力量1%-5%
	private static function _randUserAttributePower($userAttributePower)
	{
		return PerRand::getRandValue($userAttributePower*0.01, $userAttributePower*0.05);
	}
	//随机获取用用户伤害3%-9%
	private static function _randUserAttributeHurt($userAttributeHurt)
	{
		return PerRand::getRandValue($userAttributePower*0.03, $userAttributePower*0.09);
	}
	//随机5次用户等级，取最大三个值的平均值
	private static function _rand5UserLevelGetTop3Average($userLevel)
	{
		$userLevel = (int)$userLevel;
		if($userLevel == 1)return 1;
		if($userLevel < 1)return 0;
		for($i=1;$i<=5;$i++)
		{
			$res[] = PerRand::getRandValue(array(0, $userLevel));
		}
		rsort($res);
		$res = array_slice($res, 0, 3);
		$averageValue = array_sum($res)/3;
		return $averageValue;
	}
	
	
	
}