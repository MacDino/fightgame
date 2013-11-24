<?php
class Copy {

	const TABLE_NAME = 'copies';

    public static function getCopyInfoByCopyId($copyId) {
        if($copyId > 0) {
            $where = array('copies_id' => $copyId);

            return MySql::selectOne(self::TABLE_NAME, $where);
        }
        return FALSE;
    }

	public static function getCopyList(){
		$res = MySql::select(self::TABLE_NAME, $where);
		return $res;
	}

	public static function getMonster($copyLevelId, $userId) {
		return Copy_Config::getMonsterByLevelId($copyLevelId, $userId);
	}
}
