<?php
/**
 * PK的几种模式的配置
 * @author lishengwei
 */
class PK_Conf {
    const TABLE_NAME_TIMES = 'user_pk_times'; //每天用户已经完成的战斗次数。不论胜败
    const PK_MODEL_CHALLENGE = 'challenge';
    const PK_MODEL_CONQUER  = 'conquer';
    public static $timesInfo = array(
        self::PK_MODEL_CHALLENGE => array('init' => 5,'max' => 15),
        self::PK_MODEL_CONQUER   => array('init' => 10,),
    );

    public static function getChallengeTimes($userId) {
        return self::getTimesByUserIdAndType($userId, self::PK_MODEL_CHALLENGE);
    }

    public static function getConquerTimes($userId) {
        return self::getTimesByUserIdAndType($userId, self::PK_MODEL_CONQUER);
    }

    public static function setChallengeTimes($userId) {
        return self::setInfo($userId, self::PK_MODEL_CHALLENGE);
    }

    public static function setConquerTimes($userId) {
        return self::setInfo($userId, self::PK_MODEL_CONQUER);
    }

    public static function getInfoByUserIdAndType($userId, $type = self::PK_MODEL_CHALLENGE) {
        if($userId > 0 && $type) {
            $where = array(
                'user_id'   => $userId,
                'type'      => $type,
            );
            return MySql::selectOne(self::TABLE_NAME_TIMES, $where);
        }
        return array();
    }

    public static function setInfo($userId, $type = self::PK_MODEL_CHALLENGE) {
        $data = array(
            'user_id' => $userId,
            'type' => $type,
            'update_time' => date('Y-m-d H:i:s'),
            'times'  => 1,
        );
        $existInfo = self::getInfoByUserIdAndType($userId, $type);
        if(is_array($existInfo) && count($existInfo)) {
            $infoUpdateStamp = strtotime($existInfo['update_time']);
            $todayZeroStamp  = strtotime(date('Y-m-d 00:00:00'));
            if($infoUpdateStamp >= $todayZeroStamp) {
                $data['times'] = intval($existInfo['times']) + 1;
            }
            return MySql::update(self::TABLE_NAME_TIMES, $data, array('user_id' => $userId,'type' => $type));
        }
        return MySql::insert(self::TABLE_NAME_TIMES, $data);
    }

    public static function getTimesByUserIdAndType($userId, $type = self::PK_MODEL_CHALLENGE) {
        $info = self::getInfoByUserIdAndType($userId, $type);
        if(is_array($info) && count($info)) {
            $infoUpdateStamp = strtotime($info['update_time']);
            $todayZeroStamp  = strtotime(date('Y-m-d 00:00:00'));
            if($infoUpdateStamp >= $todayZeroStamp) {
                return intval($info['times']);
            }
        }
        return 0;
    }

    public static function isCanFight($userId, $type = self::PK_MODEL_CHALLENGE) {
        $times = self::getTimesByUserIdAndType($userId, $type);
        $timesConf = self::$timesInfo[$type];
        $return = array(
            'is_can'  => 1,
            'is_free' => 1,
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
