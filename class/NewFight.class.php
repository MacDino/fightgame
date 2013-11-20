<?php
//新战斗中心
class NewFight
{
	private static $_teamHaveNum = array();//团队拥有的用户数量
	private static $_teamHaveDiedNum = array();//团队死亡的用户数量
	private static $_membersList = array(); //所有团队的用户对象列表

	private static $_attackSkillInfo = array();

    CONST ATTACK_ADDITIONCOEFFICIENT = 0.05;//先攻速度加成
    CONST DEFINE_ADDITIONCOEFFICIENT = 0.5;//先守速度加成

    CONST DEBUG = 1;

    private static $_fightList = array();//战斗过程
    private $_fightKeyMiss = 'miss';//战斗标识

    public static function createUserObj($userInfo) {
        $attack = Skill_Info::getReleaseProbability($userInfo['user_id'], 1);
        foreach ((array)$attack as $skillInfo) {
            $skills[$skillInfo['skill_id']] = $skillInfo['skill_level'];
            $skillRates[$skillInfo['skill_id']] = $skillInfo['probability']/100;
        }
        $defense = Skill_Info::getReleaseProbability($userInfo['user_id'], 2);
        foreach ((array)$defense as $skillInfo) {
            $skills[$skillInfo['skill_id']] = $skillInfo['skill_level'];
            $skillRates[$skillInfo['skill_id']] = $skillInfo['probability']/100;
        }
        $attrbuteArr    = User_Info::getUserInfoFightAttribute($userInfo['user_id'], TRUE);
        $user = array(
            'user_id' => $userInfo['user_id'],
            'race'       => $userInfo['race_id'],
            'user_level' => $userInfo['user_level'],
            'mark'       => $userInfo['mark'],
            'attributes' => $attrbuteArr,
            'have_skillids' => $skills,
            'skill_rates' => $skillRates,
        );
        return new NewFightMember($user);
    }

    public static function createMonsterObj($monster) {
		$skill      = Monster::getMonsterSkill($monster);
		$attribute  = Monster::getMonsterAttribute($monster);
        $monsterInfo = array(
            'monster_id' => $monster['monster_id'],
            'race'       => $monster['race_id'],
            'user_level' => $monster['level'],
            'mark'       => $monster['mark'],
            'attributes' => $attribute,
        );
		$monsterInfo = array_merge($monsterInfo,$skill);
		//print_r($monsterInfo);
        return new NewFightMember($monsterInfo);
    }

