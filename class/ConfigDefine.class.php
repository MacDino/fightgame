<?php
//公共属性定义
class ConfigDefine
{
	//用户属性定义
    CONST USER_ATTRIBUTE_POWER        	= 1101;//力量 - 基本属性
    CONST USER_ATTRIBUTE_MAGIC_POWER  	= 1102;//魔力 - 基本属性
    CONST USER_ATTRIBUTE_PHYSIQUE     	= 1103;//体质 - 基本属性
    CONST USER_ATTRIBUTE_ENDURANCE    	= 1104;//耐力 - 基本属性
    CONST USER_ATTRIBUTE_QUICK        	= 1105;//敏捷 - 基本属性

    CONST USER_ATTRIBUTE_HIT          	= 1106;//命中 - 成长属性
    CONST USER_ATTRIBUTE_HURT         	= 1107;//伤害 - 成长属性
    CONST USER_ATTRIBUTE_MAGIC        	= 1108;//魔法 - 成长属性
    CONST USER_ATTRIBUTE_BLOOD        	= 1109;//气血 - 成长属性
    CONST USER_ATTRIBUTE_PSYCHIC      	= 1110;//灵力 - 成长属性
    CONST USER_ATTRIBUTE_SPEED        	= 1111;//速度 - 成长属性
    CONST USER_ATTRIBUTE_DEFENSE      	= 1112;//防御 - 成长属性
    CONST USER_ATTRIBUTE_DODGE        	= 1113;//躲闪 - 成长属性
    CONST USER_ATTRIBUTE_LUCKY        	= 1114;//幸运 - 成长属性
    
     //其它
	CONST RELEASE_PROBABILITY 		  	= 1301;//释放概率

	//技能定义
	CONST SKILL_ZJ      				= 1201;//重击
	CONST SKILL_LJ      				= 1202;//连击
    CONST SKILL_LXYZ    				= 1203;//灵犀一指
    CONST SKILL_SWZH    				= 1204;//三昧真火
    CONST SKILL_HFHY    				= 1205;//呼风唤雨
    CONST SKILL_WLJ     				= 1206;//五雷决
    CONST SKILL_WFX     				= 1207;//物防修
    CONST SKILL_FFX     				= 1208;//法防修
    CONST SKILL_GX      				= 1209;//攻修
    CONST SKILL_FX      				= 1210;//法修
    CONST SKILL_DZ      				= 1211;//锻造
    CONST SKILL_FY      				= 1212;//防御
    CONST SKILL_FJ      				= 1213;//反击
    CONST SKILL_FD      				= 1214;//法盾
    CONST SKILL_TX						= 1215;//体修
    CONST SKILL_PT						= 1216;//普通攻击
    
    //战斗动作
    CONST PET                           = 7009;//人宠
    CONST YOU							= 7100;//你
    CONST VS							= 7101;//对
    CONST YUDAO							= 7102;//遇到了
    CONST SHIYONG						= 7103;//使用了
    CONST ZAOCHENG						= 7104;//造成了
    CONST DIAN							= 7105;//点
    CONST SHANGHAI						= 7106;//伤害
    CONST GONGJI						= 7107;//攻击
    CONST DUOBI							= 7108;//躲避
    CONST FANGYU						= 7109;//防御
    CONST CHENGGONG						= 7111;//成功
    CONST XURUO							= 7112;//虚弱
    CONST XIXIU							= 7113;//休息
    CONST HUIHE							= 7114;//回合
    CONST JIBAI							= 7121;//击败
    CONST BEIJIBAI						= 7122;//被击败
    CONST HUODE							= 7123;//获得
    CONST JINGYAN						= 7124;//经验
    CONST JINQIAN						= 7125;//金钱
    CONST MISS                          = 7126;//miss
    CONST CHUYU                         = 7127;//处于
    CONST ZHUANGTAI                     = 7128;//状态
    CONST BAOJI                         = 7129;//暴击
    CONST DI                            = 7130;//第

           

    CONST PK_NUM                        = 'pk_num';//PVP次数
    CONST USER_BASE_ATTRIBUTE           = 'user_base_attribute';//用户基本属性
    CONST USER_GROWUP_ATTRIBUTE         = 'user_growup_attribute';//用户成长属性

	public static function AttributeList()
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

