<?php
//阵法石
class Pill_Stone {
	
	CONST TABLE_NAME = 'stone_info';
	
	/** @desc 增加阵法石 */
	public static function addStone($userId, $type, $num=1){
		$nownum = self::getStoneNumBytype($userId, $type);
		if(!empty($nownum)){
			$res = MySql::update(self::TABLE_NAME, array('num' => $nownum+$num), array('user_id' => $userId, 'stone_type' => $type));
		}else{
			$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'stone_type' => $type, 'num' => $num));
		}
		
		return $res;
	}
	
	/** @desc 减少阵法石 */
	public static function subtractStone($userId, $type, $num = 1){
		$numNow = self::getStoneNumBytype($userId, $type);
		$res = MySql::update(self::TABLE_NAME, array('num' => $numNow-$num), array('user_id' => $userId, 'stone_type' => $type));
		return $res;
	}
	
	/** @desc 查询阵法石 */
	public static function getStoneInfo($userId){
		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}
	
	/** @desc 查询单种阵法石数量 */
	public static function getStoneNumBytype($userId, $type){
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'stone_type' => $type), array('num'));
		return $res['num'];
	} 

	/** @desc 出售价格 */
	public static function stonePrice($stoneType, $num = 1){
		$res = 10000;
		return $res * $num;
	}
}