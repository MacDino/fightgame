<?php
//和怪物相关的配置数据
class Monster_Config
{
    const TABLE_NAME = 'map_monster';

    /****
     * 获取每项基本属性的最低点数
     */
	public static function getMonsterBaseAttributeList($level) {
		return array(
          ConfigDefine::USER_ATTRIBUTE_POWER       => $level,//力量
          ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => $level,//魔力
          ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => $level,//体质
          ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => $level,//耐力
          ConfigDefine::USER_ATTRIBUTE_QUICK       => $level,//敏捷
        );
	}
	/***
     * 根据怪物的等级
     * 获取怪物基本属性和
     * 用于计算怪物的各个基本属性点
     */
	public static function getMonsterBaseAttributeTotal($level) {
		return $level*10;
	}

    public static function getList() {
        return MySql::select(self::TABLE_NAME, NULL, NULL, array('monster_id ASC'));
    }
}
