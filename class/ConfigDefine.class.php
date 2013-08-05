<?php
//公共属性定义
class ConfigDefine
{
	//用户属性定义
	CONST USER_ATTRIBUTE_POWER        	= 101;//力量 - 基本属性
    CONST USER_ATTRIBUTE_MAGIC_POWER  	= 102;//魔力 - 基本属性
    CONST USER_ATTRIBUTE_PHYSIQUE     	= 103;//体质 - 基本属性
    CONST USER_ATTRIBUTE_ENDURANCE    	= 104;//耐力 - 基本属性
    CONST USER_ATTRIBUTE_QUICK        	= 105;//敏捷 - 基本属性

    CONST USER_ATTRIBUTE_HIT          	= 106;//命中 - 成长属性
    CONST USER_ATTRIBUTE_HURT         	= 107;//伤害 - 成长属性
    CONST USER_ATTRIBUTE_MAGIC        	= 108;//魔法 - 成长属性
    CONST USER_ATTRIBUTE_BLOOD        	= 109;//气血 - 成长属性
    CONST USER_ATTRIBUTE_PSYCHIC      	= 110;//灵力 - 成长属性
    CONST USER_ATTRIBUTE_SPEED        	= 111;//速度 - 成长属性
    CONST USER_ATTRIBUTE_DEFENSE      	= 112;//防御 - 成长属性
    CONST USER_ATTRIBUTE_DODGE        	= 113;//躲闪 - 成长属性
    CONST USER_ATTRIBUTE_LUCKY        	= 114;//幸运 - 成长属性

	//技能定义

	CONST SKILL_ZJ      				= 201;//重击
	CONST SKILL_LJ      				= 202;//重击
    CONST SKILL_LSYZ    				= 203;//灵犀一指
    CONST SKILL_SWZH    				= 204;//三昧真火
    CONST SKILL_HFHY    				= 205;//呼风唤雨 
    CONST SKILL_WLJ     				= 206;//五雷决
    CONST SKILL_WFX     				= 207;//物防修 
    CONST SKILL_FFX     				= 208;//法防修
    CONST SKILL_GX      				= 209;//攻修
    CONST SKILL_FX      				= 210;//法修
    CONST SKILL_DZ      				= 211;//锻造
    CONST SKILL_FY      				= 212;//防御
    CONST SKILL_FJ      				= 213;//反击
    CONST SKILL_FD      				= 214;//法盾

	//其它
	CONST RELEASE_PROBABILITY 		  	= 301;//释放概率

	public static function configDefineNameList()
	{
		$configDefineNameList = array(
			self::USER_ATTRIBUTE_POWER        	=> '力量',
            self::USER_ATTRIBUTE_MAGIC_POWER  	=> '魔力',
            self::USER_ATTRIBUTE_PHYSIQUE     	=> '体质',
            self::USER_ATTRIBUTE_ENDURANCE    	=> '耐力',
            self::USER_ATTRIBUTE_QUICK        	=> '敏捷',
            self::USER_ATTRIBUTE_HIT          	=> '命中',
            self::USER_ATTRIBUTE_HURT         	=> '伤害',
            self::USER_ATTRIBUTE_MAGIC        	=> '魔法',
            self::USER_ATTRIBUTE_BLOOD        	=> '气血',
            self::USER_ATTRIBUTE_PSYCHIC      	=> '灵力',
            self::USER_ATTRIBUTE_SPEED        	=> '速度',
            self::USER_ATTRIBUTE_DEFENSE      	=> '防御',
            self::USER_ATTRIBUTE_DODGE        	=> '躲闪',
            self::USER_ATTRIBUTE_LUCKY        	=> '幸运',

            self::SKILL_ZJ      				=> '重击', 
            self::SKILL_LSYZ    				=> '灵犀一指',
            self::SKILL_SWZH    				=> '三昧真火', 
            self::SKILL_HFHY    				=> '呼风唤雨', 
            self::SKILL_WLJ     				=> '五雷决',
            self::SKILL_WFX     				=> '物防修', 
            self::SKILL_FFX     				=> '法防修', 
            self::SKILL_GX      				=> '攻修', 
            self::SKILL_FX      				=> '法修', 
            self::SKILL_DZ      				=> '锻造',
            self::SKILL_FY      				=> '防御', 
            self::SKILL_FJ      				=> '反击', 
            self::SKILL_FD      				=> '法盾',

            self::RELEASE_PROBABILITY		  	=> '释放概率',
		);
	}

}