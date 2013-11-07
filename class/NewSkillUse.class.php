<?php
class NewSkillUse extends NewSkill
{
	public static function isMemberCanUseThisSkill()
	{
		return TRUE;
	}
	//判断加蓝是否可用
	public static function skill1209()
	{
		if(self::$_attackMemberObj->getCurrentMagaic() > 50)return TRUE;
		return FALSE;
	}
	//判断复活是否可用
	public static function skill1221()
	{
		if(NewFight::teamDiedMember(self::$_attackMemberObj->getMemberTeamKey()))return TRUE;
		return FALSE;
	}
}