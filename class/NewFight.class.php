<?php
//新战斗中心
class NewFight
{
	private static $_teamHaveNum = array();//团队拥有的用户数量
	private static $_teamHaveDiedNum = array();//团队死亡的用户数量
	private static $_membersList = array(); //所有团队的用户对象列表
    private static $memberObjsWithTeam = array();

    private static $_attackSkillInfo = array();

    CONST ATTACK_ADDITIONCOEFFICIENT = 0.05;//先攻速度加成
    CONST DEFINE_ADDITIONCOEFFICIENT = 0.5;//先守速度加成

    CONST DEBUG = 1;

    private static $_fightList = array();//战斗过程
    private $_fightKeyMiss = 'miss';//战斗标识

    public static function createUserObj($userInfo) {
        $newskill = NewSkillStudy::ReleaseProbability($userInfo['user_id']);
        foreach ((array)$newskill as $action  =>  $skillInfos) {
            foreach ((array)$skillInfos as $skillInfo) {
                $skills[$skillInfo['skill_id']] = $skillInfo['skill_level'];
                $skillRates[$action][$skillInfo['skill_id']] = $skillInfo['probability']/100;
            }
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
        return new NewFightMember($monsterInfo);
    }

    public static function getFightResult($teams)
	{
		try {
			self::_mapTeamsAndMembersInfo($teams);
            $attackMemberKeyList = self::_getAttackMemberKeyOrderList();//获取攻击用户顺序
            $i = 0;
            while (!self::_isHaveTeamWin()) {
                if($i > 120) {
                    break;
                }
                $key = is_array($return['fight_procedure']) ? count($return['fight_procedure']) : 0;
                foreach($attackMemberKeyList as $memberKey)
                {
                    if(self::_isHaveTeamWin()) {
                        break;
                    }
                    $attackMemberObj = self::_getMemberObjByMemberKey($memberKey);
                    if($attackMemberObj->isDied()) {
                        continue;
                    }
                    $attackMemberObj->setCurrentRound($i+1);
                    $sleepInfo = $attackMemberObj->getEffect('sleep');
                    if($sleepInfo[1206]['round'] >= 1) {
                        $fightInfo['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
                        $fightInfo['attack']['sleep'] = 1;
                        $return['fight_procedure'][] = self::_report($fightInfo);
                        self::dealEffeckRound($attackMemberObj, 'sleep');
                        continue;
                    }
                    //获取攻击队员使用的技能
                    $attackSkillInfo = $attackMemberObj->getMemberAttackSkill();
                    NewSkill::begin($attackMemberObj, $attackSkillInfo);
                    self::$_attackSkillInfo = NewSkill::getAttackSkillConfig();
                    NewSkill::skillEffectMagicAndBlood();
                    if($attackMemberObj->isDied()) {
                        self::dealTeamMemberDead($attackMemberObj);
                        $fightInfo['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
                        $fightInfo['attack']['dead'] = 1;
                        $return['fight_procedure'][] = self::_report($fightInfo);
                        self::dealEffeckAttackAndDefenseRound($attackMemberObj);
                        continue;
                    }
                    //判断攻击队员是否可以使用此技能
                    if(!NewSkill::skillEffectIsAttackCanUseThisSkill()) {
                        $fightInfo['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
                        $fightInfo['attack']['attack_fail'] = 1;
                        $return['fight_procedure'][] = self::_report($fightInfo);
                        self::dealEffeckAttackAndDefenseRound($attackMemberObj);
                        continue;
                    }
                    //获取防守队员
                    $defineMembersObj = self::_getDefineMembersObj($attackMemberObj);
                    if(!(is_array($defineMembersObj) && count($defineMembersObj))) {
                        $fightInfo['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
                        $fightInfo['attack']['attack_fail'] = 1;
                        $return['fight_procedure'][] = self::_report($fightInfo);
                        self::dealEffeckAttackAndDefenseRound($attackMemberObj);
                        continue;
                    }
                    //开始战斗
                    $fightInfo = self::_doFight($attackMemberObj, $defineMembersObj, $attackSkillInfo, $i+1);
                    self::dealEffeckAttackAndDefenseRound($attackMemberObj);
                    $return['fight_procedure'][] = self::_report($fightInfo);
                    NewSkill::end();
                }
                $huihe = ConfigDefine::DI.'|R:'.($i+1).'|'.  ConfigDefine::HUIHE;
                array_unshift($return['fight_procedure'][$key]['process'], $huihe);
                $i++;
            }
            $return['use_time'] = $i;
//            $logContent = 'time:'.date('Y-m-d H:i:s').'-procedure:'.json_encode($return['fight_procedure']);
//            sae_set_display_errors(false);//关闭信息输出
//            sae_debug($logContent);
//            sae_debug('--------------------------------------------');//记录日志
//            sae_set_display_errors(true);
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
    private static function _doFight($attackMemberObj, $defineMembersObj, $attackSkillInfo, $roundNum)
    {
        //消耗
        $consumes = self::$_attackSkillInfo['consume'];
        $attackCurrentBlood = $attackMemberObj->getCurrentBlood();
        $attackCurrentMagic = $attackMemberObj->getCurrentMagaic();

        if($consumes[ConfigDefine::USER_ATTRIBUTE_MAGIC] > 0) {
            if($attackCurrentMagic - $consumes[ConfigDefine::USER_ATTRIBUTE_MAGIC] < 0) {
                $return['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
                $return['attack']['can_not']      = 1;
                $return['attack']['need_magic']   = $consumes[ConfigDefine::USER_ATTRIBUTE_MAGIC];
                return $return;
            }
        }

        if($consumes[ConfigDefine::USER_ATTRIBUTE_BLOOD] > 0 && $attackCurrentBlood > $consumes[ConfigDefine::USER_ATTRIBUTE_BLOOD]) {
            $attackMemberObj->consumeBlood($consumes[ConfigDefine::USER_ATTRIBUTE_BLOOD]);
        }
        if($consumes[ConfigDefine::USER_ATTRIBUTE_MAGIC] > 0 && $attackCurrentMagic > $consumes[ConfigDefine::USER_ATTRIBUTE_MAGIC]) {
           $attackMemberObj->consumeMagic($consumes[ConfigDefine::USER_ATTRIBUTE_MAGIC]);
        }
        //todo 攻击效果-攻方的属性加成
        foreach($defineMembersObj as $objKey => $defineMemberObj)
        {
            if(self::$_attackSkillInfo['hit_member_num'] <= 0) {
                break;
            }
            $return['define'][$objKey] = array(
                'mark' => $defineMemberObj->getMark(),
            );
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
                    self::teamReviveMember($teamKey);
                    break;
                }
                continue;
            }
            NewSkill::setDefineObj($defineMemberObj);
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
            		$defineSkillInfo = $defineMemberObj->getMemberDefineSkill();
                    $defineSkillId = key((array)$defineSkillInfo);
                    if(in_array($defineSkillId, array(NewSkill::SKILL_HUMAN_FY_FJ, NewSkill::SKILL_DEMON_FY_FZ))) {
                        //防御的两个技能，前置条件是物理攻击生效
                        $physicSkillIds   = NewSkill::getPhysicsSkills();
                        $isPhysicId       = in_array(self::$_attackSkillInfo['skill_id'], $physicSkillIds);
                        if(!$isPhysicId) {
                            $defineSkillId   = 0;
                            $defineSkillInfo = array();
                        }
                    }
                    if($defineSkillId == 1211) {
                        NewSkill::begin($defineMemberObj, array('1201' => $defineMemberObj->getMemberLevel()));
                        NewSkill::setDefineObj($attackMemberObj);
                        $defineSkillHurt = NewSkill::getAttack();
                        $defineMakeHurt  = $defineSkillHurt[0]['hurt'];
                        NewSkill::begin($attackMemberObj, $attackSkillInfo);
                        NewSkill::setDefineObj($defineMemberObj);
                    }elseif ($defineSkillId == 1217) {
                        $physicSkills = NewSkill::getPhysicsSkills();
                        $isPhysic = in_array(self::$_attackSkillInfo['skill_id'], $physicSkills);
                        $hurt    = $isPhysic ? ($hurt * 0.7) : $hurt * 0.5;
                        $hurt    = $hurt > 1 ? $hurt : 1;
                    }elseif ($defineSkillId == 1223) {
                        $defineMakeHurt = $hurt;
                    }
                    if($defineSkillId > 0) {
                        $return['define'][$objKey]['hurt'][$key]['define_skill'] = $defineSkillId;
                        if($defineMakeHurt) {
                            $return['define'][$objKey]['hurt'][$key]['define_hurt'] = $defineMakeHurt;
                        }
                    }
                    $return['define'][$objKey]['hurt'][$key]['hurt'] = $hurt;
                    $return['define'][$objKey]['hurt'][$key]['is_bj'] = $hurtInfo['addition'] > 1 ? 1 : 0;
                    //造成伤害
                    $defineMemberObj->consumeBlood($hurt);
                    if($defineMakeHurt > 0) {
                        $attackMemberObj->consumeBlood($defineMakeHurt);
                        self::dealTeamMemberDead($attackMemberObj);
                    }
                    if($defineMemberObj->isDied()) {
                        break;
                    }
            	}
                //看对方是否被打死了
                //打死了处理打死的流程
                self::dealTeamMemberDead($defineMemberObj);
            } else {
                $attribute = NewSkill::skillAttribute();
                if($attribute[ConfigDefine::USER_ATTRIBUTE_BLOOD] > 0) {
                    $defineMemberObj->addBlood($attribute[ConfigDefine::USER_ATTRIBUTE_BLOOD]);
                    $return['define'][$objKey]['add_blood'] = $attribute[ConfigDefine::USER_ATTRIBUTE_BLOOD];
                }
                if($attribute[ConfigDefine::USER_ATTRIBUTE_MAGIC] > 0) {
                    $defineMemberObj->addBlood($attribute[ConfigDefine::USER_ATTRIBUTE_MAGIC]);
                    $return['define'][$objKey]['add_blood'] = $attribute[ConfigDefine::USER_ATTRIBUTE_MAGIC];
                }
                $return['define'][$objKey]['is_bj'] = $attribute['addition'] > 1 ? 1 : 0;
            }
            self::$_attackSkillInfo['round'] = NewSkill::getSkillRound();
            $return['define'][$objKey]['current_blood'] = $defineMemberObj->getCurrentBlood();
            $return['define'][$objKey]['current_magic'] = $defineMemberObj->getCurrentMagaic();
            $return['attack'] = self::createAttackInfo($attackMemberObj, self::$_attackSkillInfo);
            $return['define'][$objKey]['effect'] = $defineMemberObj->getEffect('define');

            if($defineMemberObj->getCurrentRound != $roundNum) {
                $defineMemberObj->setCurrentRound($roundNum);
                self::dealEffeckAttackAndDefenseRound($defineMemberObj);
            }

            NewSkill::setSkillEffect();
            self::$_attackSkillInfo['hit_member_num']--;
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
                if($attackMemberObj->getMemberTeamKey() == $memberObj->getMemberTeamKey()) {
                    if(self::$_attackSkillInfo['hit_me']) {
                        $returnMemberObj[$memberKey] = $memberObj;
                    } else {
                        if($attackMemberObj != $memberObj) {
                            $returnMemberObj[$memberKey] = $memberObj;
                        }
                    }
                }
//            }elseif(in_array(1, (array)self::$_attackSkillInfo['target'])){
            } else {
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
        foreach ((array)  self::$memberObjsWithTeam as $teamKey => $objs) {
            if(is_array($objs) && count($objs)) {
                $thisObjIsAllDead = TRUE;
                foreach ($objs as $obj) {
                    if($obj->isAlive()) {
                        $thisObjIsAllDead = FALSE;
                        break;
                    }
                }
                if($thisObjIsAllDead == TRUE) {
                    return TRUE;
                }
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
        self::$memberObjsWithTeam = $teams;
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

    private static function _report($fightInfo) {
        $attackMark = $fightInfo['attack']['mark'];
        $return = array(
            $attackMark => array(
                'blood' => intval($fightInfo['attack']['current_blood']),
                'magic' => intval($fightInfo['attack']['current_magic']),
                'mark'  => $attackMark,
            ),
        );
        $processBegin = $attackMark;

        if(is_array($fightInfo['attack']['effect']) && count($fightInfo['attack']['effect'])) {
            foreach ($fightInfo['attack']['effect'] as $effect) {
                if($effect['skill_id'] == 1206) {
                    $effect['skill_id'] = '1206|'.ConfigDefine::XURUO;
                }
                $process[] = $processBegin.'|'.ConfigDefine::CHUYU.'|'.$effect['skill_id'].'|'.ConfigDefine::ZHUANGTAI.'|'.ConfigDefine::CHIXU.'|R:'.$effect['round'].'|'.ConfigDefine::HUIHE;
            }
        }
        if($fightInfo['attack']['can_not'] == 1) {
            $process[] = $processBegin.'|'.ConfigDefine::LAN.'|'.ConfigDefine::DIYU.'|M:'.$fightInfo['attack']['need_magic'].'|'.ConfigDefine::WUFA.'|'.ConfigDefine::SHIYONG.'|'.$fightInfo['attack']['skill_id'].'|'.ConfigDefine::JINENG;
            if($fightInfo['attack']['current_blood'] <= 0) {
                $process[] = $processBegin.'|'.ConfigDefine::SIWANG;
            }
        }elseif($fightInfo['attack']['sleep'] == 1) {
            $process[] = $processBegin.'|'.ConfigDefine::CHUYU.'|1206|'.ConfigDefine::XURUO.'|'.ConfigDefine::ZHUANGTAI.'|'.ConfigDefine::XIXIU.'|1|'.ConfigDefine::HUIHE;
            if($fightInfo['attack']['current_blood'] <= 0) {
                $process[] = $processBegin.'|'.ConfigDefine::SIWANG;
            }
        }elseif($fightInfo['attack']['attack_fail'] == 1) {
            $process[] = $processBegin.'|'.ConfigDefine::WUFA.'|'.ConfigDefine::SHIYONG.'|'.$fightInfo['attack']['skill_id'].'|'.ConfigDefine::JINENG;
            if($fightInfo['attack']['current_blood'] <= 0) {
                $process[] = $processBegin.'|'.ConfigDefine::SIWANG;
            }
        }elseif($fightInfo['attack']['dead'] == 1) {
            $process[] = $processBegin.'|'.ConfigDefine::CHUYU.'|'.ConfigDefine::XURUO.'|'.ConfigDefine::ZHUANGTAI;
            if($fightInfo['attack']['current_blood'] <= 0) {
                $process[] = $processBegin.'|'.ConfigDefine::SIWANG;
            }
        }else {
            $fightInfo['define'] = array_values((array)$fightInfo['define']);
            foreach ((array)$fightInfo['define'] as $defineKey => $define) {
                $defineMark = $define['mark'];
                $return[$defineMark]['blood'] = intval($define['current_blood']);
                $return[$defineMark]['magic'] = intval($define['current_magic']);
                $return[$defineMark]['mark']  = $define['mark'];
                $attackSkillId = $fightInfo['attack']['skill_id'];

                if(in_array($attackSkillId, array(1213,1215,1216,1219,1222) )) {
                    if($defineKey == 0) {
                        $process[] = $processBegin.'|'.ConfigDefine::SHIYONG.'|'.$attackSkillId;
                    }
                }  else {
                    $process[] = $processBegin.'|'.ConfigDefine::VS.'|'.$defineMark.'|'.ConfigDefine::SHIYONG.'|'.$attackSkillId;
                }
                switch ($attackSkillId) {
                    case 1201:
                    case 1212:
                    case 1218:
                        $process[] = self::getCode($define['hurt'][0], $attackMark, $defineMark);;
                        break;
                    case 1206:
                        foreach ((array)$define['hurt'] as $hurtKey => $hurt) {
                            $process[] = ConfigDefine::DI.'|N'.($hurtKey + 1).'|'.ConfigDefine::GONGJI.'|'.self::getCode($hurt, $attackMark, $defineMark);
                        }
                        break;
                    case 1207:
                        $process[] = ConfigDefine::JINENG.'|'.ConfigDefine::MINGZHONG.'|'.$defineMark.'|'.ConfigDefine::WUFA.'|'.ConfigDefine::SHIYONG.'|'.ConfigDefine::WULI.'|'.ConfigDefine::GONGJI.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                        break;
                    case 1208:
                        $process[] = ConfigDefine::JINENG.'|'.ConfigDefine::MINGZHONG.'|'.$defineMark.'|'.ConfigDefine::WUFA.'|'.ConfigDefine::SHIYONG.'|'.ConfigDefine::FASHU.'|'.ConfigDefine::GONGJI.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                        break;
                    case 1209:
                        $process[] = $defineMark.'|'.ConfigDefine::ZENGJIA.'|M:'.intval($define['add_magic']).'|'.ConfigDefine::LAN;;
                        break;
                    case 1210:
                        $process[] = $defineMark.'|'.ConfigDefine::ZENGJIA.($define['is_bj']==1 ? '|B1:' : '|B:').intval($define['add_blood']).'|'.ConfigDefine::XUE;
                        break;
                    case 1213:
                        $process[] = ConfigDefine::VS.'|'.$defineMark.'|'.self::getCode($define['hurt'][0], $attackMark, $defineMark);
                        break;
                    case 1214:
                        $process[] = ConfigDefine::JINENG.'|'.  ConfigDefine::MINGZHONG.'|'.$defineMark.'|'.ConfigDefine::CHUYU.'|'.ConfigDefine::XURUO.'|'.ConfigDefine::ZHUANGTAI.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                        break;
                    case 1215:
                        $process[] = ConfigDefine::VS.'|'.$defineMark.'|'.ConfigDefine::ZENGJIA.($define['is_bj']==1 ? '|B1:' : '|B:').intval($define['add_blood']).'|'.ConfigDefine::XUE;
                        break;
                    case 1216:
                        $process[] = ConfigDefine::VS.'|'.$defineMark.'|'.ConfigDefine::ZENGJIA.'|'.ConfigDefine::SHANGHAISHUXING.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                        break;
                    case 1219:
                        $process[] = ConfigDefine::VS.'|'.$defineMark.'|'.self::getCode($define['hurt'][0], $attackMark, $defineMark);
                        break;
                    case 1220:
                        $process[] = ConfigDefine::JINENG.'|'.ConfigDefine::MINGZHONG.'|'.ConfigDefine::FENGYIN.'|'.ConfigDefine::JIECHU;
                        break;
                    case 1221:
                        $process[] = $defineMark.'|'.ConfigDefine::FUHUO.'|'.ConfigDefine::ZENGJIA.'|B:'.intval($define['re_blood']);
                        break;
                    case 1222:
                        $process[] = $defineMark.'|'.ConfigDefine::ZENGJIA.'|'.ConfigDefine::LINGLI.'|'.ConfigDefine::CHIXU.'|R:'.$fightInfo['attack']['round'].'|'.ConfigDefine::HUIHE;
                        break;
                }
                if($define['current_blood'] <= 0) {
                    $process[] = $defineMark.'|'.ConfigDefine::SIWANG;
                }
                if($fightInfo['attack']['current_blood'] <= 0) {
                    $process[] = $processBegin.'|'.ConfigDefine::SIWANG;
                }
            }
        }
        $return['process'] = $process;
        return $return;
    }

    public static function getCode($hurt, $attackMark, $defineMark) {
        if($hurt['is_hit']) {
            if($hurt['define_skill'] == 1211) {
                //造成了 xx 伤害 防御者  使用了 反击 对 攻击者 造成了 xx 伤害
                $return = ConfigDefine::ZAOCHENG.($hurt['is_bj']==1 ? '|HB:' : '|H:').(int)$hurt['hurt'].'|'.$defineMark.'|'.ConfigDefine::SHIYONG.'|'.$hurt['define_skill'].'|'.ConfigDefine::VS.'|'.$attackMark.'|'.ConfigDefine::ZAOCHENG.'|H:'.(int)$hurt['define_hurt'].'|'.ConfigDefine::SHANGHAI;
            }elseif ($hurt['define_skill'] == 1217) {
                //防御者 使用了 招架 造成了 xx 伤害
                $return = $defineMark.'|'.ConfigDefine::SHIYONG.'|'.$hurt['define_skill'].'|'.ConfigDefine::ZAOCHENG.($hurt['is_bj']==1 ? '|HB:' : '|H:').(int)$hurt['hurt'].'|'.ConfigDefine::SHANGHAI;
            }elseif ($hurt['define_skill'] == 1223) {
                //造成了100点伤害，Y使用了反震，对A造成了50点伤害。
                $return = ConfigDefine::ZAOCHENG.($hurt['is_bj']==1 ? '|HB:' : '|H:').(int)$hurt['hurt'].'|'.$defineMark.'|'.ConfigDefine::SHIYONG.'|'.$hurt['define_skill'].'|'.ConfigDefine::VS.'|'.$attackMark.'|'.ConfigDefine::ZAOCHENG.'|H:'.(int)$hurt['define_hurt'].'|'.ConfigDefine::SHANGHAI;
            }  else {
                $return = ConfigDefine::ZAOCHENG.($hurt['is_bj']==1 ? '|HB:' : '|H:').(int)$hurt['hurt'].'|'.ConfigDefine::SHANGHAI;
            }
        } else {
            //躲避 成功 攻击 miss
            $return = ConfigDefine::DUOBI.'|'.ConfigDefine::CHENGGONG.'|'.ConfigDefine::GONGJI.'|'.ConfigDefine::MISS;
        }
        return $return;
    }

    private static function createAttackInfo(NewFightMember $attackMemberObj, $skillInfo) {
        $attackInfo['mark']          = $attackMemberObj->getMark();
        $attackInfo['current_blood'] = $attackMemberObj->getCurrentBlood();
        $attackInfo['current_magic'] = $attackMemberObj->getCurrentMagaic();
        $attackInfo['skill_id']      = self::$_attackSkillInfo['skill_id'];
        $attackInfo['skill_level']   = self::$_attackSkillInfo['skill_level'];
        $attackInfo['round']         = self::$_attackSkillInfo['round'];
        $attackInfo['effect']        = $attackMemberObj->getEffect('attack');
        $defineEffect = $attackMemberObj->getEffect('define');
        if(is_array($defineEffect) && count($defineEffect)) {
            foreach ($defineEffect as $define) {
                if(!isset($attackInfo['effect'][$define['skill_id']])) {
                    $attackInfo['effect'][$define['skill_id']] = $define;
                }
            }
        }
        return $attackInfo;
    }

    private static function dealTeamMemberDead(NewFightMember $memberObj) {
        if($memberObj->isDied()) {
            return self::teamDiedMember($memberObj->getMemberTeamKey());
        }
        return FALSE;
    }

    private static function dealTeamMemberRealive(NewFightMember $memberObj) {
        $teamKey = $memberObj->getMemberTeamKey();
        if(self::$_teamHaveDiedNum[$teamKey] > 0) {
            self::teamReviveMember($teamKey);
        }
        return;
    }

    private static function dealEffeckAttackAndDefenseRound(NewFightMember $obj) {
        self::dealEffeckRound($obj, 'attack');
        self::dealEffeckRound($obj, 'define');
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
            'id'        => $userInfo['mark'],
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
            'id'        => $monsterInfo['mark'],
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
