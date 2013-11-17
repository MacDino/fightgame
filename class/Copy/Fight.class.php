<?php
class Copy_Fight{

	/*
	 * 创建副本一的战斗
	 */
	public static function createMonsterFightable($monster) {
		$attribute  = Monster::getMonsterAttribute($monster);
		//print_r($attribute);
		//技能加成后的属性
		$attribute  = Monster::attributeWithSkill($attribute, $skill, $monster);

		$monster['attributes'] = $attribute;
		print_r($monster);
		return new NewFightMember($monster);
	}

	/*
	 * 创建副本二、三、四的战斗
	 */
	public static function createGeneralMonsterFightable($monster) {
		$attribute  = Monster::getMonsterAttribute($monster);
		$monster['attributes'] = $attribute;
		print_r($monster);
		return new NewFightMember($monster);	
	}
}
