<?php
class Copy_FightResult{

    const TABLE_NAME = 'copies_last_result';

    public static function create($params) {
        if($params['user_id'] <= 0) {
            return FALSE;
        }
        $data = array(
            'user_id'           => intval($params['user_id']),
            'copies_level_id'   => intval($params['copies_level_id']),
            'fight_start_time'  => time(),
            'use_time'          => intval($params['use_time']),
            'last_fight_result' => json_encode($params['last_fight_result']),
            'create_time'       => date('Y-m-d H:i:s'),
        );
		if ($params['win_monster_num']) {
			$data['win_monster_num'] = $params['win_monster_num'];
		}
        $existResult = self::getResult($params['user_id'], $params['copies_level_id']);
        if(is_array($existResult) && count($existResult)) {
            return MySql::update(self::TABLE_NAME, $data, array('user_id' => intval($params['user_id'])));
        } else {
            return MySql::insert(self::TABLE_NAME, $data, TRUE);
        }
    }

    public static function getResult($userId, $copyLevId = 0) {
        if($userId > 0) {
            $where = array(
                'user_id'   => intval($userId),
            );
            if($copyLevId > 0) {
                $where['copies_level_id'] = intval($copyLevId);
            }
            return MySql::selectOne(self::TABLE_NAME, $where);
        }
        return FALSE;
    }
}