            self::RELEASE_PROBABILITY		  	=> '释放概率',
		);
		return $configDefineNameList;
	}

	//技能静态资源
	public static function skillList(){
		$res = array(
			self::SKILL_ZJ      				=> '重击',
			self::SKILL_LJ      				=> '连击',
		    self::SKILL_LXYZ    				=> '灵犀一指',
		    self::SKILL_SWZH    				=> '三昧真火',
		    self::SKILL_HFHY    				=> '呼风唤雨',
		    self::SKILL_WLJ     				=> '五雷决',
		    self::SKILL_TX						=> '体修',
		    self::SKILL_WFX     				=> '物防修',
		    self::SKILL_FFX     				=> '法防修',
		    self::SKILL_GX      				=> '攻修',
		    self::SKILL_FX      				=> '法修',
		    self::SKILL_DZ      				=> '锻造',
		    self::SKILL_FY      				=> '防御',
		    self::SKILL_FJ      				=> '反击',
		    self::SKILL_FD      				=> '法盾',
		    self::SKILL_PT						=> '普通攻击',
		);
		return 	$res;
	}

	//战斗描述
	public static function actionList(){
		$res = array(
			self:: PET                          => '人宠',
			self::YOU							=> '你',
		    self::VS							=> '对',
		    self::YUDAO							=> '遇到',
		    self::SHIYONG						=> '使用',
		    self::ZAOCHENG						=> '造成',
		    self::DIAN							=> '点',
		    self::SHANGHAI						=> '伤害',
		    self::GONGJI						=> '攻击',
		    self::DUOBI							=> '躲避',
		    self::FANGYU						=> '防御',
		    self::CHENGGONG						=> '成功',
		    self::XURUO							=> '虚弱',
		    self::XIXIU							=> '休息',
		    self::HUIHE							=> '回合',
		    self::JIBAI							=> '击败',
		    self::BEIJIBAI						=> '被击败',
		    self::HUODE							=> '获得',
		    self::JINGYAN						=> '经验',
		    self::JINQIAN						=> '金钱',
		    self:: MISS                         => 'miss',
		    self:: CHUYU                        => '处于',
		    self:: ZHUANGTAI                    => '状态',
		    self:: BAOJI                        => '暴击',
		    self:: DI                           => '第',
		);
		return $res;
	}

	//前后缀描述
	//战斗描述
	public static function titleList(){
		$res = array(
			Monster::MONSTER_PREFIX_PUNY     => '弱小的',
			Monster::MONSTER_PREFIX_SLOW     => '缓慢的',
			Monster::MONSTER_PREFIX_ORDINARY => '普通的',
			Monster::MONSTER_PREFIX_POWERFUL => '强大的',
			Monster::MONSTER_PREFIX_QUICK    => '敏捷的',
		
			Monster::MONSTER_SUFFIX_BOSS         => 'Boss',
			Monster::MONSTER_SUFFIX_SACRED       => '圣灵',
			Monster::MONSTER_SUFFIX_UNKNOWN      => '领主',
			Monster::MONSTER_SUFFIX_ADVANCED     => '巨魔',
			Monster::MONSTER_SUFFIX_WILL_EXTINCT => '将领',
			Monster::MONSTER_SUFFIX_CURSED       => '魔王',
			Monster::MONSTER_SUFFIX_ANCIENT      => '长老',
			Monster::MONSTER_SUFFIX_HEAD         => '头头',
		);
		return $res;
	}
	
	public static function equipList(){
		$res = array(
			Equip::EQUIP_COLOUR_GRAY 	=> '灰色',
			Equip::EQUIP_COLOUR_WHITE 	=> '白色',
			Equip::EQUIP_COLOUR_GREEN 	=> '绿色',
			Equip::EQUIP_COLOUR_BLUE 	=> '蓝色',
			Equip::EQUIP_COLOUR_PURPLE 	=> '紫色',
			Equip::EQUIP_COLOUR_ORANGE 	=> '橙色',
						
			Equip::EQUIP_TYPE_ARMS 		=> '武器',
			Equip::EQUIP_TYPE_HELMET 	=> '头盔',
			Equip::EQUIP_TYPE_NECKLACE 	=> '项链',
			Equip::EQUIP_TYPE_CLOTHES 	=> '衣服',
			Equip::EQUIP_TYPE_BELT 		=> '腰带',
			Equip::EQUIP_TYPE_SHOES 	=> '鞋子',
			
			Equip::EQUIP_QUALITY_GENERAL 	=> '普通',
			Equip::EQUIP_QUALITY_ADVANCED 	=> '进阶',
			Equip::EQUIP_QUALITY_SUBLIME 	=> '升华',
			Equip::EQUIP_QUALITY_HOLY 		=> '圣品',
			
			Equip::EQUIP_BASE_ATTRIBUTE_GENERAL => '普通',
			Equip::EQUIP_BASE_ATTRIBUTE_HIGH 	=> '高',
			Equip::EQUIP_BASE_ATTRIBUTE_VH 		=> '很高',
		);
		return $res;
	}
//	public static function

}
