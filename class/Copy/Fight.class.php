<?php
class Copy_Fight{

	/*
	 * 创建副本一的战斗
	 */
	public static function createMonsterFightable($monster) {
		$attribute  = Monster::getMonsterAttribute($monster);
		//print_r($attribute);
		//技能加成后的属性
		//$attribute  = Monster::attributeWithSkill($attribute, $skill, $monster);

        $monsterInfo = array(
            'monster_id' => $monster['monster_id'],
            'race'       => $monster['race_id'],
            'user_level' => $monster['level'],
            'mark'       => $monster['mark'],
            'attributes' => $attribute,
			'have_skillids' => $monster['have_skillids'],
			'skill_rates'  => $monster['skill_rates'],
        );
		//print_r($monsterInfo);
		return new NewFightMember($monsterInfo);
	}

	/*
	 * 创建副本二、三、四的战斗
	 */
	public static function createGeneralMonsterFightable($monster) {
		$attribute  = Monster::getMonsterAttribute($monster);
		$monster['attributes'] = $attribute;
		return new NewFightMember($monster);	
	}
}
