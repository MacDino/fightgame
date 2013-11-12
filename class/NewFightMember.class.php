<?php
class NewFightMember
{
	private $_currentBlood = 0;//当前队员的血量
	private $_currentMagic = 0;//当前队员的蓝量
	private $_currentSkillId = 0;//当前队员所使用的技能
	private $_memberAttribute = array();//当前队员的属性
	private $_memberLevel = 0;//当前队员的级别
	private $_memberId = 0;//当前队员的级别

	private $_currentSkillEffect = array();//当前队员所受技能的影响效果
	private $_memberSkill = array();//当前队员所拥有的技能
    private $_memberSkillRate = array(); //当前队员所拥有的技能的释放概率
    private $_memberRace = NULL;//当前队员的种族
	private $_memberTeamKey = NULL;//当前队员的队伍标识


    private $_skillEffectSleepRound = 0;//技能效果-休息回合
    private $_skillEffectAttribute = array();//技能效果-属性加成
    private $_skillEffectNotCanUseSkill = array();//技能效果-无法使用的技能
    private $_skillEffectNotCanAttackSkill = array();//技能效果-无法被攻攻到的技能

    /**
     array(
        'attribute' =>
            array(
                array('round' => 1, 'value' => array(ConfigDeifine::USER_ATTRIBUTE_DEFENSE => 0.8, )),
                array('round' => 1, 'value' => array(ConfigDeifine::USER_ATTRIBUTE_DEFENSE => 0.8, )),
            ),
        'not_can_use_skill' =>
            array(
                array('round' => 1, 'value' => array(1021,1023,124)),
                array('round' => 1, 'value' => array(1021,1023,124)),
            ),
        'not_can_attack_skill' =>
            array(
                array('round' => 1, 'value')
            ),
     );

     not_can_use_skill[] => array('round' => 1, 'value' => array(1202,1203,1204,1205),)
     not_can_use_skill[] => array('round' => 1, 'value' => array(1202,1203,1204,1205),)

     attribute[] = array('round' => 'value' => array(ConfigDeifine::USER_ATTRIBUTE_DEFENSE => 0.8, ))
     attribute[] = array('round' => 'value' => array(ConfigDeifine::USER_ATTRIBUTE_DEFENSE => 0.8, ))

     not_can_attack_skill[] => array('round' => 1, 'value' => array(1202,1203,1204,1205),)
     not_can_attack_skill[] => array('round' => 1, 'value' => array(1202,1203,1204,1205),)

     attack_skill[] = array(skill_id => round, )


     */

	//初始化
	public function __construct($memberInfo)
	{
		$this->_currentBlood = $memberInfo['attributes'][ConfigDefine::USER_ATTRIBUTE_BLOOD];
		$this->_currentMagic = $memberInfo['attributes'][ConfigDefine::USER_ATTRIBUTE_MAGIC];
		$this->_memberRace = isset($memberInfo['race'])?$memberInfo['race']:User_Race::RACE_HUMAN;
		$this->_memberAttribute = $memberInfo['attributes'];
		$this->_memberLevel = $memberInfo['user_level'];
		$this->_memberId = $memberInfo['user_id'];
		$this->_setAttackSkill($memberInfo['have_skillids']);
		$this->_setDefineSkill($memberInfo['have_skillids']);
		$this->_setPassiveSkill($memberInfo['have_skillids']);
        $this->_setAttackSkillRate($memberInfo['skill_rates']['attack']);
        $this->_setDefineSkillRate($memberInfo['skill_rates']['define']);
	}

    //根据技能的释放概率进行技能的选择
    //如果没有获取到相关的技能的话，返回普通攻击
	public function getMemberAttackSkill()
	{
		if(is_array($this->_memberSkillRate['attack']) && count($this->_memberSkillRate['attack'])) {
            $skillId = PerRand::getRandResultKey($this->_memberSkillRate['attack']);
        }
        $attackList = $this->_memberSkill['attack'];
        if(isset($attackList[$skillId])) {
            $return[$skillId] = $attackList[$skillId];
        }  else {
            $return[1201] = $this->_memberLevel;
        }
        return $return;
	}

	public function getMemberDefineSkill()
	{
		if(is_array($this->_memberSkillRate['define']) && count($this->_memberSkillRate['define'])) {
            $skillId = PerRand::getRandResultKey($this->_memberSkillRate['define']);
        }
        $defineList = $this->_memberSkill['define'];
        if(isset($defineList[$skillId])) {
            $return[$skillId] = $defineList[$skillId];
        }
        return $return;
	}

