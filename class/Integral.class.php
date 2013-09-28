<?php
class Intergral{
	
	CONST INTEGRAL_INFO = '';//积分信息表
	CONST INTEGRAL_LIST = '';//积分流水表
	
	CONST FIGHT_INTEGRAL = 1;//战斗积分
	CONST EXTRACTION_INTEGRAL = 100;//抽奖积分
	
	//获取积分流水表
	public static function listIntegralInfoById($userId){
		if(!$userId)return ;
		$res = MySql::select(self::INTEGRAL_LIST, array('user_id' => $userId));
		return $res;
	}
	
	/**
	 * 增加积分动作
	 *
	 * @param int $userId	
	 * @param int $type		增加1减少	2
	 * @param int $num		数量
	 * @param int $action	动作(1战斗奖励,2积分抽奖)
	 */
	private static function addIntegralAction($userId, $type, $num, $action){
		if(!$userId || !$type || !$num || !$action)return ;
		$integral = self::getIntegralInfobyId($userId);
		if($type == 1){$after = $integral + $num;}
		if($type == 2){$after = $integral - $num;}
		$res = MySql::insert(self::INTEGRAL_LIST, array('user_id' => $userId, 'type' => $type, 'num' => $num, 'action' => $action, 'before' => $integral, 'after' => $after, 'time' => time()));
		return $res;
	}
	
	/** @desc 获取今日积分*/
	public static function getTodayIntegral($userId){
		if(!$userId)return ;
		$num = 0;
		$beginTime = strtotime(date("Y-m-d 00:00:00"));
		$endTime = strtotime(data("Y-m-d 23:59:59"));
		$res = "SELECT num FROM " . self::INTEGRAL_LIST . " WHERE time >= '$beginTime' AND time <= '$endTime' AND user_id = '$userId' AND type = 1";\
		if(is_array($res)){
			foreach ($res as $i){
				$num += $i['num'];
			}
		}
		return $num;
	}
	
	//获取用户总积分
	public static function getIntegralInfobyId($userId){
		if(!$userId)return ;
		$res = MySql::selectOne(self::INTEGRAL_INFO, array($userId), array('integral'));
		return $res['integral'];
	}
	
	//增加积分
	public static function addIntegralInfo($userId, $num){
		if(!$userId || !$num)return ;
		$sql = "UPDATE " . self::INTEGRAL_INFO . "SET integral = integral + " . $num . " WHERE user_id = ". $userId;
		return MySql::query($sql);
	}
	
	//减少积分
	public static function reduceIntegralInfo($userId, $num){
		if(!$userId || !$num)return ;
		$sql = "UPDATE " . self::INTEGRAL_INFO . "SET integral = integral - " . $num . " WHERE user_id = ". $userId;
		return MySql::query($sql);
	}
	
	//战斗获取积分
	public static function fightIntegral($userId){
		$res_list = self::addIntegralAction($userId, 1, self::FIGHT_INTEGRAL, 1);
		$res_num  = self::addIntegralInfo($userId, self::FIGHT_INTEGRAL);
		if($res_list && $res_num){
			return true;
		}else {
			return FALSE;
		}
	}
	
	//抽奖使用积分
	public static function extractionIntegral($userId){
		$res_list = self::addIntegralAction($userId, 2, self::EXTRACTION_INTEGRAL, 2);
		$res_num  = self::reduceIntegralInfo($userId, self::EXTRACTION_INTEGRAL);
		if($res_list && $res_num){
			return true;
		}else {
			return FALSE;
		}
	}
}
