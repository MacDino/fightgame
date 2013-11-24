<?php
//技能附加属性
class NewSkillAttr{
	
	public static function getSkillAttr($userId){
		$attrArray = array();
		$skillInfo = NewSkillStudy::getSkillList();
		foreach ($skillInfo as $k=>$v){
			$res = self::_. $v['skill_id'];
			foreach ($res as $i => $o){
				if(array_key_exists($i, $attrArray)){
					$AttrArray[$i] += $o;
				}
			}
		}
		
		return $attrArray;
	}
	
	/** 游龙斩 */
	private static function _1206($level){
		$coefficient = pow(2,$level);
		$hurt = 2.5 * $level + 0.014 *（ $coefficient + $level）/2 + 20;
		$hit  = 1.01 * $level + 0.02 *（ $coefficient + $level）/2;
		return array(
			'1107' => $hurt,
			'1106' => $hit,
		);
	}
	
	/** 醉生梦死 */
	private static function _1207($level){
		return array();
	}
	
	/** 封印 */
	private static function _1208($level){
		return array();
	}
	
	/** 天地正气 */
	private static function _1209($level){
		$coefficient = pow(2,$level);
		$psychic  = 0.5 * $level + 0.009 *（ $coefficient + $level）/2;
		return array(
			'1110' => $psychic,
		);
	}
	
	/** 纯阳真气 */
	private static function _1210($level){
		$coefficient = pow(2,$level);
		$dodge  = 2.01 * $level + 0.02 *（ $coefficient + $level）/2;
		return array(
			'1113' => $dodge,
		);
	}
	
	/** 以牙还牙 */
	private static function _1211($level){
		$coefficient = pow(2,$level);
		$defense  = 1 * $level + 0.014 *（ $coefficient + $level）/2;
		return array(
			'1112' => $defense,
		);
	}
	
	/** 以牙还牙 */
	private static function _1211($level){
		$coefficient = pow(2,$level);
		$defense  = 1 * $level + 0.014 *（ $coefficient + $level）/2;
		return array(
			'1112' => $defense,
		);
	}
	
	/** 雷霆之怒 */
	private static function _1212($level){
		$coefficient = pow(2,$level);
		$psychic  = 2.01 * $level + 0.02 *（ $coefficient + $level）/2 + 25;
		return array(
			'1110' => $psychic,
		);
	}
	
	/** 呼风唤雨 */
	private static function _1213($level){
		$coefficient = pow(2,$level);
		$psychic  = 0.5 * $level + 0.009 *（ $coefficient + $level）/2;
		return array(
			'1110' => $psychic,
		);
	}
	
	/** 净化 */
	private static function _1214($level){
		$coefficient = pow(2,$level);
		$dodge  = 2.01 * $level + 0.02 *（ $coefficient + $level）/2;
		return array(
			'1113' => $dodge,
		);
	}
	
	/** 净化 */
	private static function _1215($level){
		return array();
	}
	
	/** 天神附体 */
	private static function _1216($level){
		$coefficient = pow(2,$level);
		$dodge  = 2.01 * $level + 0.02 *（ $coefficient + $level）/2;
		return array(
			'1113' => $dodge,
		);
	}
	
	/** 仙风护体 */
	private static function _1217($level){
		$coefficient = pow(2,$level);
		$defense  = 1 * $level + 0.0014 *（ $coefficient + $level）/2;
		return array(
			'1112' => $defense,
		);
	}
	
	/** 狮子搏兔 */
	private static function _1218($level){
		$coefficient = pow(2,$level);
		$hurt  = 2.02 * $level + 0.01 *（ $coefficient + $level）/2;
		return array(
			'1107' => $hurt,
		);
	}
	
	/** 横扫千军 */
	private static function _1219($level){
		$coefficient = pow(2,$level);
		$hurt  = 2.02 * $level + 0.01 *（ $coefficient + $level）/2;
		return array(
			'1107' => $hurt,
		);
	}
	
	/** 怨灵缠身 */
	private static function _1220($level){
		$coefficient = pow(2,$level);
		$dodge  = 2.01 * $level + 0.02 *（ $coefficient + $level）/2;
		return array(
			'1113' => $dodge,
		);
	}
	
	/** 回魂术 */
	private static function _1221($level){
		return array();
	}
	
	/** 战无止境 */
	private static function _1222($level){
		$coefficient = pow(2,$level);
		$psychic  = 0.5 * $level + 0.009 *（ $coefficient + $level）/2;
		return array(
			'1110' => $psychic,
		);
	}
	
	/** 玉石俱焚 */
	private static function _1223($level){
		$coefficient = pow(2,$level);
		$defense  = 1 * $level + 0.014 *（ $coefficient + $level）/2;
		return array(
			'1112' => $defense,
		);
	}
	
	/** 体修 */
	private static function _1224($level, $race){
		/*人族：{(当前体质-10)*5+150}*(1+体修等级%) 
魔族 ：{(当前体质-12)*6+172}*(1+体修等级%)
仙族 ：{(当前体质-12)*4.5+154}*(1+体修等级%)*/

		/*if($race == 1){
			return 
		}*/
	}
	
	/** 物攻修 */
	private static function _1202($level){
/*		最终伤害结果=原伤害*1.002^技能等级+0.5（1.002^技能等级-1）/(1.002-1)*/
	}
	
	/** 法攻修 */
	private static function _1203($level){
		/*最终法术伤害结果=原法术伤害*1.002^技能等级+0.5（1.002^技能等级-1）/(1.002-1)*/
	}
	
	/** 法防修 */
	private static function _1204($level){
		/*最终法术防御结果=原灵力*1.002^技能等级+0.5（1.002^技能等级-1）/(1.002-1)*/
	}
	
	/** 物防修 */
	private static function _1205($level){
		/*最终物理防御结果=原防御*1.002^技能等级+0.5（1.002^技能等级-1）/(1.002-1)*/
	}
	
	
}