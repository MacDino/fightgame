<?php
class User
{
	/** 初始化用户的等级*/
    CONST DEFAULT_USER_LEVEL = 0;
    /** 默认元宝数*/
    CONST DEFAULT_INGOT    = 0;
    /** 默认金钱数*/
    CONST DEFAULT_MONEY = 0;
	/** 默认经验数*/
    CONST DEFAULT_EXP  = 0;
    /** @desc 默认技能点 */
    CONST DEFAULT_SKILL = 3;
    /** @desc 默认声望数 */
    CONST DEFAULT_REPUTATION = 0;
    
    /** 好友数量原始上限,可增加*/
    CONST DEFAULT_FRIEND_NUM = 20;
    /** 最大好友数*/
    CONST DEFAULT_FRIEND_MAX = 999;
    /** 好友数价格*/
    CONST FRIEND_PRICE = 100;
    
    /** 默认背包数量*/
    CONST DEFAULT_PACK_NUM = 40;
    /** 最大背包数*/
    CONST DEFAULT_PACK_MAX = 999;
    /** 背包数价格,5个*/
    CONST PACK_PRICE = 50;
    
    /** 默认人宠数量上限,可增加*/
    CONST DEFAULT_PET_NUM  = 10;
    /** 最大人宠数*/
    CONST DEFAULT_PET_MAX  = 999;
    /** 人宠数价格*/
    CONST PET_PRICE = 10;
    
    /** PK最大购买次数*/
    CONST PK_BUY_NUM = 10;
    /** PK次数价格*/
    CONST PK_PRICE = 10;
    
	/** 属性增强符咒增益*/
    CONST ATTEIBUTEENHANCE = '0.05';
    /** 属性相生增益*/
    CONST ATTEIBUTEBEGETS	= '0.03';
    /** 属性相克损失*/
    CONST ATTEIBUTERESTRAINT= '0.03';
    
    /** 属性增强,有效期.24小时*/
    CONST ATTEIBUTEENHANCETIME = 86400;
    /** 双倍收益,有效期2小时*/
    CONST DOUBLEHARVESTTIME = 7200;
    /** 挂机,有效期2小时*/
    CONST AUTOFIGHTTIME = 7200;
    
    CONST FORGEODDS = '0.1';
    
    /** @desc 人宠有效期*/
    CONST VALIDITY_TIME = 86400;

    //获取登录用户的唯一标识
    public static function getLoginUserId($bindType, $bindValue)
    {
        return User_Bind::getBindUserId($bindType, $bindValue, TRUE); 
    }
}
