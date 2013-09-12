<?php
/**
 * 记录战斗的最后一次结果
 * @author lishengwei
 * @todo 可做缓存
 */
class Fight_Result {
    const TABLE_NAME = 'fight_last_result';

    /**
     * 一个用户只有一个战斗最后记录
     * 此战斗记录不做太必要的存储
     * 所以如果未保存或者保存失败，不抛出致命错误
     * **/
    public static function create($params) {
        if($params['user_id'] <= 0) {
            return FALSE;
        }
        $data = array(
            'user_id'           => intval($params['user_id']),
            'map_id'            => intval($params['map_id']),
            'fight_start_time'  => time(),
            'use_time'          => intval($params['use_time']),
            'last_fight_result' => json_encode($params['last_fight_result']),
            'create_time'       => date('Y-m-d H:i:s'),
        );
        /**根据用户的id进行检验，如果有结果更新，没有结果插入**/
        $existResult = self::getResult($params['user_id']);
        if(is_array($existResult) && count($existResult)) {
            return MySql::update(self::TABLE_NAME, $data, array('user_id' => intval($params['user_id'])));
        } else {
            return Mysql::insert(self::TABLE_NAME, $data, TRUE);
        }
    }

    /**
     * 根据用户以及当前的map获取所属的map的最后一次战斗
     * **/
    public static function getResult($userId, $mapId = 0) {
        if($userId > 0) {
            $where = array(
                'user_id'   => intval($userId),
            );
            if($mapId > 0) {
                $where['map_id'] = intval($mapId);
            }
            return MySql::selectOne(self::TABLE_NAME, $where);
        }
        return FALSE;
    }

}