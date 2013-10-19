<?php
//
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : '';

if($userId <= 0) {
    $code = 1;
    $msg  = '缺少用户id';
    exit();
}

$userInfo = User_Info::getUserInfoByUserId($userId);

if(is_array($userInfo) && count($userInfo)) {
    $userChallengeInfo = PK_Challenge::getResByUserId($userId);
    $failChallengeNum  = ($userChallengeInfo['fight_num'] - $userChallengeInfo['win_num']) ;
    $userTodayInterity = Integral::getTodayIntegral($userId);//今日积分
    $userInterity       = Integral::getResidueIntegral($userId);
    $userPopularity = $userInfo['reputation'] > 0 ? $userInfo['reputation'] : 0;//声望
    //全国排名
    $userRankingAll = PK_Challenge::rankingAll($userId);
    //今日可挑战次数
    $challengeTimes = PK_Conf::getTimesByUserIdAndType($userId, PK_Conf::PK_MODEL_CHALLENGE);
    //爵位
    $data = array(
        'user_id' => $userId,
        'win_num' => $userChallengeInfo['win_num'],
        'fail_num' => $failChallengeNum > 0 ? $failChallengeNum : 0,
        'integral' => $userTodayInterity,
        'integral_all' => $userInterity,
        'popularity' => $userPopularity,
        'ranking_all' => $userRankingAll,
        'challenge_times' => 5 - $challengeTimes > 0 ? 5 - $challengeTimes : 0,
        'nobility'  => 1,
    );

}  else {
    $code = 1;
    $msg  = '不存在此用户';
    exit();
}