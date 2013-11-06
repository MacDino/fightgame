<?php
class NewSkillHit extends NewSkill
{	
	private static $_hitValue = 0;
	private static $i = 1;
	
	public static function skillIsHit()
	{
		$functionName = '_'.self::$_attackSkillInfo['skill_id'];
		if(!method_exists('NewSkillHit', $functionName))
		{
			return TRUE;
		}else{
			return call_user_func('NewSkillHit::'.$functionName);
		}
	}
	
	private static function _1201()
	{
		$randHit = PerRand::getRandValue(array(self::$_attackMemberObj->getMemberAttributeHit()*0.2,
				self::$_attackMemberObj->getMemberAttributeHit()*1));
		$randDodge = PerRand::getRandValue(array(self::$_attackMemberObj->getMemberAttributeDodge()*0.8,
						self::$_attackMemberObj->getMemberAttributeDodge()*1));
		$hitValue = $randHit - $randDodge;
		self::$_hitValue = $hitValue;
		if($hitValue >= 1)return TRUE;
		return FALSE; 
	}
	private static function _1207()
	{
		$ration = (self::$_attackSkillInfo['skill_level'] -
				self::$_defineMemberObj->getMemberLevel())*0.02 +
				PerRand::getRandValue(0.05, 0.8);
		self::$_hitValue = $ration;
		if($ration <= 0 )return FALSE;
		if(PerRand::getRandResultKey(array($ration)))
		{
			return TRUE;
		}
		return FALSE;
	}
	private static function _1208()
	{
		$ration = (self::$_attackSkillInfo['skill_level'] -
				self::$_defineMemberObj->getMemberLevel())*0.02 +
				PerRand::getRandValue(0.05, 0.8);
		self::$_hitValue = $ration;
		if($ration <= 0 )return FALSE;
		if(PerRand::getRandResultKey(array($ration)))
		{
			return TRUE;
		}
		return FALSE;
	}
	private static function _1214()
	{
		$ration = (self::$_attackSkillInfo['skill_level'] -
				self::$_defineMemberObj->getMemberLevel())*0.02 +
				PerRand::getRandValue(0.2, 0.8);
		self::$_hitValue = $ration;
		if($ration <= 0 )return FALSE;
		if(PerRand::getRandResultKey(array($ration)))
		{
			return TRUE;
		}
		return FALSE;
	}
	private static function _1220()
	{
		$ration = (self::$_attackSkillInfo['skill_level'] -
				self::$_defineMemberObj->getMemberLevel())*0.02 +
				PerRand::getRandValue(0.5, 0.8);
		self::$_hitValue = $ration;
		if($ration <= 0 )return FALSE;
		if(PerRand::getRandResultKey(array($ration)))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	
	public static function getHitValue()
	{
		return self::$_hitValue;
	}
// 	public static function skill1201()
// 	{
// 		var_dump($this);
// 		var_dump($this->_attackMemberObj);
// 		
// 	}
// 	public function skill1207()
// 	{
// 		$ration = ($this->_attackSkillInfo['skill_level'] - 
// 				$this->_defineMemberObj->getMemberLevel())*0.02 + 
// 				PerRand::getRandValue(0.05, 0.8);
// 		if($ration <= 0 )return FALSE;
// 		if(PerRand::getRandResultKey(array($ration)))
// 		{
// 			return TRUE;
// 		}
// 		return FALSE;
// 	}
// 	private static function skill1208()
// 	{
// 		$ration = ($this->_attackSkillInfo['skill_level'] - 
// 				$this->_defineMemberObj->getMemberLevel())*0.02 + 
// 				PerRand::getRandValue(0.05, 0.8);
// 		if($ration <= 0 )return FALSE;
// 		if(PerRand::getRandResultKey(array($ration)))
// 		{
// 			return TRUE;
// 		}
// 		return FALSE;
// 	}
}
