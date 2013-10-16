<?php
class Rewardtype{
	
	/** @desc 技能点 */
	public static function skillPoint($userId, $num=1){
		$res = User_Info::addIngot($userId, $num);
		return '技能点'.$num;
	}
	
	/** @desc 内丹精华 */
	public static function pillStone($userId, $num=1, $type=NULL){
		if(empty($type)){
			$type = array_rand(ConfigDefine::pillList());
		}
		$res = Pill_Stone::addStone($userId, $type, $num);
		return $type.'精华'.$num;
	}
	
	/** @desc 精铁 */
	public static function pillIron($userId, $num=1, $level=NULL){
		if(empty($level)){
			$level = rand(1,10);
		}
		$res = Pill_Iron::addIron($userId, $level);
		return $level."级精铁".$num;
	}
	
	/** @desc 消费道具 */
	public static function props($userId, $num=1, $type=NULL){
		if(empty($type)){
			$array = array(6301, 6302, 6303, 6306, 6308, 6309);
			$type = $array[array_rand($array)];
		}

		$res = User_Property::updateNumIncreaseAction($userId, $type, $num);
		return $type.$num."个";
	}
	
	/** @desc 上古遗迹 */
	public static function box($userId, $num=1, $level=null){
		if(empty($level)){
			$userInfo = User_Info::getUserInfoByUserId($userId);
			$level = intval($userInfo['user_level']/10);
		}
		for($i=0;$i<$num;$i++){
			$colour = User_Property::randGeneralEquipColor();
			$equipId = Equip_Create::createEquip($colour, $userId, $level);
			$res[$i] = Equip_Info::getEquipInfoById($equipId);
		}
		return $res;
	}
	
	/** @desc 金币 */
	public static function money($userId, $num=null){
		if(empty($num)){
			$num = rand(10000,1000000);
		}
		$res = User_Info::addMoney($userId, $num);
		return '金币'.$num."个";
	}
	
	/** @desc 元宝 */
	public static function ingot($userId, $num=null){
		if(empty($num)){
			$num = rand(1,100);
		}
		$res = User_Info::addIngot($userId, $num);
		return '元宝'.$num."个";
	}
	
	/** @desc 经验 */
	public static function exp($userId, $num=null){
		if(empty($num)){
			$num = rand(300,1000);
		}
		$res = User_Info::addExperience($userId, $num);
		return '经验'.$num."个";
	}
	
}