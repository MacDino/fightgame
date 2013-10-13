<?php
//内丹
class Pill_Info {
	CONST TABLE_NAME = 'pill_info';

	//内丹属性计算
	
	//内丹列表
	public static function listPill($userId){
		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}
	
	//内丹出售
	
	//内丹价格
	
	/** @desc 内丹信息 */
	public static function getPillInfoById($pillId){
		$res = MySql::selectOne(self::TABLE_NAME, array('pill_id' => $pillId));
		return $res;
	}
	
	//内丹合成
	public static function compoundPill($userId, $pillType){
		$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'pill_type' => $pillType), true);
		return $res;
	}
	
	//内丹升级
	public static function upgradePill($pillId, $layer, $level){
		$res = MySql::update(self::TABLE_NAME, array('pill_layer' => $layer, 'pill_level' => $level), array('pill_id' => $pillId));
		return $res;
	}
	
	/** @desc 合成内丹消耗 */
	public static function compoundPillExpend($layer, $level){
		$res['iron'] = ($layer*10 + $level) * 2 - 1;
		$res['stone']= $layer*10 + $level;
		$res['money']= ($layer*10 + $level) * 888 - 37;
		
		return $res;
	}
}