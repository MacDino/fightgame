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

    public static function getFightNum($userId, $type = self::PK_MODEL_CHALLENGE) {
        $times = PK_Conf::getTimesByUserIdAndType($userId, $type);
		if(strstr($type, "_")){
			$tmp = explode("_", $type);	
			$type = $tmp[0];
		}
        $timesConf = PK_Conf::$timesInfo[$type];
        $return = array(
            'is_can'  => $timesConf['init'],
            'is_free' => $timesConf['init'] - $times,
        );
        if($times >= $timesConf['init']) {
            $return['is_free'] = 0;
            if($timesConf['max'] > 0 && $times >= $timesConf['max']) {
                $return['is_can'] = 0;
            }
        }
        return $return;
    }
}
