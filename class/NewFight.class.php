<?php
//新战斗中心
class NewFight
{
	private static $_teamHaveNum = array();//团队拥有的用户数量
	private static $_teamHaveDiedNum = array();//团队死亡的用户数量
	private static $_membersList = array(); //所有团队的用户对象列表
    private static $_attackSkillConfig = array();//攻击技能配置信息
    
    CONST ATTACK_ADDITIONCOEFFICIENT = 0.05;//先攻速度加成
    CONST DEFINE_ADDITIONCOEFFICIENT = 0.5;//先守速度加成
    
    CONST DEBUG = 1;
    
    
    
    private $_fightList = array();//战斗过程
    private $_fightKeyMiss = 'miss';//战斗标识
	
	public static function getFightResult($teams)
	{
		try {
			self::_mapTeamsAndMembersInfo($teams);
            $attackMemberKeyList = self::_getAttackMemberKeyOrderList();//获取攻击用户顺序
            
            foreach($attackMemberKeyList as $memberKey)
            {
                //判断是否有队伍获胜
                if(self::_isHaveTeamWin())break;
                $attackMemberObj = self::_getMemberObjByMemberKey($memberKey);
                //获取攻击队员使用的技能
                $attackSkillInfo = $attackMemberObj->getMemberAttackSkill();
                self::$_attackSkillConfig = NewSkill::getSkillConfig(key($attackSkillInfo), current($attackSkillInfo));
                //判断攻击队员是否可以使用此技能
                if(!NewSkill::isMemberCanUseSkill($attackMemberObj, key($attackSkillInfo)))continue;
                //获取防守队员
                $defineMembersObj = self::_getDefineMembersObj($attackMemberObj);
                //开始战斗
                self::_doFight($attackMemberObj, $defineMembersObj, self::$_attackSkillConfig);
                break;
            }
            
		} catch (Exception $e) {
			var_dump($e);
		}
	}
	/**
	 * 执行一次战斗
	 * @param Object $attackMemberObj
	 * @param Object $defineMembersObj
	 * @param Array $attackSkillInfo
	 */
    private static function _doFight($attackMemberObj, $defineMembersObj, $attackSkillInfo)
    {
        //判断攻方休息回合
        if($attackMemberObj->isMemberSleep())return;
        //todo 攻击效果判断攻方是否可以使用此技能
        //消耗
        $consumes = self::$_attackSkillConfig['consume'];
        foreach($consumes as $attributeId => $consume)
        {
            if($attributeId == ConfigDefine::USER_ATTRIBUTE_BLOOD)
            {
                $attackMemberObj->consumeBlood($consume);
            }elseif($attributeId == ConfigDefine::USER_ATTRIBUTE_MAGIC){
                $attackMemberObj->consumeMagic($consume);
            }
        }
        if($attackMemberObj->isDied())return;
        if($attackMemberObj->isEmptyMagic())return;
        //todo 攻击效果-攻方的属性加成
        foreach($defineMembersObj as $defineMemberObj)
        {
            //判断攻守方是否有一方处于死亡状态
            if($attackMemberObj->isDied())break;
            if($defineMemberObj->isDied())continue;
            //todo 攻击效果-判断守方是否可以被此技能攻击
            //todo 攻击效果-守方的属性加成
            //计算是否命中
            $hit = NewSKill::getHit($attackMemberObj, $defineMemberObj, $attackSkillInfo);
            if(!$hit)continue;
            if(self::$_attackSkillConfig['is_have_hurt'])
            {
            	//计算攻击输出
            	//计算的攻击值中已减去防御属性值，并且已经乘以暴击系数，并且已计算出被动技能值，即计算出的值可以直接减血使用
            	$skillHurt = NewSkill::getAttack($attackMemberObj, $attackSkillInfo, $defineMemberObj);
            	foreach($skillHurt as $hurtInfo)
            	{
            		$hurt = $hurtInfo['hurt'];//攻击值
            		$defineSkillInfo = $defineMemberObj->getMemberDefineSkill();
            		//todo 需要定义防御法术的返回值
            		//todo 此处守义防御法术的处理过程
            		//todo 攻击效果-对于攻结果加成
            		//todo 此处定义防御法术的攻击效果累加
            	}
            }
            //todo 此处定义攻击法术的攻击效果累加
            exit;
        }
    }
    
