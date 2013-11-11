<?php 
class NewSkill
{
	protected static $_attackMemberObj = NULL;
	protected static $_defineMemberObj = NULL;
	protected static $_attackSkillInfo = NULL;
	
	private static $_skillList = NULL;
	
	
	CONST SKILL_CONFIG_TABLE = 'skill_config';
	
	
	CONST SKILL_DEFAULT_PT 			= 1201;//普通攻击
	CONST SKILL_COMMON_BD_WFX 		= 1202;//被动技能-物防修
	CONST SKILL_COMMON_BD_FFX 		= 1203;//被动技能-法防修
	CONST SKILL_COMMON_BD_WGX 		= 1204;//被动技能-物攻修
	CONST SKILL_COMMON_BD_FGX 		= 1205;//被动技能-法攻修
	CONST SKILL_HUMAN_GJ_DTWLGJ 	= 1206;//人族-攻击-单体物理攻击
	CONST SKILL_HUMAN_GJ_WGK 		= 1207;//人族-攻击-物攻控
	CONST SKILL_HUMAN_GJ_FGK 		= 1208;//人族-攻击-法攻控
	CONST SKILL_HUMAN_GJ_JL 		= 1209;//人族-攻击-加蓝
	CONST SKILL_HUMAN_GJ_DJX 		= 1210;//人族-攻击-单加血
	CONST SKILL_HUMAN_FY_FJ 		= 1211;//人族-防御-反击
	CONST SKILL_TSIMSHIAN_GJ_DTFSGJ = 1212;//仙族-攻击-单体法术攻击
	CONST SKILL_TSIMSHIAN_GJ_QTFSGJ = 1213;//仙族-攻击-群体法术攻击
	CONST SKILL_TSIMSHIAN_GJ_XR 	= 1214;//仙族-攻击-虚弱
	CONST SKILL_TSIMSHIAN_GJ_QJX 	= 1215;//仙族-攻击-群加血
	CONST SKILL_TSIMSHIAN_GJ_QJSH 	= 1216;//仙族-攻击-群加伤害
	CONST SKILL_TSIMSHIAN_FY_ZJ 	= 1217;//仙族-防御-招架
	CONST SKILL_DEMON_GJ_DTGJ 		= 1218;//魔族-攻击-单体攻击
	CONST SKILL_DEMON_GJ_QTGJ 		= 1219;//魔族-攻击-群体攻击
	CONST SKILL_DEMON_GJ_JCK 		= 1220;//魔族-攻击-解除控
	CONST SKILL_DEMON_GJ_FH 		= 1221;//魔族-攻击-复活
	CONST SKILL_DEMON_GJ_QJL 		= 1222;//魔族-攻击-群加灵
	CONST SKILL_DEMON_FY_FZ 		= 1223;//魔族-攻击-反震
	
	public static function begin($attackMemberObj, $attackSkillInfo)
	{
		self::$_attackMemberObj = $attackMemberObj;
		self::$_attackSkillInfo = self::_getSkillConfig($attackSkillInfo);
	}
	
	public static function setDefineObj($defineMemberObj)
	{
		self::$_defineMemberObj = $defineMemberObj;
	}
	
