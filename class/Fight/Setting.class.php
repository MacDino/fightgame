<?php
/**
 * 0表示此项关闭
 * 1表示此项开启
 * 实际存储中，与上面的值相反
 * @author lishengwei
 */
class Fight_Setting {
    const TABLE_NAME = 'fight_setting';

    public static function create($params) {
        if($params['user_id'] <= 0) {
            throw new Exception('没有要保存的用户id', 1);
        }
        $existInfo = self::getFightSettingByUserId($params['user_id']);
        $data = array(
            'user_id' => intval($params['user_id']),
        );
        if(isset($params['log']) && in_array($params['log'], array(0,1))) {
            $data['log'] = !$params['log'];
        }
        if(isset($params['result']) && in_array($params['result'], array(0,1))) {
            $data['result'] = !$params['result'];
        }
        if(isset($params['gold']) && in_array($params['gold'], array(0,1))) {
            $data['gold'] = !$params['gold'];
        }
        if(isset($params['exp']) && in_array($params['exp'], array(0,1))) {
            $data['exp'] = !$params['exp'];
        }
        if(isset($params['prop']) && in_array($params['prop'], array(0,1))) {
            $data['prop'] = !$params['prop'];
        }
        if(isset($params['gray']) && in_array($params['gray'], array(0,1))) {
            $data['gray'] = !$params['gray'];
        }
        if(isset($params['white']) && in_array($params['white'], array(0,1))) {
            $data['white'] = !$params['white'];
        }
        if(isset($params['green']) && in_array($params['green'], array(0,1))) {
            $data['green'] = !$params['green'];
        }
        if(isset($params['blue']) && in_array($params['blue'], array(0,1))) {
            $data['blue'] = !$params['blue'];
        }
        if(isset($params['purple']) && in_array($params['purple'], array(0,1))) {
            $data['purple'] = !$params['purple'];
        }
        if(isset($params['orange']) && in_array($params['orange'], array(0,1))) {
            $data['orange'] = !$params['orange'];
        }
        if(count($data) <= 1) {
            throw new Exception('请配置要配置的设定', 1);
        }

        if(is_array($existInfo) && count($existInfo)) {
            return Mysql::update(self::TABLE_NAME, $data, array('user_id' => $params['user_id']));
        }
        return Mysql::insert(self::TABLE_NAME, $data);
    }

    private static function getFightSettingByUserId($userId) {
        if($userId > 0) {
            $where = array(
                'user_id' => $userId,
            );
            return Mysql::selectOne(self::TABLE_NAME, $where);
        }
        return FALSE;
    }

    /**输出给前端使用，没有的话会默认出来一个**/
    public static function getSettingByUserId ($userId) {
        $info = self::getFightSettingByUserId($userId);
        $keys = array('log','result','gold','exp','prop','gray','green','blue','white','purple','orange');
        foreach ($keys as $k) {
            $return[$k] = intval(!$info[$k]);
        }
        return $return;
    }
}