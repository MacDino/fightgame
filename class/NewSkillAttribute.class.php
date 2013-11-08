<?php

class NewSkillAttribute extends NewSkill
{
	public static function skillAttribute()
	{
		$functionName = '_'.self::$_attackSkillInfo['skill_id'];
		if(!method_exists('NewSkillAttribute', $functionName))
		{
			return array();
		}else{
			return call_user_func('NewSkillAttribute::'.$functionName);
		}
	}
	
	private static function _1209()
	{
		return array(ConfigDefine::USER_ATTRIBUTE_MAGIC => self::$_attackSkillInfo['skill_level']/2 + 10);
	}
	
	private static function _1210()
	{
		return array(
				ConfigDefine::USER_ATTRIBUTE_BLOOD =>
				(self::$_attackSkillInfo['skill_level']*4.5 + (self::$_attackMemberObj->getMemberAttributeHit()/3 + self::$_attackMemberObj->getMemberAttributeHurt())*2/3)*NewSkillHurt::attackAddition(self::$_attackMemberObj->getMemberId()),
				);
	}
	private static function _1215()
	{
		return array(
				ConfigDefine::USER_ATTRIBUTE_BLOOD =>
					(self::$_attackSkillInfo['skill_level']*3 + (self::$_attackMemberObj->getMemberAttributeHit()/3 + self::$_attackMemberObj->getMemberAttributeHurt())*1/3
						+ self::$_attackMemberObj->getMemberAttributePsychic()*1/3)*(1 - (self::$_attackSkillInfo['hit_member_num'] -1)/20)*NewSkillHurt::attackAddition(self::$_attackMemberObj->getMemberId())
		);
	}
	private static function _1221()
	{
		return array(
				ConfigDefine::USER_ATTRIBUTE_BLOOD =>
				(self::$_attackSkillInfo['skill_level']*3 + (self::$_attackMemberObj->getMemberAttributeHit()/3 + self::$_attackMemberObj->getMemberAttributeHurt())*1/6
						+ self::$_attackMemberObj->getMemberAttributePsychic()*1/6)
		);
	}
}