<?php
class NewSkillEffect extends NewSkill
{
	public static function skillEffect()
	{
		$functionName = '_'.self::$_attackSkillInfo['skill_id'];
		if(!method_exists('NewSkillEffect', $functionName))
		{
			return array();
		}else{
			return call_user_func('NewSkillEffect::'.$functionName);
		}
	}
	private static function _1220()
	{
		/**
		 * 可以解除物攻控、法功控、虚弱的技能效果。
		 */
	}
	private static function _1206()
	{
		/**
		 * 使用后需休息一回合，休息时不能使用战斗指令，也不会受封类法术影响；物理法术防御降低为正常状态的80%；防御技能不受影响。
		 */
	}
	private static function _1207()
	{
		/**
		 * 1.有效回合内减少20%物理防御
2.有效回合内不能使用物理攻击
		 */
	}
	private static function _1208()
	{
		/**
		 * 1. 有效回合内减30%法术防御。
2.有效回合内不能使用法术攻击。
		 */
	}
	private static function _1214()
	{
		/**
		 * 1.击中目标后在有效回合内降低目标30%的物理伤害和法术伤害。
		 *	2. 减血：技能等级+25
		 */
	}
	private static function _1216()
	{
		/**
		 * 增加技能等级/4点伤害
		 */
	}
	
	private static function _1217()
	{
		/**
		 * 物理攻击降低30%，法术攻击降低50%
		 */
		return array('hurt' => array('hysics' => 0.7, 'magic' => 0.5));
	}
	
	private static function _1219()
	{
		/**
		 * 使用后需要休息1回合
		 */
		return array('sleep' => 1);
	}
	
	private static function _1222()
	{
		/**
		 * 增加技能等级/4点灵力
		 */
		return array('attributes' => array(ConfigDefine::USER_ATTRIBUTE_PSYCHIC => self::$_attackSkillInfo['skill_level']/4));
	}
}