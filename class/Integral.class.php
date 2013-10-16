<?php
class Integral{
	
	CONST TABLE_NAME = 'integral_info';//积分流水表
	/** 战斗获得积分 */
	CONST FIGHT_INTEGRAL = 2;
	/** 抽奖使用积分 */
	CONST EXTRACTION_INTEGRAL = 25;
	
	/** @desc 技能点 */
	public static function prize1($userId){
		$res = User_Info::addIngot($userId, 1);
		return '技能点';
	}
	
	/** @desc 内丹精华 */
	public static function prize2($userId){
		$type = array_rand(ConfigDefine::pillList());
		$res = Pill_Stone::addStone($userId, $type);
		return $type.'精华';
	}
	
	/** @desc 精铁 */
	public static function prize3($userId){
		$level = rand(1,10);
		$res = Pill_Iron::addIron($userId, $level);
		return $level."级精铁";
	}
	
	/** @desc 符咒 */
	public static function prize4($userId){
		$array = array(6301, 6302, 6303, 6306, 6308, 6309);
		$type = array_rand($array);
		$res = User_Property::addAmulet($userId, $type, 1);
		return $type;
	}
	
	/** @desc 暂空 */
	public static function prize5($userId){
		return 1;		
	}
	
	/** @desc 上古遗迹 */
	public static function prize6($userId){
		$userInfo = User_Info::getUserInfoByUserId($userId);
		$level = intval($userInfo['user_level']/10);
		$colour = User_Property::randGeneralEquipColor();
		$equipId = Equip_Create::createEquip($colour, $userId, $level);
		$res = Equip_Info::getEquipInfoById($equipId);
		return $res;
	}
	
	/** @desc 金币 */
	public static function prize7($userId){
		$num = rand(10000,1000000);
		$res = User_Info::addMoney($userId, $num);
		return '金币'.$num."个";
	}
	
	/** @desc 元宝 */
	public static function prize8($userId){
		$num = rand(1,100);
		$res = User_Info::addIngot($userId, $num);
		return '元宝'.$num."个";
	}
	
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
		$integral = self::getIntegralInfobyId($userId);
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
		$endTime = strtotime(data("Y-m-d 23:59:59"));
		
		//获得积分
		$get = "SELECT num FROM " . self::TABLE_NAME . " WHERE time >= '$beginTime' AND time <= '$endTime' AND user_id = '$userId' AND type = 1";
		$get = MySql::query($get);
		if(is_array($get)){
			foreach ($get as $i){
				$num += $i['num'];
			}
		}
		//使用积分
		$use = "SELECT num FROM " . self::TABLE_NAME . " WHERE time >= '$beginTime' AND time <= '$endTime' AND user_id = '$userId' AND type = 1";
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
	
	/** @desc 生成积分奖励 */
	
	/** @desc 积分抽奖 */
	public static function intergralLucky($userId){
		//校验
		$num = self::getTodayResidueIntegral($userId);
		if($num < self::EXTRACTION_INTEGRAL){
			return false;
		}
		
		$rand = rand(1,8);
		$function = 'prize'.$rand;
		$res = self::$function;
		
		if($res){
			self::extractionIntegral($userId);
			return $res;
		}else{
			false;
		}
	}
}