    public function isMemberSleep()
    {
        if($this->_memberSleepRound > 0)
        {
            $this->_skillEffectSleepRound -= 1;
            return TRUE;
        }
        return FALSE;

    }
	//设置用户可用的攻击技能
	private function _setAttackSkill($userHaveSkills)
	{
		$attackSkillList = NewSkill::getAttackSkillList($this->_memberRace);
		foreach ($attackSkillList as $attackSkillId)
		{
			if(isset($userHaveSkills[$attackSkillId]))
			{
				$memberHaveSkill[$attackSkillId] = $userHaveSkills[$attackSkillId];
			}
		}
		$this->_memberSkill['attack'] = $memberHaveSkill;
	}
	//设置用户可用的防御技能
	private function _setDefineSkill($userHaveSkills)
	{
		$definekSkillList = NewSkill::getDefineSkillList($this->_memberRace);
		foreach ($definekSkillList as $defineSkillId)
		{
			if(isset($userHaveSkills[$defineSkillId]))
			{
				$memberHaveSkill[$defineSkillId] = $userHaveSkills[$defineSkillId];
			}
		}
		$this->_memberSkill['define'] = $memberHaveSkill;
	}
	//设置用户可用的被动技能
	private function _setPassiveSkill($userHaveSkills)
	{
		$passiveSkillList = NewSkill::getPassiveSkillList();
		foreach ($passiveSkillList as $passiveSkillId)
		{
			if(isset($userHaveSkills[$passiveSkillId]))
			{
				$memberHaveSkill[$passiveSkillId] = $userHaveSkills[$passiveSkillId];
			}
		}
		$this->_memberSkill['passive'] = $memberHaveSkill;
	}

    //设置用户的攻击技能释放概率，总和不超过1 array(1205 => 0.25,1206 => 0.4 ...)
    //如果没有，根据基础的释放概率，和可使用的技能数量进行平均
    private function _setAttackSkillRate($userSkillRates = array()) {
        if(!(is_array($this->_memberSkill['attack']) && count($this->_memberSkill['attack']))) {
            return array();
        }
        //小于1且存在相关概率传入 的情况，将概率赋给相应技能，否则平均计算基础的技能概率
        if(is_array($userSkillRates) && count($userSkillRates) && array_sum($userSkillRates) <= 1) {
            foreach ($this->_memberSkill['attack'] as $skillId => $skillLevel) {
                if(isset($userSkillRates[$skillId])) {
                    $this->_memberSkillRate['attack'][$skillId] = $userSkillRates[$skillId];
                }
            }
        } else {
            $allRate        = Skill_Rate::getAttackRates();
            $attackSkillNum = count($this->_memberSkill['attack']);
            $defaultRate    = isset($allRate[$attackSkillNum]) ? number_format(($allRate[$attackSkillNum]/$attackSkillNum), 2, '.',''): 0;
            foreach ($this->_memberSkill['attack'] as $skillId => $skillLevel) {
                $this->_memberSkillRate['attack'][$skillId] = $defaultRate;
            }
        }
        return ;
    }

    //设置用户的防御技能释放概率，总和不超过1 array(1205 => 0.25,1206 => 0.4 ...)
    //如果没有，根据基础的释放概率，和可使用的技能数量进行平均
    private function _setDefineSkillRate($userSkillRates = array()) {
        if(!(is_array($this->_memberSkill['define']) && count($this->_memberSkill['define']))) {
            return array();
        }
        //小于1且存在相关概率传入 的情况，将概率赋给相应技能，否则平均计算基础的技能概率
        if(is_array($userSkillRates) && count($userSkillRates) && array_sum($userSkillRates) <= 1) {
            foreach ($this->_memberSkill['define'] as $skillId => $skillLevel) {
                if(isset($userSkillRates[$skillId])) {
                    $this->_memberSkillRate['define'][$skillId] = $userSkillRates[$skillId];
                }
            }
        } else {
            $allRate        = Skill_Rate::getDefineRates();
            $defineSkillNum = count($this->_memberSkill['define']);
            $defaultRate    = isset($allRate[$defineSkillNum]) ? number_format(($allRate[$defineSkillNum]/$defineSkillNum), 2, '.','') : 0;
            foreach ($this->_memberSkill['define'] as $skillId => $skillLevel) {
                $this->_memberSkillRate['define'][$skillId] = $defaultRate;
            }
        }
        return ;
    }

