<?php
class Pill{
	/*CONST TIANSHUJINGHUA = 3501;
	CONST TIANXUANJINGHUA = 3502;
	CONST TIANJIJINGHUA = 3503;
	CONST TIANQUANJINGHUA = 3504;
	CONST YUHENGJINGHUA = 3505;*/
	
	CONST TIANSHUNEIDAN = 3601;
	CONST TIANXUANNEIDAN = 3602;
	CONST TIANJINEIDAN = 3603;
	CONST TIANQUANNEIDAN = 3604;
	CONST YUHENGNEIDAN = 3605;
	
	/** @desc 内丹加成 */
	public static function pillAttribute($type, $pill_layer, $pill_level){
		$level = ($pill_layer - 1) * 10 + $pill_level;//拼出来的等级
		switch ($type){
			case self::TIANSHUNEIDAN://天枢,伤害
				$num = $level*2 + ($level*$level + $level)/2*0.03;
				echo $num;
	            $res = array('3601' => $num);
	            break; 
             case self::TIANXUANNEIDAN://天璇,灵力
				$num = $level*2 + ($level*$level + $level)/2*0.03;
	            $res = array(ConfigDefine::USER_ATTRIBUTE_PSYCHIC => $num);
	            break;   
             case self::TIANJINEIDAN://天玑,命中
				$num = $level*2 + ($level*$level + $level)/2*0.03;
	            $res = array(ConfigDefine::USER_ATTRIBUTE_HIT => $num);
	            break;     
	         case self::TIANQUANNEIDAN://天权,防御
				$num = $level*2 + ($level*$level + $level)/2*0.03;
	            $res = array(ConfigDefine::USER_ATTRIBUTE_DEFENSE => $num);
	            break;  
             case self::YUHENGNEIDAN://玉衡,暴击几率和暴击伤害
				$probability = 0;
				$value = 0;
				for ($i=1;$i<=$level;$i++){
					if($i == 1){
						$probability += 1;
						$value += 1;
					}else{
						$probability += $level*0.01;
						$value += $level*0.01;
					}
				}
	            $res = array('probability' => $probability/100, 'value' => $value/100);
	            break;  
		}	
		return $res;
	}
	
	/** @desc 下一级加成 */
	public static function nextLevelAttribute($type, $pill_layer, $pill_level){
		$level = ($pill_layer - 1) * 10 + $pill_level + 1;//拼出来的等级
		switch ($type){
			case self::TIANSHUNEIDAN://天枢,伤害
				$num = $level * (2 + $level*0.03);
	            $res = array(ConfigDefine::USER_ATTRIBUTE_HURT => $num);
	            print_r($res);
	            break; 
             case self::TIANXUANNEIDAN://天璇,灵力
				$num = $level * (2 + $level*0.03);
	            $res = array(ConfigDefine::USER_ATTRIBUTE_PSYCHIC => $num);
	            break;   
             case self::TIANJINEIDAN://天玑,命中
				$num = $level * (5 + $level*0.1);
	            $res = array(ConfigDefine::USER_ATTRIBUTE_HIT => $num);
	            break;     
	         case self::TIANQUANNEIDAN://天权,防御
				$num = $level * (5 + $level*0.1);
	            $res = array(ConfigDefine::USER_ATTRIBUTE_DEFENSE => $num);
	            break;  
             case self::YUHENGNEIDAN://玉衡,暴击几率和暴击伤害
				$probability = $level*0.01;
				$value = $level*0.01;
	            $res = array('probability' => $probability/100, 'value' => $value/100);
	            break;  
		}	
		echo $res;
		return $res;
	}
}