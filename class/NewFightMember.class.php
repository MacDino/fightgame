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
	private $_memberRace = NULL;//当前队员的种族
	private $_memberTeamKey = NULL;//当前队员的队伍标识
    
    
    private $_skillEffectSleepRound = 0;//技能效果-休息回合
    private $_skillEffectAttribute = array();//技能效果-属性加成
    private $_skillEffectNotCanUseSkill = array();//技能效果-无法使用的技能
    private $_skillEffectNotCanAttackSkill = array();//技能效果-无法被攻攻到的技能

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
	}
	public function getMemberAttackSkill()
	{
		return array(1201 => 10);
	}
	public function getMemberDefineSkill()
	{
		return array(1211 => 10);
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
}