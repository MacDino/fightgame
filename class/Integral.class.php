<?php
class Integral{
	
	CONST TABLE_NAME = 'integral_info';//积分流水表
	/** 战斗获得积分 */
	CONST FIGHT_INTEGRAL = 2;
	/** 抽奖使用积分 */
	CONST EXTRACTION_INTEGRAL = 25;
	
	
	
	/** @desc获取积分流水表 */
	public static function listIntegralInfoById($userId){
		if(!$userId)return ;
		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}
	
	/**
	 * 增加积分动作
	 * @param int $userId	
	 * @param int $type		增加1减少	2
	 * @param int $num		数量
	 * @param int $action	动作(1战斗奖励,2积分抽奖)
	 */
	private static function addIntegralAction($userId, $type, $num, $action){
		if(!$userId || !$type || !$num || !$action)return ;
		$integral = self::getTodayResidueIntegral($userId);
		if($type == 1){$after = $integral + $num;}
		if($type == 2){$after = $integral - $num;}
		$res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'type' => $type, 'num' => $num, 'action' => $action, 'before' => $integral, 'after' => $after, 'time' => time()));
		return $res;
	}
	
	/** @desc 查询今日获得积分*/
	public static function getTodayIntegral($userId){
		if(!$userId)return ;
		$num = 0;
		$beginTime = strtotime(date("Y-m-d 00:00:00"));
		$endTime = strtotime(date("Y-m-d 23:59:59"));
		$sql = "SELECT num FROM " . self::TABLE_NAME . " WHERE time >= '$beginTime' AND time <= '$endTime' AND user_id = '$userId' AND type = 1";
		$res = MySql::query($sql);
		if(is_array($res)){
			foreach ($res as $i){
				$num += $i['num'];
			}
		}
		return $num;
	}
	
	/** @desc 查询今日剩余积分*/
	public static function getTodayResidueIntegral($userId){
		if(!$userId)return ;
		$num = 0;//积分
		$beginTime = strtotime(date("Y-m-d 00:00:00"));
		$endTime = strtotime(date("Y-m-d 23:59:59"));
		
		//获得积分
		$get = "SELECT num FROM " . self::TABLE_NAME . " WHERE time >= '$beginTime' AND time <= '$endTime' AND user_id = '$userId' AND type = 1";
		$get = MySql::query($get);
		if(is_array($get)){
			foreach ($get as $i){
				$num += $i['num'];
			}
		}
		//使用积分
		$use = "SELECT num FROM " . self::TABLE_NAME . " WHERE time >= '$beginTime' AND time <= '$endTime' AND user_id = '$userId' AND type = 2";
		$use = MySql::query($use);
		if(is_array($use)){
			foreach ($use as $i){
				$num -= $i['num'];
			}
		}
		
		return $num;
	}
	
	//战斗获取积分
	public static function fightIntegral($userId, $num = self::FIGHT_INTEGRAL){
		$res = self::addIntegralAction($userId, 1, $num, '战斗获得');
		Reward::integral($userId);//调用积分奖励,判断是否激活新奖励
		return $res;
	}
	
	/** 抽奖使用积分 */
	public static function extractionIntegral($userId){
		$res = self::addIntegralAction($userId, 2, self::EXTRACTION_INTEGRAL, '抽奖消耗');
		return $res;
	}
	
	/** @desc 积分抽奖 */
	public static function integralLucky($userId){
		//校验
		$num = self::getTodayResidueIntegral($userId);
		/*if($num < self::EXTRACTION_INTEGRAL){
			return false;
		}*/
		
		$array = array('money', 'ingot');
		$function = $array[array_rand($array)];
		$res = call_user_func(array('rewardType', $function), $userId, 100);
		
		if($res){
			self::extractionIntegral($userId);
			return $res;
		}else{
			false;
		}
	}
}
