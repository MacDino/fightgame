<?php
class Copy_Fight{

	public static function createMonsterFightable($monster, $marking = '') {
		$skill      = Copy_Config::getMonsterSkill($monster);
		//print_r($skill);
		$attribute  = Monster::getMonsterAttribute($monster);
		//print_r($attribute);
		//技能加成后的属性
		$attribute  = Monster::attributeWithSkill($attribute, $skill, $monster);
		return new Fightable($monster['level'], $attribute, $skill, array('monster_id' => $monster['monster_id'],'marking' => $marking));
	}
}
