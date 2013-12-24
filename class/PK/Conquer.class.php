<?php
/**
 * @author lishengwei
 * 废弃
 */
class PK_Conquer {
    const TABLE_NAME = 'conquer_info';  //征服信息列表，记录了征服者对被征服者的时间，用于消息

    public static function logResult($params) {
        if($params['user_id'] <= 0 || $params['target_uid'] <= 0) {
            return FALSE;
        }
        $data = array(
            'user_id'       => $params['user_id'],
            'target_uid'    => $params['target_uid'],
            'create_time'   => date('Y-m-d H:i:s'),
        );
        return MySql::insert(self::TABLE_NAME, $data, TRUE);
    }


}