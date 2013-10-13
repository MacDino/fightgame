<?php
class Copy {


	public static function getMonster($copyLevelId, $userId) {
		return Copy_Config::getMonsterByLevelId($copyLevelId, $userId);
	}
}