	public function getPassiveSkills()
	{
		return $this->_memberSkill['passive'];
	}
	//当前队员是否存活
	public function isAlive()
	{
		return $this->_currentBlood>0?TRUE:FALSE;
	}
    //当前队员是否死亡
	public function isDied()
	{
		return $this->_currentBlood>0?FALSE:TRUE;
	}
	//获取当前队员的速度
	public function getMemberSpeed()
	{
		return $this->_memberAttribute[ConfigDefine::USER_ATTRIBUTE_SPEED];
	}
	//设置当前队员的组标识
	public function setMemberTeamKey($teamKey)
	{
		$this->_memberTeamKey = $teamKey;
	}
	//获取当前队员的组标识
	public function getMemberTeamKey()
	{
		return $this->_memberTeamKey;
	}
	//消耗血量
    public function consumeBlood($blood)
    {
        $this->_currentBlood -= $blood;
    }
    //消耗魔法
    public function consumeMagic($magic)
    {
        $this->_currentMagic -= $magic;
    }
    public function addBlood($blood) {
        if($this->_currentBlood > 0) {
            $this->_currentBlood = $this->_currentBlood + $blood;
        }
        if($this->_currentBlood > $this->_memberAttribute[ConfigDefine::USER_ATTRIBUTE_BLOOD]) {
            $this->_currentBlood = $this->_memberAttribute[ConfigDefine::USER_ATTRIBUTE_BLOOD];
        }
    }
    public function addMagic($magic)
    {
        //判断如果小于0的话，强制归0
        $this->_currentMagic = $this->_currentMagic > 0 ? $this->_currentMagic : 0;
        $this->_currentMagic = $this->_currentMagic + $magic;
        if($this->_currentMagic > $this->_memberAttribute[ConfigDefine::USER_ATTRIBUTE_MAGIC]) {
            $this->_currentMagic = $this->_memberAttribute[ConfigDefine::USER_ATTRIBUTE_MAGIC];
        }
    }

    //魔法是否消耗空
    public function isEmptyMagic()
    {
    	return $this->_currentMagic <= 0?TRUE:FALSE;
    }
    //获取队员的等级
    public function getMemberLevel()
    {
    	return $this->_memberLevel;
    }
    //获取队员的ID，可能为0
    public function getMemberId()
    {
    	return $this->_memberId;
    }
    private function _getMemberAttributes()
    {
    	return $this->_memberAttribute;
    }
    //获取队员的属性-力量
    public function getMemberAttributePower()
    {
    	$attribute = $this->_getMemberAttributes();
    	return isset($attribute[ConfigDefine::USER_ATTRIBUTE_POWER])?$attribute[ConfigDefine::USER_ATTRIBUTE_POWER]:0;
    }
    //获取队员的属性-伤害
    public function getMemberAttributeHurt()
    {
    	$attribute = $this->_getMemberAttributes();
    	return isset($attribute[ConfigDefine::USER_ATTRIBUTE_HURT])?$attribute[ConfigDefine::USER_ATTRIBUTE_HURT]:0;
    }
    //获取队员的属性-命中
    public function getMemberAttributeHit()
    {
    	$attribute = $this->_getMemberAttributes();
    	return isset($attribute[ConfigDefine::USER_ATTRIBUTE_HIT])?$attribute[ConfigDefine::USER_ATTRIBUTE_HIT]:0;
    }
    //获取队员的属性-躲闪
    public function getMemberAttributeDodge()
    {
    	$attribute = $this->_getMemberAttributes();
    	return isset($attribute[ConfigDefine::USER_ATTRIBUTE_DODGE])?$attribute[ConfigDefine::USER_ATTRIBUTE_DODGE]:0;
    }
    //获取队员的属性-防御
    public function getMemberAttributeDfense()
    {
    	$attribute = $this->_getMemberAttributes();
    	return isset($attribute[ConfigDefine::USER_ATTRIBUTE_DODGE])?$attribute[ConfigDefine::USER_ATTRIBUTE_DEFENSE]:0;
    }
    //获取队员的属性-灵力
    public function getMemberAttributePsychic()
    {
    	$attribute = $this->_getMemberAttributes();
    	return isset($attribute[ConfigDefine::USER_ATTRIBUTE_DODGE])?$attribute[ConfigDefine::USER_ATTRIBUTE_PSYCHIC]:0;
    }
    public function getCurrentMagaic()
    {
    	return $this->_currentMagic;
    }

    public function getCurrentBlood()
    {
        return $this->_currentBlood;
    }

    //各个技能的影响，区分attack和define
    //@todo 未考虑叠加，简单的覆盖此技能影响
    public function setEffect($flag, $skillId, $params) {
        if(!(is_array($params) && count($params)) || $skillId <= 0 || !in_array($flag, array('attack','define','sleep'))) {
            return false;
        }
        $params['skill_id'] = $skillId;
        $this->_currentSkillEffect[$flag][$skillId] = $params;
        return;
    }

    public function getEffect($flag) {
        return isset($this->_currentSkillEffect[$flag]) ? $this->_currentSkillEffect[$flag] : array();
    }
}