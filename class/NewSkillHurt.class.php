<?php
class NewSkillHurt extends NewSkill
{
	private static $_addition = 1;//攻击加成
	private static $_rand5UserLevelGetTop3Average = 0;//随机5次用户等级，取最大三个值的平均值
	private static $_randUserAttributePower = 0;
	private static $_randUserAttributeHurt = 0;
	
	private static $_hurt = array();
	
	
	public static function getAttack()
	{
		for($i=1;$i<=self::$_attackSkillInfo['hand_num'];$i++)
		{
			$functionName = '_'.self::$_attackSkillInfo['skill_id'];
			
			if(!method_exists('NewSkillHurt', $functionName))
			{
				$return[] = array('hurt' => 0, 'addition' => 1);
			}else{
				self::$_rand5UserLevelGetTop3Average = self::_rand5UserLevelGetTop3Average(self::$_attackMemberObj->getMemberLevel());
				self::$_addition = self::attackAddition(self::$_attackMemberObj->getMemberId());
				self::$_randUserAttributePower = self::_randUserAttributePower(self::$_attackMemberObj->getMemberAttributePower());
				self::$_randUserAttributeHurt = self::_randUserAttributePower(self::$_attackMemberObj->getMemberAttributeHurt());
				$hurt = call_user_func('NewSkillHurt::'.$functionName, $i);
				
				if(self::$_attackSkillInfo['skill_type'] == 1)
				{
					//物理攻击
					
				}elseif(self::$_attackSkillInfo['skill_type'] == 2){
					//法术攻击
				}
				//计算攻击被动技能
				
				//计算防御被动技能
				
				
				if($hurt < 0)$hurt = 1;
				$return[] = array('hurt' => $hurt, 'addition' => self::$_addition);
			}
			
		}
		self::$_hurt = $return;
		return $return;
	}
	
	public static function getValue()
	{
		return self::$_hurt;
	}
	
	private static function _1201()
	{
		$hurt = self::$_rand5UserLevelGetTop3Average + self::$_attackMemberObj->getMemberAttributeHit()/3 + self::$_attackMemberObj->getMemberAttributeHurt() 
			+ self::$_randUserAttributePower - self::$_defineMemberObj->getMemberAttributeDfense();
		$hurt *= self::$_addition;
		return $hurt;
	}
	private static function _1206($i)
	{
		$hurt = self::$_rand5UserLevelGetTop3Average + self::$_attackMemberObj->getMemberAttributeHit()/3 + self::$_attackMemberObj->getMemberAttributeHurt() 
				+ self::$_randUserAttributePower - self::$_defineMemberObj->getMemberAttributeDfense();
		switch ($i)
		{
			case 1:
				$hurt *= 0.7;
				break;
			case 2:
				$hurt *= 0.8;
				break;
			case 3:
				$hurt *= 1;
				break;
			default:
				$hurt = 0;
		}
		$hurt *= self::$_addition;
		return $hurt;
	}
	private static function _1212()
	{
		$hurt = self::$_attackSkillInfo['skill_level']*2.5 + self::_randUserAttributePsychic(self::$_attackMemberObj->getMemberAttributePsychic()) 
			- self::$_defineMemberObj->getMemberAttributePsychic() + self::$_attackMemberObj->getMemberAttributeHurt()*0.3;
		$hurt *= self::$_addition;
		return $hurt;
	}
	private static function _1213()
	{
		$hurt = self::$_attackSkillInfo['skill_level']*2.0 + (self::_randUserAttributePsychic(self::$_attackMemberObj->getMemberAttributePsychic())
				- self::$_defineMemberObj->getMemberAttributePsychic() + self::$_attackMemberObj->getMemberAttributeHurt()*0.3)
				*(1 - (self::$_attackSkillInfo['hit_member_num'] -1)/20);
		$hurt *= self::$_addition;
		return $hurt;
	}
	private static function _1218()
	{
		$hurt = (self::$_rand5UserLevelGetTop3Average + self::$_attackMemberObj->getMemberAttributeHit()/3 + self::$_attackMemberObj->getMemberAttributeHurt() + self::$_randUserAttributePower)*1.05
				- self::$_defineMemberObj->getMemberAttributeDfense()*0.7;
		$hurt *= self::$_addition;
		return $hurt;
	}
	private static function _1219()
	{
		$hurt = (self::$_rand5UserLevelGetTop3Average + self::$_attackMemberObj->getMemberAttributeHit()/3 + self::$_attackMemberObj->getMemberAttributeHurt() + self::$_randUserAttributePower)*1.05
		- self::$_defineMemberObj->getMemberAttributeDfense();
		$hurt *= self::$_addition;
		return $hurt;
	}
	//随机获取用用户力量1%-5%
	private static function _randUserAttributePower($userAttributePower)
	{
		return PerRand::getRandValue($userAttributePower*0.01, $userAttributePower*0.05);
	}
	//随机获取用用户伤害3%-9%
	private static function _randUserAttributeHurt($userAttributeHurt)
	{
		return PerRand::getRandValue($userAttributePower*0.03, $userAttributePower*0.09);
	}
	//随机获取用用户灵力值95%-105%
	private static function _randUserAttributePsychic($userAttributePsychic)
	{
		return PerRand::getRandValue($userAttributePsychic*0.95, $userAttributePower*1.05);
	}
	//随机5次用户等级，取最大三个值的平均值
	private static function _rand5UserLevelGetTop3Average($userLevel)
	{
		$userLevel = (int)$userLevel;
		if($userLevel == 1)return 1;
		if($userLevel < 1)return 0;
		for($i=1;$i<=5;$i++)
		{
			$res[] = PerRand::getRandValue(array(0, $userLevel));
		}
		rsort($res);
		$res = array_slice($res, 0, 3);
		$averageValue = array_sum($res)/3;
		return $averageValue;
	}
	/**
	 * 获取暴击系数
	 * @param 攻方队员值 $userId
	 */
	public static function attackAddition($userId = 0)
	{
		$ratioValue = 1;
		$ratio 		= 0.05;
		$isViolent 	= 0;
			
		if(NewFight::DEBUG)$ratio = 1;
			
		//用户内丹
		if($userId > 0)
		{
			$violentPill = Pill_Pill::usedPill($userId);//暴击内丹
			if($violentPill['pill_type'] == Pill::YUHENGNEIDAN){
				$isViolent = 1;
				$violentInfo = Pill::pillAttribute($violentPill['pill_type'], $violentPill['pill_layer'], $violentPill['pill_level']);
			}
			if($isViolent == 1){
				$ratio += $violentInfo['probability'];
			}
		}
			
		$ratioKey = PerRand::getRandResultKey(array($ratio));
			
		if($ratioKey || $ratioKey === 0)$ratioValue = 2;
			
		if($isViolent == 1){
			$ratioValue += $violentInfo['value'];
		}
		return $ratioValue;
	}
}