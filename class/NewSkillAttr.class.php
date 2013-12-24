<?php
//技能附加属性
class NewSkillAttr{
	
	/** 游龙斩 */
	public static function skill1206($level){
		$coefficient = pow($level,2);
		$hit = 2.5 * $level + 0.014 *( $coefficient + $level)/2 + 20;
		//echo $hurt;
		$hurt = 1.01 * $level + 0.02 *( $coefficient + $level)/2;
		return array(
			'1107' => $hurt,
			'1106' => $hit,
		);
	}
	
	/** 醉生梦死 */
	public static function skill1207($level){
		return array();
	}
	
	/** 封印 */
	public static function skill1208($level){
		return array();
	}
	
	/** 天地正气 */
	public static function skill1209($level){
		$coefficient = pow($level,2);
		$psychic  = 0.5 * $level + 0.009 *($coefficient + $level)/2;
		return array(
			'1110' => $psychic,
		);
	}
	
	/** 纯阳真气 */
	public static function skill1210($level){
		$coefficient = pow($level,2);
		$dodge  = 2.01 * $level + 0.02 *($coefficient + $level)/2;
		return array(
			'1113' => $dodge,
		);
	}
	
	/** 以牙还牙 */
	public static function skill1211($level){
		$coefficient = pow($level,2);
		$defense  = 1 * $level + 0.014 *($coefficient + $level)/2;
		return array(
			'1112' => $defense,
		);
	}
	
	
	/** 雷霆之怒 */
	public static function skill1212($level){
		$coefficient = pow($level,2);
		$psychic  = 2.01 * $level + 0.02 *($coefficient + $level)/2 + 25;
		return array(
			'1110' => $psychic,
		);
	}
	
	/** 呼风唤雨 */
	public static function skill1213($level){
		$coefficient = pow($level,2);
		$psychic  = 0.5 * $level + 0.009 *($coefficient + $level)/2;
		return array(
			'1110' => $psychic,
		);
	}
	
	/** 净化 */
	public static function skill1214($level){
		$coefficient = pow($level,2);
		$dodge  = 2.01 * $level + 0.02 *($coefficient + $level)/2;
		return array(
			'1113' => $dodge,
		);
	}
	
	/** 群加血 */
	public static function skill1215($level){
		return array();
	}
	
	/** 天神附体 */
	public static function skill1216($level){
		$coefficient = pow($level,2);
		$dodge  = 2.01 * $level + 0.02 *($coefficient + $level)/2;
		return array(
			'1113' => $dodge,
		);
	}
	
	/** 仙风护体 */
	public static function skill1217($level){
		$coefficient = pow($level,2);
		$defense  = 1 * $level + 0.0014 *($coefficient + $level)/2;
		return array(
			'1112' => $defense,
		);
	}
	
	/** 狮子搏兔 */
	public static function skill1218($level){
		$coefficient = pow($level,2);
		$hurt  = 2.02 * $level + 0.01 *($coefficient + $level)/2;
		return array(
			'1107' => $hurt,
		);
	}
	
	/** 横扫千军 */
	public static function skill1219($level){
		/*$coefficient = pow($level,2);
		$hurt  = 2.02 * $level + 0.01 *($coefficient + $level)/2;*/
		return array(
			/*'1107' => $hurt,*/
		);
	}
	
	/** 怨灵缠身 */
	public static function skill1220($level){
		$coefficient = pow($level,2);
		$dodge  = 2.01 * $level + 0.02 *($coefficient + $level)/2;
		return array(
			'1113' => $dodge,
		);
	}
	
	/** 回魂术 */
	public static function skill1221($level){
		return array();
	}
	
	/** 战无止境 */
	public static function skill1222($level){
		$coefficient = pow($level,2);
		$psychic  = 0.5 * $level + 0.009 *($coefficient + $level)/2;
		return array(
			'1110' => $psychic,
		);
	}
	
	/** 玉石俱焚 */
	public static function skill1223($level){
		$coefficient = pow($level,2);
		$defense  = 1 * $level + 0.014 *($coefficient + $level)/2;
		return array(
			'1112' => $defense,
		);
	}
}