	public static function end()
	{
		self::$_attackMemberObj = NULL;
		self::$_defineMemberObj = NULL;
		self::$_attackSkillInfo = NULL;	
	}
	public static function getAttackSkillConfig()
	{
		return self::$_attackSkillInfo;
	}
	public static function getAttack()
	{
		return NewSkillHurt::getAttack();
	}
	public static function skillIsHit()
	{
		return NewSkillHit::skillIsHit();
	}
	public static function isMemberCanUseThisSkill()
	{
		return NewSkillUse::isMemberCanUseThisSkill();
	}
	public static function getSkillRound()
	{
		return NewSkillRound::skillRound();
	}
	public static function skillAttribute()
	{
		return NewSkillAttribute::skillAttribute();
	}
    public static function setSkillEffect()
    {
        return NewSkillEffect::setSkillEffect();
    }
    public static function getPhysicsSkills()
    {
        return array(
          self::SKILL_HUMAN_GJ_DTWLGJ,
          self::SKILL_HUMAN_FY_FJ,
          self::SKILL_DEMON_GJ_DTGJ,
          self::SKILL_DEMON_GJ_QTGJ,
        );
    }
    public static function getMagicSkills()
    {
        return array(
          self::SKILL_TSIMSHIAN_GJ_DTFSGJ,
          self::SKILL_TSIMSHIAN_GJ_QTFSGJ,
        ); 
    
    }
	private static function _getSkillConfig($attackSkillInfo)
	{
		$skillId = key($attackSkillInfo);
		$skillLevel = current($attackSkillInfo);
		if(!is_array(self::$_skillList))
		{
			$skillConfigList = MySql::select(self::SKILL_CONFIG_TABLE);
			if(is_array($skillConfigList) && $skillConfigList)
			{
				foreach($skillConfigList as $skillConfig)
				{
					$attack_num = 1;
					if($skillConfig['attack_num_each_level'] > 0)
					{
						$attack_num = floor($skilLevel/$skillConfig['attack_num_each_level']);
						if($attack_num < 1)$attack_num = 1;
					}
					unset($skillConfig['attack_num_each_level']);
					$skillConfig['hit_member_num'] = $attack_num;
					if($skillConfig['is_consume_attack_num'])
					{
						$consume_1109 = $skillConfig['consume_1109'] * $attack_num;
						$consume_1108 = $skillConfig['consume_1108'] * $attack_num;
					}else{
						$consume_1109 = $skillConfig['consume_1109'];
						$consume_1108 = $skillConfig['consume_1108'];
					}
					unset($skillConfig['is_consume_attack_num']);
					unset($skillConfig['consume_1109']);
					unset($skillConfig['consume_1108']);
					$skillConfig['consume'] = array(1109 => $consume_1109, 1108 => $consume_1108);
					$skillConfig['target'] = json_decode($skillConfig['target'], true);
					$skillList[$skillConfig['skill_id']] = $skillConfig;
				}
				self::$_skillList = $skillList;
			}
		}
		$skillConfigInfo =  self::$_skillList[$skillId];
		$skillConfigInfo['skill_level'] = $skillLevel;
		return $skillConfigInfo;
	}
	//获取防御技能列表
	public static function getDefineSkillList($raceId = NULL)
	{
		$skillList =  array(
				User_Race::RACE_HUMAN => array(
						self::SKILL_HUMAN_FY_FJ,
				),
				User_Race::RACE_TSIMSHIAN => array(
						self::SKILL_TSIMSHIAN_FY_ZJ,
				),
				User_Race::RACE_DEMON => array(
						self::SKILL_DEMON_FY_FZ,
				),
		);
		return isset($skillList[$raceId])?$skillList[$raceId]:$skillList;
	}
	//获取攻击技能列表
	public static function getAttackSkillList($raceId = NULL)
	{
		$skillList =  array(
				User_Race::RACE_HUMAN => array(
						self::SKILL_HUMAN_GJ_DTWLGJ,
						self::SKILL_HUMAN_GJ_WGK,
						self::SKILL_HUMAN_GJ_FGK,
						self::SKILL_HUMAN_GJ_JL,
						self::SKILL_HUMAN_GJ_DJX,
				),
				User_Race::RACE_TSIMSHIAN => array(
						self::SKILL_TSIMSHIAN_GJ_DTFSGJ,
						self::SKILL_TSIMSHIAN_GJ_QTFSGJ,
						self::SKILL_TSIMSHIAN_GJ_XR,
						self::SKILL_TSIMSHIAN_GJ_QJX,
						self::SKILL_TSIMSHIAN_GJ_QJSH,
				),
				User_Race::RACE_DEMON => array(
						self::SKILL_DEMON_GJ_DTGJ,
						self::SKILL_DEMON_GJ_QTGJ,
						self::SKILL_DEMON_GJ_JCK,
						self::SKILL_DEMON_GJ_FH,
						self::SKILL_DEMON_GJ_QJL,
				),
		);
		return isset($skillList[$raceId])?$skillList[$raceId]:$skillList;
	}
	
	//获取被动技能列表
	public static function getPassiveSkillList()
	{
		return array(
				self::SKILL_COMMON_BD_FFX,
				self::SKILL_COMMON_BD_FGX,
				self::SKILL_COMMON_BD_WFX,
				self::SKILL_COMMON_BD_WGX,
		);
	}
	public static function debug()
	{
		echo "当前技能ID为".self::$_attackSkillInfo['skill_id']."<br />";
		echo "当前技能信息为<br />";
		var_dump(self::$_attackSkillInfo);
		echo "当前技能攻击输出为<br />";
		var_dump(NewSkillHurt::getValue());
		echo "当前技能命中几率为".NewSkillHit::getHitValue()."<br />";
		echo "当前技能可用为";
		var_dump(self::isMemberCanUseThisSkill());
		echo "当前技能持续回合".NewSkillRound::getValue()."<br />";
	}
}
