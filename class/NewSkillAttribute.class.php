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
                                (self::$_attackSkillInfo['skill_level']*4.5 + (self::$_attackMemberAttribute[ConfigDefine::USER_ATTRIBUTE_HIT]/3 + self::$_attackMemberAttribute[ConfigDefine::USER_ATTRIBUTE_HURT])*2/3)*NewSkillHurt::attackAddition(self::$_attackMemberObj->getMemberId()),
                                'addition' => NewSkillHurt::attackAddition(self::$_attackMemberObj->getMemberId()),
				);
	}
	private static function _1215()
	{
		return array(
				ConfigDefine::USER_ATTRIBUTE_BLOOD =>
					(self::$_attackSkillInfo['skill_level']*3 + (self::$_attackMemberAttribute[ConfigDefine::USER_ATTRIBUTE_HIT]/3 + self::$_attackMemberAttribute[ConfigDefine::USER_ATTRIBUTE_HURT])*1/3
                                        + self::$_attackMemberAttribute[ConfigDefine::USER_ATTRIBUTE_PSYCHIC]*1/3)*(1 - (self::$_attackSkillInfo['hit_member_num'] -1)/20)*NewSkillHurt::attackAddition(self::$_attackMemberObj->getMemberId()),
                                            'addition' => NewSkillHurt::attackAddition(self::$_attackMemberObj->getMemberId()),
		);
	}
	private static function _1221()
	{
		return array(
				ConfigDefine::USER_ATTRIBUTE_BLOOD =>
				(self::$_attackSkillInfo['skill_level']*3 + (self::$_attackMemberAttribute[ConfigDefine::USER_ATTRIBUTE_HIT]/3 + self::$_attackMemberAttribute[ConfigDefine::USER_ATTRIBUTE_HURT])*1/6
						+ self::$_attackMemberObj->getMemberAttributePsychic()*1/6)
		);
	}
	private static function _1220()
	{
		self::$_defineMemberObj->delEffect(NewSkill::SKILL_HUMAN_GJ_WGK);
		self::$_defineMemberObj->delEffect(NewSkill::SKILL_HUMAN_GJ_FGK);
		self::$_defineMemberObj->delEffect(NewSkill::SKILL_TSIMSHIAN_GJ_XR);
	}

    private static function _1214() {
        return array(ConfigDefine::USER_ATTRIBUTE_BLOOD => -(self::$_attackSkillInfo['skill_level'] + 25));
    }
}
