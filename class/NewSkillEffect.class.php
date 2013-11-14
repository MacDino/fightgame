<?php
class NewSkillEffect extends NewSkill
{
    public static function setSkillEffect()
    {
        $functionName = '_setSkillEffect'.self::$_attackSkillInfo['skill_id'];
        if(!method_exists('NewSkillEffect', $functionName))
		{
			return array();
		}else{
			return call_user_func('NewSkillEffect::'.$functionName);
		}
    }
    //攻击方是否可以使用此技能
    public static function skillEffectIsAttackCanUseThisSkill($skillId, $skillInfo)
    {
    	$functionName = '_skillEffectIsAttackCanUseThisSkill'.$skillId;
    	if(!method_exists('NewSkillEffect', $functionName))
    	{
    		return array();
    	}else{
    		return call_user_func('NewSkillEffect::'.$functionName, $skillInfo);
    	}
    }
    public static function skillEffectMagicAndBlood($skillId, $skillInfo)
    {
    	$functionName = '_skillEffectMagicAndBlood'.$skillId;
    	if(!method_exists('NewSkillEffect', $functionName))
    	{
    		return array();
    	}else{
    		return call_user_func('NewSkillEffect::'.$functionName, $skillInfo);
    	}
    }
    public static function skillEffectIsThisSKillCanAttack($skillId)
    {
    	$functionName = '_skillEffectNotCanAttackSkill'.$skillId;
    	if(!method_exists('NewSkillEffect', $functionName))
    	{
    		return TRUE;
    	}else{
    		return call_user_func('NewSkillEffect::'.$functionName, $skillInfo);
    	}
    }

