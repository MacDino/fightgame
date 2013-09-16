<?php
//和怪物相关的配置数据
class Monster_Config
{
    const TABLE_NAME = 'map_monster';

    /****
     * 获取最基本的属性分配
     */
	public static function getMonsterBaseAttributeList($level) {
		return array(
          ConfigDefine::USER_ATTRIBUTE_POWER       => $level + 10,//力量
          ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER => $level + 10,//魔力
          ConfigDefine::USER_ATTRIBUTE_PHYSIQUE    => $level + 10,//体质
          ConfigDefine::USER_ATTRIBUTE_ENDURANCE   => $level + 10,//耐力
          ConfigDefine::USER_ATTRIBUTE_QUICK       => $level + 10,//敏捷
        );
	}
	/***
     * 根据怪物的等级
     * 获取怪物基本属性和
     * 用于计算怪物的各个基本属性点
     */
	public static function getMonsterBaseAttributeTotal($level) {
		return 50 + $level*10;
	}

    public static function getList() {
        return Mysql::select(self::TABLE_NAME, NULL, NULL, array('monster_id ASC'));
    }
}
