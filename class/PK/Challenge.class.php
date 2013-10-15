<?php
/*
 * 挑战的结果信息保存
 * 含有连胜场次，总胜场次等等
 */

class PK_Challenge{

    const TABLE_NAME = 'user_pk_challenge_res';
    const PK_FIGHTED_USER_ID = 'user_pk_fighted_user_ids_';
    const PK_FIGHTED_RESULT_KEY = 'user_pk_challenge_';
    const PK_MAX_TIMES = 20;
    const PK_GET_INTEGRAL = 2;
    const PK_GET_POPULARITY = 4;

    //记录用户胜利的场次，只在胜利的时候进行保存结果
    public static function whenWin($userId) {
        if($userId <= 0) {
            return FALSE;
        }
        $existRes = self::getResByUserId($userId);
        $data = array(
            'user_id'   => intval($userId),
            'fight_num' => intval($existRes['fight_num']) + 1,
            'win_num'   => intval($existRes['win_num']) + 1,
            'win_continue_num' => intval($existRes['win_continue_num']) + 1,
        );
        if($data['win_continue_num'] == 1) {
            //表示第一场的连胜,更新这次的时间，为了连胜不能超过30分钟做准备
            $data['update_time'] = date('Y-m-d H:i:s');
        }
        if(is_array($existRes) && count($existRes)) {
            return MySql::update(self::TABLE_NAME, $data, array('user_id' => $userId));
        } else {
            return MySql::insert(self::TABLE_NAME, $data);
        }
    }

    public static function whenFail($userId) {
        if($userId <= 0) {
            return FALSE;
        }

        $existRes = self::getResByUserId($userId);
        $data = array(
            'user_id' => intval($userId),
            'fight_num' => intval($existRes['fight_num']) + 1,
        );
        if($existRes['win_continue_num'] > 0) {
            $data['win_continue_num'] = 0;
        }
        if(is_array($existRes) && count($existRes)) {
            return MySql::update(self::TABLE_NAME, $data, array('user_id' => $userId));
        } else {
            return MySql::insert(self::TABLE_NAME, $data);
        }
    }

    public static function getResByUserId($userId) {
        if($userId > 0) {
            $where['user_id'] = intval($userId);
        }
        return MySql::selectOne(self::TABLE_NAME, $where);
    }

    /****
     * 当挑战失败的时候，调用此方法，
     * 当连胜超过30分钟时，调用此方法
     * 会将
     * 连胜场数置为0
    **/
    public static function setWinContinueNumZero($userId) {
        if($userId <= 0) {
            return FALSE;
        }
        $existRes = self::getResByUserId($userId);
        if(is_array($existRes) && count($existRes)) {
            //有结果去更新，没结果不管
            $data = array(
                'win_continue_num' => 0,
            );
            return MySql::update(self::TABLE_NAME, $data, array('user_id' => intval($userId)));
        }
        return FALSE;
    }

    //全国排名
    public static function rankingAll($userId) {
        $res = self::getResByUserId($userId);
        $winNum = $res['win_num'] > 0 ? $res['win_num'] : 0;
        $sql = 'select count(1) as count from (select id from '.self::TABLE_NAME.' where win_num > '.$winNum.' group by win_num) as p';
        $count = MySql::query($sql);
        return $count[0]['count'] > 0 ? $count[0]['count'] + 1 : 1;
    }

    //好友排名
    public static function rankingFriend($userId) {
        $res = self::getResByUserId($userId);
        //
        $friendInfos = Friend_Info::getFriendInfo($userId);
        foreach ((array)$friendInfos as $friend) {
            $friendIds[] = $friend['friend_id'];
        }
        $winNum = $res['win_num'] > 0 ? $res['win_num'] : 0;
        if(is_array($friendIds) && count($friendIds)) {
            $friendIdsString = implode(',', $friendIds);
            $sql = 'select count(1) as count from (select id from '.self::TABLE_NAME.' where win_num > '.$winNum.' and user_id in ('.$friendIdsString.') group by win_num) as p_f';
            $count = MySql::query($sql);
        }
        return $count[0]['count'] > 0 ? $count[0]['count'] + 1 : 1;
    }