    public static function skillEffectAttribute($skillId, $skillInfo, $memberAttribute)
    {
    	$functionName = '_skillEffectAttribute'.$skillId;
    	if(!method_exists('NewSkillEffect', $functionName))
    	{
    		return $memberAttribute;
    	}else{
    		return call_user_func('NewSkillEffect::'.$functionName, $skillInfo, $memberAttribute);
    	}
    
    }
    public static function skillEffectHurt($skillId, $skillInfo, $hurt)
    {
    	$functionName = '_skillEffectHurt'.$skillId;
    	if(!method_exists('NewSkillEffect', $functionName))
    	{
    		return $hurt;
    	}else{
    		return call_user_func('NewSkillEffect::'.$functionName, $skillInfo, $hurt);
    	}
    
    }
    
    
    //------1206
    private static function _setSkillEffect1206()
    {
    	self::_setAttackSkillEffect(self::$_attackMemberObj, 1);
    	self::_setDefineSkillEffect(self::$_attackMemberObj, 1);
    	self::_setSleepSkillEffect(self::$_attackMemberObj, 1);
    }
    //物理法术防御降为80%
    private static function _skillEffectAttribute1206($skillInfo, $memberAttribute)
    {
    	$memberAttribute[ConfigDefine::USER_ATTRIBUTE_DEFENSE] = $memberAttribute[ConfigDefine::USER_ATTRIBUTE_DEFENSE]*0.8;
    	$memberAttribute[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] = $memberAttribute[ConfigDefine::USER_ATTRIBUTE_PSYCHIC]*0.8;
    	return $memberAttribute;
    }
    //不受封类法术影响
    private static function _skillEffectNotCanAttackSkill1206()
    {
    	$skillList = array(
    			NewSkill::SKILL_HUMAN_GJ_WGK,
    			NewSKill::SKILL_HUMAN_GJ_FGK,
    			NewSkill::SKILL_TSIMSHIAN_GJ_XR,
    	);
    	if(in_array(self::$_attackSkillInfo['skll_id'], $skillList))return FALSE;
    	return TRUE;
    }
    //------1207
    private static function _setSkillEffect1207()
    {
    	$round = NewSkill::getSkillRound();
    	self::_setAttackSkillEffect(self::$_attackMemberObj, $round);
    	self::_setDefineSkillEffect(self::$_attackMemberObj, $round);
    }
    //减少20%物理防御
    private static function _skillEffectAttribute1207($skillInfo, $memberAttribute)
    {
    	$memberAttribute[ConfigDefine::USER_ATTRIBUTE_DEFENSE] = $memberAttribute[ConfigDefine::USER_ATTRIBUTE_DEFENSE]*0.8;
    	return $memberAttribute;
    }
    //不能使用物理攻击
	private static function _skillEffectIsAttackCanUseThisSkill1207()
    {
    	$skillList = NewSkill::getPhysicsSkills();
    	if(in_array(self::$_attackSkillInfo['skll_id'], $skillList))return FALSE;
    	return TRUE;
    }
    //------1208
    private static function _setSkillEffect1208()
    {
    	$round = NewSkill::getSkillRound();
    	self::_setAttackSkillEffect(self::$_attackMemberObj, $round);
    	self::_setDefineSkillEffect(self::$_attackMemberObj, $round);
    }
    //减少20%法术防御
	private static function _skillEffectAttribute1208($skillInfo, $memberAttribute)
    {
    	$memberAttribute[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] = $memberAttribute[ConfigDefine::USER_ATTRIBUTE_PSYCHIC]*0.7;
    	return $memberAttribute;
    }
    //不能使用法术攻击
    private static function _skillEffectIsAttackCanUseThisSkill1208()
    {
    	$skillList = NewSkill::getMagicSkills();
    	if(in_array(self::$_attackSkillInfo['skll_id'], $skillList))return FALSE;
    	return TRUE;
    }
    //------1209
    private static function _setSkillEffect1209()
    {
    	$round = NewSkill::getSkillRound();
    	if($round > 1)$round -= 1;
    	if($round <= 1)return;
    	$value = NewSkillAttribute::skillAttribute;
    	$value = current($value);
    	self::_setAttackSkillEffect(self::$_attackMemberObj, $round, $vlue);
    }
    //加蓝
    private static function _skillEffectMagicAndBlood1209($skillInfo)
    {
    	$res =  self::$_attackMemberObj->addBlood($skillInfo['value']);
    	if($res)
    	{
    		return array(ConfigDefine::USER_ATTRIBUTE_BLOOD => $skillInfo['value']);
    	}
    }
	//------1216
    private static function _getSkillEffect1216()
    {
    	$round = NewSkill::getSkillRound();
    	self::_setAttackSkillEffect(self::$_attackMemberObj, $round);
    }
    //增加技能等级/4点伤害+10
    private static function _skillEffectHurt1216($skillInfo, $hurt)
    {
    	$hurt += $skillInfo['skill_level']/4+10;
    	return $hurt;
    }
    //------1219
    private static function _getSkillEffect1219()
    {
    	self::_setSleepSkillEffect(self::$_attackMemberObj, 1);
    }
    //------1214
    private static function _getSkillEffect1214()
    {
    	self::_setAttackSkillEffect(self::$_defineMemberObj, 1);
    }
    //输出伤害减为30%
    private static function _skillEffectHurt1214($skillInfo, $hurt)
    {
    	$hurt *= 0.7;
    	return $hurt;
    }
    //减血技能等级+25
    private static function _skillEffectMagicAndBlood1214($skillInfo)
    {
    	$res =  self::$_attackMemberObj->consumeBlood($skillInfo['skill_level'] + 25);
    	if($res)
    	{
    		return array(ConfigDefine::USER_ATTRIBUTE_BLOOD => -$skillInfo['skill_level'] + 25);
    	}
    }
    //------1222
    private static function _getSkillEffect1222()
    {
    	$round = NewSkill::getSkillRound();
    	self::_setAttackSkillEffect(self::$_defineMemberObj, $round);
    }
    //增加技能等级/4点灵力
    private static function _skillEffectAttribute1222($skillInfo, $memberAttribute)
    {
    	$memberAttribute[ConfigDefine::USER_ATTRIBUTE_PSYCHIC] = $memberAttribute[ConfigDefine::USER_ATTRIBUTE_PSYCHIC]+$skillInfo['skill_levle']/4;
    	return $memberAttribute;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    private static function _setAttackSkillEffect($memberObj, $round, $value = NULL)
    {
    	$memberObj->setEffect('attack', self::$_attackSkillInfo['skill_id'],
    			array('skill_level' => self::$_attackSkillInfo['skill_level'],
    					'round' => $round,
    					'value' => $value,
    					));
    }
    
    private static function _setDefineSkillEffect($memberObj, $round)
    {
    	$memberObj->setEffect('define', self::$_attackSkillInfo['skill_id'],
    			array('skill_level' => self::$_attackSkillInfo['skill_level'],
    					'round' => $round));
    }
    
    private static function _setSleepSkillEffect($memberObj, $round)
    {
    	$memberObj->setEffect('sleep', self::$_attackSkillInfo['skill_id'],
    			array('skill_level' => self::$_attackSkillInfo['skill_level'],
    					'round' => $round));
    }
}
