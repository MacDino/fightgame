<?php
//精铁
class Iron_Info {
	CONST TABLE_NAME = 'iron_info';
	
	/** @desc 增加精铁 */
	public static function addIron($userId, $level){
		$num = self::getIronNumByLevel($userId, $level);
		if(!empty($num)){
			$res = MySql::update(self::TABLE_NAME, array('num' => $num+1), array('user_id' => $userId, 'level' => $level));
		}else{
			$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'level' => $level, 'num' => 1));
		}
		
		return $res;
	}
	
	/** @desc 减少精铁 */
	public static function subtractIron($userId, $level, $num = 1){
		$res = MySql::update(self::TABLE_NAME, array('num' => 'num'-$num), array('user_id' => $userId, 'level' => $level));
		return $res;
	}
	
	/** @desc 查询精铁 */
	public static function getIronInfo($userId){
		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}
	
	/** @desc 查询单种精铁数量 */
	public static function getIronNumByLevel($userId, $level){
		$res = MySql::selectCount(self::TABLE_NAME, array('user_id' => $userId, 'level' => $level));
		return $res;
	}
	
	/** @desc 出售价格 */
	public static function ironPrice($level, $num = 1){
		$res = $level * 1000 * 1.33 + 7;
		return $res * $num;
	}
	
}