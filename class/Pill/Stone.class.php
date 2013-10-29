<?php
//阵法石
class Pill_Stone {
	
	CONST TABLE_NAME = 'stone_info';
	
	/** @desc 增加阵法石 */
	public static function addStone($userId, $type, $num=1){
		$nownum = self::getStoneNumBytype($userId, $type);
//		echo $nownum;
		if($nownum === false){
			$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'stone_type' => $type, 'num' => $num));
		}else{
			$res = MySql::update(self::TABLE_NAME, array('num' => $nownum+$num), array('user_id' => $userId, 'stone_type' => $type));
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
		$sql = "select * from " . self::TABLE_NAME . " where user_id = '$userId' and num <> 0";
		$res = MySql::query($sql);
		return $res;
	}
	
	/** @desc 查询单种阵法石数量 */
	public static function getStoneNumBytype($userId, $type){
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'stone_type' => $type), array('num'));
		if(!empty($res)){
			return $res['num'];
		}else{
			return false;
		}
	} 

	/** @desc 出售价格 */
	public static function stonePrice($stoneType, $num = 1){
		$res = 10000;
		return $res * $num;
	}
}