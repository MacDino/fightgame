<?php
class NewSkillRound extends NewSkill
{
	
	private static $_round = 1;
	
	public static function skillRound()
	{
		$functionName = '_'.self::$_attackSkillInfo['skill_id'];
		if(!method_exists('NewSkillRound', $functionName))
		{
			return 1;
		}else{
			$round = call_user_func('NewSkillRound::'.$functionName);
			self::$_round = $round;
			return $round;
		}
	}
	
	public static function getValue()
	{
		return self::$_round;
	}
	
	private static function _1207()
	{
		$roundNum = (self::$_attackSkillInfo['skill_level'] - self::$_defineMemberObj->getMemberLevel())/10 + self::$_attackSkillInfo['skill_level']/50 + 2;
		if($roundNum < 1)return 1;
		if($roundNum > 4)return 4;
		return (int)$roundNum;
	}
	private static function _1208()
	{
		$roundNum = (self::$_attackSkillInfo['skill_level'] - self::$_defineMemberObj->getMemberLevel())/10 + self::$_attackSkillInfo['skill_level']/50 + 2;
		if($roundNum < 1)return 1;
		if($roundNum > 4)return 4;
		return (int)$roundNum;
	}
	private static function _1209()
	{
		$roundNum = (self::$_attackSkillInfo['skill_level'] - self::$_defineMemberObj->getMemberLevel())/5 + self::$_attackSkillInfo['skill_level']/50;
		if($roundNum < 1)return 1;
		if($roundNum > 10)return 10;
		return (int)$roundNum;
	}
	private static function _1214()
	{
		$roundNum = (self::$_attackSkillInfo['skill_level'] - self::$_defineMemberObj->getMemberLevel())/10 + self::$_attackSkillInfo['skill_level']/50 + 2;
		if($roundNum < 1)return 1;
		if($roundNum > 4)return 4;
		return (int)$roundNum;
	}
	private static function _1216()
	{
		$roundNum = (self::$_attackSkillInfo['skill_level'] - self::$_defineMemberObj->getMemberLevel())/10 + self::$_attackSkillInfo['skill_level']/50 + 2;
		if($roundNum < 1)return 1;
		if($roundNum > 4)return 4;
		return (int)$roundNum;
	}
	private static function _1222()
	{
		$roundNum = (self::$_attackSkillInfo['skill_level'] - self::$_defineMemberObj->getMemberLevel())/10 + self::$_attackSkillInfo['skill_level']/50 + 2;
		if($roundNum < 1)return 1;
		if($roundNum > 4)return 4;
		return (int)$roundNum;
	}
}