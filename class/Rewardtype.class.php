<?php
class Rewardtype{
	
	/** @desc 技能点 */
	public static function skillPoint($userId, $num=1){
		$res = User_Info::addIngot($userId, $num);
		return '技能点|N:'.$num;
	}
	
	/** @desc 内丹精华 */
	public static function pillStone($userId, $num=1, $type=NULL){
		//echo 44555;
		if(empty($type)){
			//echo 666666;
			$type = array_rand(ConfigDefine::pillList());
			//print_r($array);
			//$type = $array[array_rand($array)];
			//echo $type
		}
		//echo $type;exit;
		$res = Pill_Stone::addStone($userId, $type, $num);
		return $type.'|精华|N:'.$num;
	}
	
	/** @desc 精铁 */
	public static function pillIron($userId, $num=1, $level=NULL){
		if(empty($level)){
			$level = rand(1,10);
		}
		$res = Pill_Iron::addIron($userId, $level);
		return "N:".$level."|级精铁|N:".$num;
	}
	
	/** @desc 消费道具 */
	public static function props($userId, $num=1, $type=NULL){
		if(empty($type)){
			$array = array(6301, 6302, 6303, 6308);
			$type = $array[array_rand($array)];
		}

		if($type == 6301){
			$props_id = 1;
		}elseif($type == 6302){
			$props_id = 2;
		}elseif($type == 6303){
			$props_id = 3;
		}/*elseif($type == 6306){
			$props_id = 6;
		}*/elseif($type == 6308){
			$props_id = 8;
		}

		$res = User_Property::updateNumIncreaseAction($userId, $props_id, $num);
		return $type.'|N:'.$num;
	}
	
	/** @desc 上古遗迹 */
	public static function box($userId, $num=1, $level=null, $colour=null, $equipQuality=null, $equipSuitRaceId=null){
		if(empty($level)){
			$userInfo = User_Info::getUserInfoByUserId($userId);
			$level = intval($userInfo['user_level']/10) * 10;
		}
		
		if(empty($colour)){
			$colour = User_Property::randGeneralEquipColor();
			$equipId = Equip_Create::createEquip($colour, $userId, $level);
		}else{
			$equipId = Equip_Create::createEquip($colour, $userId, $level, '', $equipQuality, $equipSuitRaceId);
		}
		
			
			$res = Equip_Info::getEquipInfoById($equipId);
			
		    	$res['attribute_list'] = json_decode($res['attribute_list'], true);
		    	foreach ($res['attribute_list'] as $o=>$value){
					$res['attribute_list'][$o] = ceil($value);
				}
		    	$res['attribute_base_list'] = json_decode($res['attribute_base_list'], true);
		    	foreach ($res['attribute_base_list'] as $o=>$value){
					$res['attribute_base_list'][$o] = ceil($value);
				}
		    	$res['price'] = Equip_Info::priceEquip($key['user_equip_id']);
			
			$result = $res;
		
		return $result;
	}
	
	/** @desc 金币 */
	public static function money($userId, $num=null){
		if(empty($num)){
			$num = rand(10000,1000000);
		}
		$res = User_Info::addBindMoney($userId, $num);
		return '铜钱|N:'.$num;
	}
	
	/** @desc 元宝 */
	public static function ingot($userId, $num=null){
		if(empty($num)){
			$num = rand(1,100);
		}
		$res = User_Info::addIngot($userId, $num);
		return '元宝|N:'.$num;
	}
	
	/** @desc 经验 */
	public static function exp($userId, $num=null){
		if(empty($num)){
			$num = rand(300,1000);
		}
		$res = User_Info::addExperience($userId, $num);
		return '经验|N:'.$num;
	}
	
}