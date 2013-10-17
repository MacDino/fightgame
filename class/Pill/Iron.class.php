<?php
//精铁
class Pill_Iron {
	CONST TABLE_NAME = 'iron_info';
	
	/** @desc 增加精铁 */
	public static function addIron($userId, $level, $num=1){
		$nownum = self::getIronNumByLevel($userId, $level);
//		echo $num;
		if(!empty($num)){
			$res = MySql::update(self::TABLE_NAME, array('num' => $nownum+$num), array('user_id' => $userId, 'level' => $level));
		}else{
			$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'level' => $level, 'num' => $num));
		}
		
		return $res;
	}
	
	/** @desc 减少精铁 */
	public static function subtractIron($userId, $level, $num = 1){
		$numNow = self::getIronNumByLevel($userId, $level);
		$res = MySql::update(self::TABLE_NAME, array('num' => $numNow-$num), array('user_id' => $userId, 'level' => $level));
		return $res;
	}
	
	/** @desc 查询精铁 */
	public static function getIronInfo($userId){
		$sql = "select * from " . self::TABLE_NAME . " where user_id = '$userId' and num <> 0";
		$res = MySql::query($sql);
		return $res;
	}
	
	/** @desc 查询单种精铁数量 */
	public static function getIronNumByLevel($userId, $level){
//		echo $level;
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId, 'level' => $level), array('num'));
		if(!empty($res['num'])){
			return $res['num'];
		}else{
			return 0;
		}
	}
	
	/** @desc 出售价格 */
	public static function ironPrice($level, $num = 1){
		$res = $level * 1000 * 1.33 + 7;
		return $res * $num;
	}
	
}