    public static function getFightResult($teams)
	{
		try {
			self::_mapTeamsAndMembersInfo($teams);
            $attackMemberKeyList = self::_getAttackMemberKeyOrderList();//获取攻击用户顺序
            while (!self::_isHaveTeamWin()) {
                if($i > 120) {
                    break;
                }
                foreach($attackMemberKeyList as $memberKey)
                {
                    if(self::_isHaveTeamWin()) {
                        break;
                    }
                    $attackMemberObj = self::_getMemberObjByMemberKey($memberKey);
                    if($attackMemberObj->isDied()) {
                        continue;
                    }
                    $sleepInfo = $attackMemberObj->getEffect('sleep');
                    if($sleepInfo[1206]['round'] >= 1) {
                        $fightInfo['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
                        $fightInfo['attack']['sleep'] = 1;
                        self::_report($fightInfo);
                        self::dealEffeckRound($attackMemberObj, 'sleep');
                        continue;
                    }
                    //获取攻击队员使用的技能
                    $attackSkillInfo = $attackMemberObj->getMemberAttackSkill();
                    NewSkill::begin($attackMemberObj, $attackSkillInfo);
                    self::$_attackSkillInfo = NewSkill::getAttackSkillConfig();
                    //判断攻击队员是否可以使用此技能
                    if(!NewSkill::skillEffectIsAttackCanUseThisSkill()) {
                        $fightInfo['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
                        $fightInfo['attack']['attack_fail'] = 1;
                        self::_report($fightInfo);
                        self::dealEffeckRound($attackMemberObj, 'attack');
                        continue;
                    }
                    self::dealEffeckRound($attackMemberObj, 'attack');
                    //获取防守队员
                    $defineMembersObj = self::_getDefineMembersObj($attackMemberObj);
                    //开始战斗
                    $fightInfo = self::_doFight($attackMemberObj, $defineMembersObj, $attackSkillInfo);
                    foreach ((array)self::_report($fightInfo) as $fight) {
                        $return['fight_procedure'][] = $fight;
                    }
                }
                $i++;
            }
            $return['use_time'] = $i;
            return $return;
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
        //消耗
        $consumes = self::$_attackSkillInfo['consume'];
        if($consumes[ConfigDefine::USER_ATTRIBUTE_BLOOD] > 0) {
            $attackMemberObj->consumeBlood($consumes[ConfigDefine::USER_ATTRIBUTE_BLOOD]);
        }
        if($consumes[ConfigDefine::USER_ATTRIBUTE_MAGIC] > 0) {
           $attackMemberObj->consumeMagic($consumes[ConfigDefine::USER_ATTRIBUTE_MAGIC]);
        }

        if($attackMemberObj->isDied())return;
        if($attackMemberObj->isEmptyMagic())return;
        //todo 攻击效果-攻方的属性加成
        foreach($defineMembersObj as $objKey => $defineMemberObj)
        {
            if(self::$_attackSkillInfo['hit_member_num'] == 0) {
                break;
            }
            $return['define'][$objKey] = array(
                'mark' => $defineMemberObj->getMark(),
            );
            //判断攻守方是否有一方处于死亡状态
            if($attackMemberObj->isDied()) break;
            if($defineMemberObj->isDied()) {
                //复活
                if(self::$_attackSkillInfo['skill_id'] == 1221) {
                    $defineMemberObj->reAlive();
                    $return['define'][$objKey]['re_alive'] = 1;
                    $return['define'][$objKey]['re_blood'] = $defineMemberObj->getCurrentBlood();
                    $return['define'][$objKey]['current_blood'] = $defineMemberObj->getCurrentBlood();
                    $return['define'][$objKey]['current_magic'] = $defineMemberObj->getCurrentMagaic();
                    $return['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
                    //todo 死亡人数减一
                    break;
                }
                continue;
            }
            NewSkill::setDefineObj($defineMemberObj);
            NewSkill::skillEffectMagicAndBlood();
            //todo 攻击效果-判断守方是否可以被此技能攻击
            if(!NewSkill::skillEffectIsThisSKillCanAttack()) {
                continue;
            }
            if(self::$_attackSkillInfo['is_have_hurt']) {
            	//计算攻击输出
            	//计算的攻击值中已减去防御属性值，并且已经乘以暴击系数，并且已计算出被动技能值，即计算出的值可以直接减血使用
            	$skillHurt = NewSkill::getAttack();
            	foreach($skillHurt as $key => $hurtInfo)
            	{
                    $return['define'][$objKey]['hurt'][$key]['is_hit'] = 1;
                    //计算是否命中
                    if(!NewSkill::skillIsHit()) {
                        $return['define'][$objKey]['hurt'][$key]['is_hit'] = 0;
                        continue;
                    }
            		$hurt = $hurtInfo['hurt'];//攻击值
                    $return['define'][$objKey]['hurt'][$key]['hurt'] = $hurt;
            		$defineSkillInfo = $defineMemberObj->getMemberDefineSkill();
                    $defineSkillId = key((array)$defineSkillInfo);

                    if($defineSkillId == 1211) {
                        NewSkill::begin($defineMemberObj, array('1201' => $defineMemberObj->getMemberLevel()));
                        NewSkill::setDefineObj($attackMemberObj);
                        $defineSkillHurt = NewSkill::getAttack();
                        $defineMakeHurt  = $defineSkillHurt[0]['hurt'];
                        NewSkill::begin($attackMemberObj, $attackMemberObj->getMemberAttackSkill());
                        NewSkill::setDefineObj($defineMemberObj);
                    }elseif ($defineSkillId == 1217) {
                        $isMagic = FALSE;
                        $hurt    = $isMagic ? ($hurt * 0.5) : $hurt * 0.7;
                    }elseif ($defineSkillId == 1223) {
                        $defineMakeHurt = $hurt;
                    }
                    if($defineSkillId > 0) {
                        $return['define'][$objKey]['hurt'][$key]['define_skill'] = $defineSkillId;
                        if($defineMakeHurt) {
                            $return['define'][$objKey]['hurt'][$key]['define_hurt'] = $defineMakeHurt;
                        }
                    }
                    //造成伤害
                    $defineMemberObj->consumeBlood($hurt);
                    if($defineMakeHurt > 0) {
                        $attackMemberObj->consumeBlood($defineMakeHurt);
                        self::dealTeamMemberDead($attackMemberObj);
                    }
            	}
                //看对方是否被打死了
                //打死了处理打死的流程
                self::dealTeamMemberDead($defineMemberObj);
            } else {
                $attribute = NewSkill::skillAttribute();
                foreach ($attribute as $attributeId => $changeValue) {
                    if($attributeId == ConfigDefine::USER_ATTRIBUTE_BLOOD) {
                        $defineMemberObj->addBlood($changeValue);
                        $return['define'][$objKey]['add_blood'] = $changeValue;
                    }
                    if($attributeId == ConfigDefine::USER_ATTRIBUTE_MAGIC) {
                        $defineMemberObj->addMagic($changeValue);
                        $return['define'][$objKey]['add_magic'] = $changeValue;
                    }
                }
            }
            self::$_attackSkillInfo['round'] = NewSkill::getSkillRound();
            $return['define'][$objKey]['current_blood'] = $defineMemberObj->getCurrentBlood();
            $return['define'][$objKey]['current_magic'] = $defineMemberObj->getCurrentMagaic();
            $return['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
            //todo 此处定义攻击法术的攻击效果累加
            self::dealEffeckRound($defineMemberObj, 'define');
            NewSkill::setSkillEffect();
            if(self::$_attackSkillInfo['hit_member_num'] >= 1) {
                self::$_attackSkillInfo['hit_member_num'] = self::$_attackSkillInfo['hit_member_num'] - 1;
            }
        }
        return $return;
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
        $returnMemberObj      = array();
        foreach($defineMemberKeyList as $memberKey)
        {
            $memberObj = self::_getMemberObjByMemberKey($memberKey);
            if(in_array(0, (array)self::$_attackSkillInfo['target']))
            {
                //允许对己方使用的
                if(self::$_attackSkillInfo['hit_me'] == 1)
                {
                    if($attackMemberObj == $memberObj)
                    {
                        $returnMemberObj[$memberKey] = $memberObj;
                    }
                }elseif(self::$_attackSkillInfo['hit_me'] == 0){
                    if($attackMemberObj != $memberObj)
                    {
                        if($attackMemberObj->getMemberTeamKey() == $memberObj->getMemberTeamKey())
                        {
                            $returnMemberObj[$memberKey] = $memberObj;
                        }
                    }
                }
//            }elseif(in_array(1, (array)self::$_attackSkillInfo['target'])){
            }else {
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
		foreach ((array)self::$_teamHaveNum as $teamKey => $teamHaveNum)
		{
			if($teamHaveNum == self::$_teamHaveDiedNum[$teamKey])
			{
				return TRUE;
			}
		}
		return FALSE;
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
		NewSkill::debug();

		echo "DEBUG结束";
	}

    private static function _report($fightInfo) {
        $return = array(
            'attack' => array(
                'blood' => intval($fightInfo['attack']['current_blood']),
                'magic' => intval($fightInfo['attack']['current_magic']),
                'mark'  => $fightInfo['attack']['mark'],
            ),
        );
        $processBegin = 'attack';
        if($fightInfo['attack']['sleep'] == 1) {
            $return['process'] = $processBegin.'|'.ConfigDefine::CHUYU.'|'.ConfigDefine::XURUO.'|'.ConfigDefine::ZHUANGTAI.'|'.ConfigDefine::XIXIU.'|1|'.ConfigDefine::HUIHE;
            $fightList[] = $return;
        }elseif($fightInfo['attack']['attack_fail'] == 1) {
            $return['process'] = $processBegin.'|'.ConfigDefine::SHIYONG.'|'.$fightInfo['attack']['skill_id'].'|'.ConfigDefine::GONGJI.'|'.ConfigDefine::MISS;
            $fightList[] = $return;
        } else {
            foreach ((array)$fightInfo['define'] as $defineKey => $define) {
                $return['defense']['blood'] = intval($define['current_blood']);
                $return['defense']['magic'] = intval($define['current_magic']);
                $return['defense']['mark']  = $define['mark'];
                $process1 = $processBegin.'|'.ConfigDefine::VS.'|defense|'.ConfigDefine::SHIYONG.'|'.$fightInfo['attack']['skill_id'];
                if(isset($define['hurt'])) {
                    $hurtNum = count((array)$define['hurt']);
                    foreach ((array)$define['hurt'] as $k => $hurt) {
                        if($hurtNum == 1) {
                            $process[$defineKey][] = $process1.'|'.self::getCode($hurt, $fightInfo['attack']['mark'], $define['mark']);
                        }  else {
                            if($k == 0) {
                                $process[$defineKey][] = $process1;
                            }
                            $process[$defineKey][] = ConfigDefine::DI.'|N:'.($k + 1).'|'.ConfigDefine::GONGJI.'|'.self::getCode($hurt, $fightInfo['attack']['mark'], $define['mark']);
                        }
                    }
                } else {
                    switch ($fightInfo['attack']['skill_id']) {
                        case 1207:
                            $process1 .= '|'.ConfigDefine::JINENG.'|'.ConfigDefine::MINGZHONG.'|defense|'.ConfigDefine::SHIYONG.'|'.ConfigDefine::WULI.'|'.ConfigDefine::GONGJI.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                            break;
                        case  1208:
                            $process1 .= '|'.ConfigDefine::JINENG.'|'.ConfigDefine::MINGZHONG.'|defense|'.ConfigDefine::SHIYONG.'|'.ConfigDefine::FASHU.'|'.ConfigDefine::GONGJI.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                            break;
                        case 1209:
                            $process1 .= '|defense|'.ConfigDefine::ZENGJIA.'|M:'.intval($define['add_magic']).'|'.ConfigDefine::LAN;
                            break;
                        case 1210:
                        case 1215:
                            $process1 .= '|defense|'.ConfigDefine::ZENGJIA.'|B:'.intval($define['add_blood']).ConfigDefine::XUE;
                            break;
                        case 1214:
                            $process1 .= '|defense|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                            break;
                        case 1216:
                            $process1 .= '|defense|'.ConfigDefine::ZENGJIA.'|'.ConfigDefine::SHANGHAISHUXING.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                            break;
                        case 1220:
                            $process1 .= '|'.ConfigDefine::JINENG.'|'.ConfigDefine::MINGZHONG.'|'.ConfigDefine::FENGYIN.'|'.ConfigDefine::JIECHU;
                            break;
                        case 1221:
                            $process1 .= '|defense|'.ConfigDefine::FUHUO.'|'.ConfigDefine::ZENGJIA.'|B:'.intval($define['re_blood']);
                            break;
                        case 1222:
                            $process1 .= '|defense|'.ConfigDefine::ZENGJIA.'|'.ConfigDefine::LINGLI.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                            break;
                    }
                    $process[$defineKey][] = $process1;
                }
                $return['process'] = $process[$defineKey];
                $fightList[] = $return;
            }
        }
        return $fightList;
    }

    public static function getCode($hurt, $attackMark, $defineMark) {
        if($hurt['is_hit']) {
            if($hurt['define_skill'] == 1211) {
                //造成了 xx 伤害 防御者  使用了 反击 对 攻击者 造成了 xx 伤害
                $return = ConfigDefine::ZAOCHENG.'|H:'.(int)$hurt['hurt'].'|defense|'.ConfigDefine::SHIYONG.'|'.$hurt['define_skill'].'|'.ConfigDefine::VS.'|attack|'.ConfigDefine::ZAOCHENG.'|H:'.(int)$hurt['define_hurt'].'|'.ConfigDefine::SHANGHAI;
            }elseif ($hurt['define_skill'] == 1217) {
                //防御者 使用了 招架 造成了 xx 伤害
                $return = 'defense|'.ConfigDefine::SHIYONG.'|'.$hurt['define_skill'].'|'.ConfigDefine::ZAOCHENG.'|H:'.(int)$hurt['hurt'].'|'.ConfigDefine::SHANGHAI;
            }elseif ($hurt['define_skill'] == 1223) {
                //造成了100点伤害，Y使用了反震，对A造成了50点伤害。
                $return = ConfigDefine::ZAOCHENG.'|H:'.(int)$hurt['hurt'].'|defense|'.ConfigDefine::SHIYONG.'|'.$hurt['define_skill'].'|'.ConfigDefine::VS.'|attack|'.ConfigDefine::ZAOCHENG.'|H:'.(int)$hurt['define_hurt'].'|'.ConfigDefine::SHANGHAI;
            }  else {
                $return = ConfigDefine::ZAOCHENG.'|H:'.(int)$hurt['hurt'].'|'.ConfigDefine::SHANGHAI;
            }
        }  else {
            //躲避 成功 攻击 miss
            $return = ConfigDefine::DUOBI.'|'.ConfigDefine::CHENGGONG.'|'.ConfigDefine::GONGJI.'|'.ConfigDefine::MISS;
        }
        return $return;
    }

    private static function createAttackInfo(NewFightMember $attackMemberObj, $skillInfo) {
        $attackInfo['mark']       = $attackMemberObj->getMark();
        $attackInfo['current_blood'] = $attackMemberObj->getCurrentBlood();
        $attackInfo['current_magic'] = $attackMemberObj->getCurrentMagaic();
        $attackInfo['skill_id']      = self::$_attackSkillInfo['skill_id'];
        $attackInfo['skill_level']      = self::$_attackSkillInfo['skill_level'];
        $attackInfo['round']        = self::$_attackSkillInfo['round'];
        return $attackInfo;
    }

    private static function dealTeamMemberDead(NewFightMember $memberObj) {
        if($memberObj->isDied()) {
            return self::teamDiedMember($memberObj->getMemberTeamKey());
        }
        return FALSE;
    }

    private static function dealEffeckRound(NewFightMember $obj, $flag) {
        $array = $obj->getEffect($flag);
        if(is_array($array) && count($array)) {
            foreach ($array as $skillId => $v) {
                $round = $v['round'] - 1;
                if($round <= 0) {
                    $obj->delEffectByFlag($flag, $skillId);
                }  else {
                    $v['round'] = $round;
                    $obj->setEffect($flag, $skillId, $v);
                }
            }
        }
    }

    public static function getPeopleFightInfo(NewFightMember $user, $userInfo = array()) {
        return array(
            'user_id'   => $user->getMemberId(),
            'user_name' => $userInfo['user_name'],
            'level'     => $userInfo['user_level'],
            'blood'     => intval($user->getCurrentBlood()),
            'magic'     => intval($user->getCurrentMagaic()),
        );
    }

    public static function getMonsterFightInfo(NewFightMember $monster, $monsterInfo = array()) {
        return array(
            'monster_id' => $monsterInfo['monster_id'],
            'level' => $monsterInfo['level'],
            'blood' => intval($monster->getCurrentBlood()),
            'magic' => intval($monster->getCurrentMagaic()),
            'prefix' => $monsterInfo['prefix'],
            'suffix' => $monsterInfo['suffix'],
        );
    }

    public static function isTeamAlive($teamObjs) {
        foreach ((array)$teamObjs as $memberObj) {
            if($memberObj->isAlive()) {
                return true;
            }
        }
        return FALSE;
    }
}