    public static function dealResult($userId, $isWin = TRUE) {
        $challengeInfo              = self::getResByUserId($userId);
        $return['win_count']        = $challengeInfo['win_num'];
        $return['win_continue_num'] = $challengeInfo['win_continue_num'];
        if(!$isWin) {
            $return['integral']            = $challengeInfo['win_continue_num'] * (self::PK_GET_INTEGRAL/2); //积分
            $return['popularity']       = $challengeInfo['win_continue_num'] * (self::PK_GET_POPULARITY/2);
        } else {
            $return['integral']            = $challengeInfo['win_continue_num'] * self::PK_GET_INTEGRAL; //积分
            $return['popularity']       = $challengeInfo['win_continue_num'] * self::PK_GET_POPULARITY;
        }
        //记录积分和声望入mysql
        if($return['integral'] > 0) {
            Intergral::fightIntegral($userId, $return['integral']);
        }
        if($return['popularity'] > 0) {
            User_Info::addReputationNum($userId, $return['popularity']);
        }
        $return['ranking_all']      = self::rankingAll($userId);
        $return['ranking_friend']   = self::rankingFriend($userId);
        //增加一次挑战次数
        PK_Conf::setChallengeTimes($userId);
        //去除已挑战的人物ids
        self::delAlreadyUserIds($userId);
        return $return;
    }

    public static function getUserOneNearFightTarget($userId, $isContinueWin = FALSE) {
        if($userId <= 0) {
            return FALSE;
        }
        $friends = User_Info::nearUser($userId);
        if($isContinueWin) {
            //从cache里拿出已经打过的人的ids
            //$fightedTarget = Cache::get(self::PK_FIGHTED_USER_ID.$userId);
        }
        foreach ((array)$friends as $user) {
            if($user['user_id'] > 0) {
                if(is_array($fightedTarget) && count($fightedTarget)) {
                    if(in_array($user['user_id'], $fightedTarget)) {
                        continue;
                    }
                }
                $friendIds[] = $user['user_id'];
            }
        }
        if(is_array($friendIds) && count($friendIds)) {
            shuffle($friendIds);
            return $friendIds[0];
        }
        return FALSE;
    }

    public static function updateFightedUserIdInCache($userId, $targetId) {
        $fightStatusInfo = self::getResByUserId($userId);
        $cacheTime = 30*60;//半个小时
        //打完计入已经战斗过的用户中去
        $fightedUserIds     = Cache::get(PK_Challenge::PK_FIGHTED_USER_ID.$userId);
        if($fightStatusInfo['win_continue_num'] > 0) {
            $fightStartTime = strtotime($fightStatusInfo['update_time']);
            $t              = time() - $fightStartTime;
            if($t > 0 && $t < $cacheTime) {
                $cacheTime  = $cacheTime - $t;
                $fightedUserIds[]   = $targetId;
                Cache::set(PK_Challenge::PK_FIGHTED_USER_ID.$userId, $fightedUserIds, $cacheTime);
            } else {
                return self::delFightedUserIds($userId);
            }
        }
        return ;
    }

    public static function delFightedUserIds($userId) {
        $cacheKey = self::PK_FIGHTED_USER_ID.$userId;
        $cacheValue = Cache::get($cacheKey);
        if(is_array($cacheValue) && count($cacheValue)) {
            Cache::set($cacheKey, '', 1);
        }
        return ;
    }

    public static function getLastChallengeInfo($userId) {
        if($userId <= 0) {
            return FALSE;
        }
        $cacheKey = self::PK_FIGHTED_RESULT_KEY.$userId;
        $cacheValue = Cache::get($cacheKey);
        return $cacheValue;
    }

    public static function setLastChallengeInfo($userId, $cacheValue, $cacheTime) {
        if($userId <= 0 || $cacheTime <= 0 || !(is_array($cacheValue) && count($cacheValue))) {
            return FALSE;
        }
        $cacheValue['update_time'] = time();
        $cacheValue['use_time']    = $cacheTime;
        $cacheKey   = self::PK_FIGHTED_RESULT_KEY.$userId;
        return Cache::set($cacheKey, $cacheValue, $cacheTime);
    }

    public static function delAlreadyUserIds($userId) {
        if($userId > 0) {
            $cacheKey = self::PK_FIGHTED_USER_ID.$userId;
            $cacheValue = Cache::get($cacheKey);
            if(is_array($cacheValue) && count($cacheValue)) {
                return Cache::del($cacheKey);
            }
        }
        return FALSE;
    }
}
