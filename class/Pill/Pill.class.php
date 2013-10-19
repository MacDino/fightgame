<?php
//内丹
class Pill_Pill {
	CONST TABLE_NAME = 'pill_info';

	//内丹列表
	public static function listPill($userId){
		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}
	
	/** @desc 内丹信息 */
	public static function getPillInfoById($pillId){
		$res = MySql::selectOne(self::TABLE_NAME, array('pill_id' => $pillId));
		return $res;
	}
	
	//内丹合成
	public static function compoundPill($userId, $pillType){
		$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'pill_type' => $pillType));
		return $res;
	}
	
	//内丹升级
	public static function upgradePill($pillId, $layer, $level){
		$res = MySql::update(self::TABLE_NAME, array('pill_layer' => $layer, 'pill_level' => $level), array('pill_id' => $pillId));
		return $res;
	}
	
	/** @desc 合成内丹消耗 */
	public static function compoundPillExpend($layer, $level, $pillType){
//		echo "layer==$layer, level==$level";
		$res['level'] = $layer;
		$res['iron'] = (($layer-1)*10 + $level) * 2 - 1;
		$res['type'] = $pillType;
		$res['stone']= ($layer-1)*10 + $level;
		$res['money']= (($layer-1)*10 + $level) * 888 - 37;
		
		return $res;
	}
	
	/** @desc 已装备内丹 */
	public static function usedPill($userId){
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'is_used' => 1));
		return $res;
	}
	
	/** @desc 使用内丹 */
	public static function usePill($userId, $pillId){
		//把正在使用的置为未使用
		$old = MySql::update(self::TABLE_NAME, array('is_used' => 0), array('is_used' => 1, 'user_id' => $userId));
		//把新的弄成使用
		$res = MySql::update(self::TABLE_NAME, array('is_used' => 1), array('pill_id' => $pillId));
		return $res;
	}
	
}