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
    const JINENG                        = 7131;//技能
    const MINGZHONG                     = 7132;//命中
    const WUFA                          = 7133;//无法
    const WULI                          = 7134;//物理
    CONST FASHU                         = 7135;//法术
    CONST CHIXU                         = 7136;//持续
    const ZENGJIA                       = 7137;//增加
    const XUE                           = 7138;//血
    CONST LAN                           = 7139;//蓝
    const LINGLI                        = 7140;//灵力
    const SHANGHAISHUXING               = 7141;//伤害属性
    const FENGYIN                       = 7142;//封印
    CONST JIECHU                        = 7143;//解除
    CONST FUHUO                         = 7144;//复活
    CONST DIYU                          = 7145;//低于
    const SIWANG                        = 7146;//死亡



            //资质类型
	CONST APTITUDE_TYPE_ATTACK  =  8101;	//攻击资质
	CONST APTITUDE_TYPE_DEFENSE =  8102; 	//防御资质
	CONST APTITUDE_TYPE_FASHU   =  8103; 	//法术资质

	//资质
	CONST APTITUDE_ATTACK   = 8201;			//攻击资质
	CONST APTITUDE_DEFENSE  = 8202;			//防御资质
	CONST APTITUDE_PHYSICAL = 8203;			//体力资质
	CONST APTITUDE_MAGIC	= 8204;			//魔力资质
	CONST APTITUDE_SPEED	= 8205;			//速度资质
	CONST APTITUDE_DODGE    = 8206;			//躲闪资质


    CONST PK_NUM                        = 'pk_num';//PVP次数
    CONST USER_BASE_ATTRIBUTE           = 'user_base_attribute';//用户基本属性
    CONST USER_GROWUP_ATTRIBUTE         = 'user_growup_attribute';//用户成长属性

    /** 属性 */
	public static function AttributeList()
	{
		$res = array(
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
		return $res;
	}

	/** 技能 */
	public static function skillList(){
                $res = array(
                        NewSkill::SKILL_DEFAULT_PT              => '普通攻击',
                        NewSkill::SKILL_COMMON_BD_WFX           => '物防修',
                        NewSkill::SKILL_COMMON_BD_FFX           => '法防修',
                        NewSkill::SKILL_COMMON_BD_WGX           => '物攻修',
                        NewSkill::SKILL_COMMON_BD_FGX           => '法攻修',
                        NewSkill::SKILL_COMMON_BD_TX            => '体修',
                        NewSkill::SKILL_COMMON_BD_DZ            => '锻造',
                        NewSkill::SKILL_HUMAN_GJ_DTWLGJ         => '连击',
                        NewSkill::SKILL_HUMAN_GJ_WGK            => '物理封印',
                        NewSkill::SKILL_HUMAN_GJ_FGK            => '法术封印',
                        NewSkill::SKILL_HUMAN_GJ_JL             => '天地正气',
                        NewSkill::SKILL_HUMAN_GJ_DJX            => '妙手回春',
                        NewSkill::SKILL_HUMAN_FY_FJ             => '反击',
                        NewSkill::SKILL_TSIMSHIAN_GJ_DTFSGJ			=> '三昧真火',
                        NewSkill::SKILL_TSIMSHIAN_GJ_QTFSGJ			=> '呼风唤雨',
                        NewSkill::SKILL_TSIMSHIAN_GJ_XR         => '虚弱',
                        NewSkill::SKILL_TSIMSHIAN_GJ_QJX        => '普降甘霖',
                        NewSkill::SKILL_TSIMSHIAN_GJ_QJSH       => '伤害增益',
                        NewSkill::SKILL_TSIMSHIAN_FY_ZJ         => '仙风护体',
                        NewSkill::SKILL_DEMON_GJ_DTGJ           => '怒斩',
                        NewSkill::SKILL_DEMON_GJ_QTGJ           => '横扫千军',
                        NewSkill::SKILL_DEMON_GJ_JCK            => '净化',
                        NewSkill::SKILL_DEMON_GJ_FH             => '起死回生',
                        NewSkill::SKILL_DEMON_GJ_QJL            => '灵力增益',
                        NewSkill::SKILL_DEMON_FY_FZ             => '反震',
                );
                return  $res;
        }

		/** 技能描述 **/
	public static function skillDescList(){
		$res = array(
			'desc' . NewSkill::SKILL_DEFAULT_PT 			=> '普通攻击',
			'desc' . NewSkill::SKILL_COMMON_BD_WFX 		=> '提高物理防御能力',
			'desc' . NewSkill::SKILL_COMMON_BD_FFX 		=> '提高法术防御能力（影响控制类法术命中结果）',
			'desc' . NewSkill::SKILL_COMMON_BD_WGX 		=> '提高物理攻击伤害效果',
			'desc' . NewSkill::SKILL_COMMON_BD_FGX 		=> '提高法术攻击能力（影响增益类法术计算结果及控制类法术命中结果）',
			'desc' . NewSkill::SKILL_COMMON_BD_TX		=> '增加角色气血上限',
			'desc' . NewSkill::SKILL_COMMON_BD_DZ		=> '锻造',
			'desc' . NewSkill::SKILL_HUMAN_GJ_DTWLGJ 	=> '连续攻击对方3次，使用后需休息一回合，休息时不能使用战斗指令，也不会受封类法术影响；物理法术防御降低为正常状态的80%；防御技能不受影响。',
			'desc' . NewSkill::SKILL_HUMAN_GJ_WGK 		=> '令对手一定回合无法使用物理攻击，并减少物理防御力',
			'desc' . NewSkill::SKILL_HUMAN_GJ_FGK 		=> '令对手一定回合无法使用法术攻击，并减少法术防御力',
			'desc' . NewSkill::SKILL_HUMAN_GJ_JL 		=> '一定回合内补充自己和队友的魔法，血量小于50无法使用此技能。',
			'desc' . NewSkill::SKILL_HUMAN_GJ_DJX 		=> '使用后可以恢复自身和队友的气血',
			'desc' . NewSkill::SKILL_HUMAN_FY_FJ 		=> '受到物理攻击时有一定的几率自动反击，反击的伤害与正常攻击相同，人物死亡后无法生效。',
			'desc' . NewSkill::SKILL_TSIMSHIAN_GJ_DTFSGJ => '施展法术攻击对方单人',
			'desc' . NewSkill::SKILL_TSIMSHIAN_GJ_QTFSGJ => '施展法术攻击对方，技能达到一定等级后可攻击多人',
			'desc' . NewSkill::SKILL_TSIMSHIAN_GJ_XR 	=> '可以解除物攻控、法功控、虚弱的技能效果。',
			'desc' . NewSkill::SKILL_TSIMSHIAN_GJ_QJX 	=> '使用后可以恢复多人的气血',
			'desc' . NewSkill::SKILL_TSIMSHIAN_GJ_QJSH 	=> '战斗中临时提高自己或队友的伤害力，技能等级较高后可作用于多人。',
			'desc' . NewSkill::SKILL_TSIMSHIAN_FY_ZJ 	=> '受到攻击后有一定的几率降低所受伤害。',
			'desc' . NewSkill::SKILL_DEMON_GJ_DTGJ 		=> '以高于平时的伤害力攻击对方单人',
			'desc' . NewSkill::SKILL_DEMON_GJ_QTGJ 		=> '攻击对方多人，使用后需要休息1回合',
			'desc' . NewSkill::SKILL_DEMON_GJ_JCK 		=> '施展法术攻击对方，每回合减少对手气血。',
			'desc' . NewSkill::SKILL_DEMON_GJ_FH 		=> '使用后可以复活已经死亡的队友',
			'desc' . NewSkill::SKILL_DEMON_GJ_QJL 		=> '战斗中临时提高自己或队友的灵力，技能等级较高后可作用于多人。',
			'desc' . NewSkill::SKILL_DEMON_FY_FZ 		=> '受到物理攻击时有一定的几率造成反震，反震的伤害与受到的攻击伤害相同，人物死亡后无法生效。',
		);
		return 	$res;
	}


	/** 战斗 */
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
            self::JINENG                        => '技能',
            self::MINGZHONG                     => '命中',
            self::WUFA                          => '无法',
            self::WULI                          => '物理',
            self::FASHU                         => '法术',
            self::CHIXU                         =>'持续',
            self::ZENGJIA                       => '增加',
            self::XUE                           => '血',
            self::LAN                           => '蓝',
            self::LINGLI                        => '灵力',
            self::SHANGHAISHUXING               => '伤害属性',
            self::FENGYIN                       => '封印',
            self::JIECHU                        => '解除',
            self::FUHUO                         => '复活',
            self::DIYU                          => '低于',
            self::SIWANG                        => '死亡',
		);
		return $res;
	}

	/** 前后缀 */
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

	/** 装备 */
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

	/** 内丹 */
	public static function pillList(){
		$res = array(
			Pill::TIANSHUNEIDAN => '天枢',
			Pill::TIANXUANNEIDAN => '天璇',
			Pill::TIANJINEIDAN => '天玑',
			Pill::TIANQUANNEIDAN => '天权',
			Pill::YUHENGNEIDAN => '玉衡',
		);
		return $res;
	}

	/*
	 * 资质类型
	 */
	public static function aptitudeTypeList(){
		$res = array (
			self::APTITUDE_TYPE_ATTACK  => '攻击型',
			self::APTITUDE_TYPE_DEFENSE => '防御型',
			self::APTITUDE_TYPE_FASHU   => '法术型',
		);
		return $res;
	}

	public static function aptitudeList(){
		$res = array(
			self::APTITUDE_ATTACK   => '攻击资质',
			self::APTITUDE_DEFENSE  => '防御资质',
			self::APTITUDE_PHYSICAL => '体力资质',
			self::APTITUDE_MAGIC 	=> '魔力资质',
			self::APTITUDE_SPEED	=> '速度资质',
			self::APTITUDE_DODGE	=> '躲闪资质'
		);
		return $res;
	}

	/*
	 * 获取不同类型资质的配置
	 */
	public static function getAptitudeConfig($mapId){
		$mapId = intval($mapId);
		$res = array(
			self::APTITUDE_TYPE_ATTACK  => self::getAttackAptitudeConfig($mapId),
			self::APTITUDE_TYPE_DEFENSE => self::getDefenseAptitudeConfig($mapId),
			self::APTITUDE_TYPE_FASHU   => self::getFashuAptitudeConfig($mapId),
		);
		return $res;
	}

	/*
	 * 获取攻击型资质基础值和公式
	 */
	public static function getAttackAptitudeConfig ($mapId) {
		$config = array(
			self::APTITUDE_ATTACK => array(
				'base_value' => 1400,
				'formule'	 => 1400 + ($mapId - 1)	* 10,
			),
			self::APTITUDE_DEFENSE => array(
				'base_value' => 1000,
				'formule'	 => 1000 + ($mapId - 1)	* 10,
			),
			self::APTITUDE_PHYSICAL => array(
				'base_value' => 2000,
				'formule'	 => 2000 + ($mapId - 1)	* 110,
			),
			self::APTITUDE_MAGIC => array(
				'base_value' => 1400,
				'formule'	 => 1400 + ($mapId - 1)	* 60,
			),
			self::APTITUDE_SPEED => array(
				'base_value' => 1000,
				'formule'	 => 1000 + ($mapId - 1)	* 30,
			),
			self::APTITUDE_DODGE => array(
				'base_value' => 1000,
				'formule'	 => 1000 + ($mapId - 1)	* 30,
			),
		);
		return $config;
	}
	/*
	 * 获取防御型资质基础值和公式
	 */
	public static function getDefenseAptitudeConfig ($mapId) {
		$config = array(
			self::APTITUDE_ATTACK => array(
				'base_value' => 1100,
				'formule'	 => 1100 + ($mapId - 1)	* 10,
			),
			self::APTITUDE_DEFENSE => array(
				'base_value' => 1400,
				'formule'	 => 1400 + ($mapId - 1)	* 10,
			),
			self::APTITUDE_PHYSICAL => array(
				'base_value' => 3000,
				'formule'	 => 3000 + ($mapId - 1)	* 110,
			),
			self::APTITUDE_MAGIC => array(
				'base_value' => 1500,
				'formule'	 => 1500 + ($mapId - 1)	* 60,
			),
			self::APTITUDE_SPEED => array(
				'base_value' => 1000,
				'formule'	 => 1000 + ($mapId - 1)	* 30,
			),
			self::APTITUDE_DODGE => array(
				'base_value' => 1000,
				'formule'	 => 1000 + ($mapId - 1)	* 30,
			),
		);
		return $config;
	}
	/*
	 * 获取法术型资质基础值和公式
	 */
	public static function getFashuAptitudeConfig ($mapId) {
		$config = array(
			self::APTITUDE_ATTACK => array(
				'base_value' => 1100,
				'formule'	 => 1100 + ($mapId - 1)	* 10,
			),
			self::APTITUDE_DEFENSE => array(
				'base_value' => 1100,
				'formule'	 => 1100 + ($mapId - 1)	* 10,
			),
			self::APTITUDE_PHYSICAL => array(
				'base_value' => 2000,
				'formule'	 => 2000 + ($mapId - 1)	* 110,
			),
			self::APTITUDE_MAGIC => array(
				'base_value' => 1900,
				'formule'	 => 1900 + ($mapId - 1)	* 60,
			),
			self::APTITUDE_SPEED => array(
				'base_value' => 1000,
				'formule'	 => 1000 + ($mapId - 1)	* 30,
			),
			self::APTITUDE_DODGE => array(
				'base_value' => 1000,
				'formule'	 => 1000 + ($mapId - 1)	* 30,
			),
		);
		return $config;
	}
}