    /**
     * 某队伍中死亡一个队员
     * @params String
     */
    public static function teamDiedMember($teamKey)
    {
        if(isset(self::$_teamHaveDiedNum[$teamKey]))
        {
            self::$_teamHaveDiedNum[$teamKey] += 1;
            return TRUE;
        }else{
            throw new Exception('', 8000005);
        }
    }
    /**
     * 某队伍中复活一个队员
     * @params String
     */
    public static function teamReviveMember($teamKey)
    {
        if(isset(self::$_teamHaveDiedNum[$teamKey]))
        {
            self::$_teamHaveDiedNum[$teamKey] -= 1;
            return TRUE;
        }else{
            throw new Exception('', 8000006);
        }
    }
    /**
     * 获取防守队员对象列表,此处不处理技能的对象个数
     * @params Object
     * @params Int
     * @return Array
     */
    private static function _getDefineMembersObj($attackMemberObj)
    {
        $defineMemberKeyList  = self::_getDefineMemberKeyOrderList();
        $returnMemberObj = array();
        foreach($defineMemberKeyList as $memberKey)
        {
            $memberObj = self::_getMemberObjByMemberKey($memberKey);
            if(in_array(0, self::$_attackSkillConfig['target']))
            {
                //允许对己方使用的
                if(self::$_attackSkillConfig['hit_me'] == 1)
                {
                    if($attackMemberObj == $memberObj)
                    {
                        $returnMemberObj[$memberKey] = $memberObj;
                    }
                }elseif(self::$_attackSkillConfig['hit_me'] == 0){
                    if($attackMemberObj != $memberObj)
                    {
                        if($attackMemberObj->getMemberTeamKey() == $memberObj->getMemberTeamKey())
                        {
                            $returnMemberObj[$memberKey] = $memberObj;
                        }
                    }
                }
            }elseif(in_array(1, self::$_attackSkillConfig['target'])){
                //允许对对方使用的
                if($attackMemberObj->getMemberTeamKey() != $memberObj->getMemberTeamKey())
                {
                    $returnMemberObj[$memberKey] = $memberObj;
                }
            }
        }
        return $returnMemberObj;
    }
    /**
     * 根据队员KEY，获取队员对象
     * @params String 队员key
     * @return Object
     */
    private static function _getMemberObjByMemberKey($memberKey)
    {
        if(!is_array(self::$_membersList))throw new Exception('', 8000003);
        if(!isset(self::$_membersList[$memberKey]))throw new Exception('', 8000004);
        return self::$_membersList[$memberKey];
    }
    
    /**
     * 判断是否已经有队伍获胜
     * 判断队伍获胜标准为，只有一个队有活的队员，其它队伍的队员全部处理死亡状态
     * @return Boolean
     */
    private static function _isHaveTeamWin()
    {
        $haveTema = count(self::$_teamHaveNum);
		foreach (self::$_teamHaveNum as $teamKey => $teamHaveNum)
		{
			if($teamHaveNum == self::$_teamHaveDiedNum[$teamKey])
			{
				--$teamHaveNum;
			}
		}
		return $haveTema==1?TRUE:FALSE;
    }
	
	/**
	 * 整理队伍及用户信息
	 * @param array $teams
	 */
	private static function _mapTeamsAndMembersInfo($teams)
	{
		foreach($teams as $teamKey => $team)
		{
			self::$_teamHaveNum[$teamKey] = count($team);
			self::$_teamHaveDiedNum[$teamKey] = 0;
			foreach($team as $memberInfo)
			{
				$memberInfo->setMemberTeamKey($teamKey);
				self::$_membersList[] =  $memberInfo;
			}
		}
		return TRUE;
	}
	/**
	 * 获取攻击用户顺序ID列表
	 * @return array
	 */
	private static function _getAttackMemberKeyOrderList()
	{
		$memberList = self::_getAllMemberSpeed(ATTACK_ADDITIONCOEFFICIENT);
        arsort($memberList);
        return array_keys($memberList);
	}
	/**
	 * 获取防守用户ID顺序列表
	 * @return array
	 */
	private static function _getDefineMemberKeyOrderList()
	{
		$memberList = self::_getAllMemberSpeed(DEFINE_ADDITIONCOEFFICIENT);
        arsort($memberList);
        return array_keys($memberList);
	}
	/**
	 * 获取全部用户的加成速度
	 * @param unknown_type $additionCoefficient
	 * @throws Exception
	 */
	private static function _getAllMemberSpeed($additionCoefficient)
	{
		if(!is_array(self::$_membersList))throw new Exception('', 8000002);
		foreach(self::$_membersList as $key => $member)
		{
			$memberList[$key] = self::_getMemberAdditionSpeed($member, $additionCoefficient);
		}
		return $memberList;
	}
	/**
	 * 获取用户的加成速度
	 * @param object $memberInfo
	 * @param float  $additionCoefficient
	 * @return float
	 */
	private static function _getMemberAdditionSpeed($memberInfo, $additionCoefficient)
	{
		if(!is_object($memberInfo))throw new Exception('', 8000001);
		return $memberInfo->getMemberSpeed()*PerRand::getRandValue(array((1-$additionCoefficient), (1+$additionCoefficient)));
	}
	//------debug
	public static function debug()
	{
		echo "DEBUG开始：<br />";
		echo "队伍状况：<br />";
		foreach (self::$_teamHaveNum as $teamKey => $haveNum)
		{
			echo "队伍".$teamKey."共计有队员".$haveNum."目前已经死亡".self::$_teamHaveDiedNum[$teamKey]."<br />";
		}
		
		echo "DEBUG结束";
	}
}