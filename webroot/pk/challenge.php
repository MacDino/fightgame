<?php
/**
 * 挑战模式
 * 单次会挑战很多人
 * 怎么传输数据
 *
 *
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : '';
//@todo 不确定是按照哪种方式获取人宠，这里按照系统自动获取人宠
$userInfo = User_Info::getUserInfoByUserId($userId);
if(!(is_array($userInfo) && count($userInfo))) {
    $code = 1;
    $msg  = '找不到用户';
    exit();
}
//if($userInfo['user_level'] < 30) {
//    $code =1 ;
//    $msg  = '等级不够';
//    exit();
//}

//cache中获得
$lastResult = PK_Challenge::getLastChallengeInfo($userId);
if(is_array($lastResult) && count($lastResult)) {
    if(time() - $lastResult['update_time'] < $lastResult['use_time']) {
        $data = $lastResult;
        unset($data['use_time']);
        unset($data['update_time']);
        exit();
    }
}

$isCanFight = PK_Conf::isCanFight($userId, PK_Conf::PK_MODEL_CHALLENGE);

//if(!$isCanFight['is_can']) {
//    $code = 1;
//    $msg  = '没有挑战次数了';
//    exit();
//}
try {
    $fightStatus = PK_Challenge::getResByUserId($userId);
    if(is_array($fightStatus) && count($fightStatus) && $fightStatus['win_continue_num'] > 0) {
        //连胜超过N了
        if($fightStatus['win_continue_num'] >= PK_Challenge::PK_MAX_TIMES) {
            $data['result'] = PK_Challenge::dealResult($userId);
            PK_Challenge::setWinContinueNumZero($userId);
            PK_Challenge::delFightedUserIds($userId);
            exit();
        }
    }

    $userFightTeam      = array();
    $petInfo            = Pet::usedPet($userId);
    if(is_array($petInfo) && count($petInfo)) {
        //人宠进入队伍
//        $userFightTeam[] = Fight::createUserFightable($petInfo['user_id'], $petInfo['user_level'], 'pet');
        $petInfo['mark'] = 'pet';
        $teams['user'][] = NewFight::createUserObj($petInfo);
//        $data['participant']['pet'] = Fight::getPeopleFightInfo($userFightTeam[0], $petInfo);
        $data['participant']['pet'] = NewFight::getPeopleFightInfo($teams['user'][0], $petInfo);
    }

    /**@todo 随即出来一个战斗对象**/
    $targetUserId   = PK_Challenge::getUserOneNearFightTarget($userId, $fightStatus['win_continue_num'] > 0 ? TRUE : FALSE);
    //找不到战斗对象的时候，判断是否是连胜局。连胜局的话，表示此轮挑战结束
    if($targetUserId <= 0) {
        $code = 1;
        if($fightStatus['win_continue_num'] > 0) {
            //获得战果并展示
            $data['result'] = PK_Challenge::dealResult($userId);
            PK_Challenge::setWinContinueNumZero($userId);
            PK_Challenge::delFightedUserIds($userId);
        } else {
            $msg = '未获取到附近用户';
        }
        exit;
    }

    $targetUserInfo     = User_Info::getUserInfoByUserId($targetUserId);
    //计算是否相生相克
//    $userHelpAndHarm    = Fight::calculateHelpAndHarmfull($userInfo['race_id'], $petInfo['race_id'], $targetUserInfo['race_id']);
    //生成用户的战斗对象，进入队中的首位
//    array_unshift($userFightTeam, Fight::createUserFightable($userId, $userInfo['user_level'], 'user', $userHelpAndHarm['user']['helpfull'], $userHelpAndHarm['user']['harmfull']));
    $userInfo['mark'] = 'user';
    if(is_array($teams['user']) && count($teams['user'])) {
        array_unshift($teams['user'], NewFight::createUserObj($userInfo));
    }  else {
        $teams['user'][] = NewFight::createUserObj($userInfo);
    }
//    $data['participant']['user']        = Fight::getPeopleFightInfo($userFightTeam[0], $userInfo);
    $data['participant']['user']        = NewFight::getPeopleFightInfo($teams['user'][0], $userInfo);

//    $targetUserFightTeam[]              = Fight::createUserFightable($targetUserId, $targetUserInfo['user_level'], 'challenger');
//    $data['participant']['challenger']  = Fight::getPeopleFightInfo($targetUserFightTeam[0], $targetUserInfo);
    $targetUserInfo['mark'] = 'challenger';
    $teams['challenger'][]              = NewFight::createUserObj($targetUserInfo);
    $data['participant']['challenger']  = NewFight::getPeopleFightInfo($teams['challenger'][0], $targetUserInfo);
    $targetPet            = Pet::usedPet($targetUserId);
    if(is_array($targetPet) && count($targetPet)) {
        //人宠进入队伍
//        $targetUserFightTeam[] = Fight::createUserFightable($targetPet['user_id'], $targetPet['user_level'], 'target_pet');
//        $data['participant']['target_pet'] = Fight::getPeopleFightInfo($targetUserFightTeam[0], $targetPet);
        $targetPet['mark'] = 'challenger_pet';
        $teams['challenger'][] = NewFight::createUserObj($targetPet);
        $data['participant']['target_pet'] = NewFight::getPeopleFightInfo($teams['challenger'][1], $targetPet);
    }

//    $fightResult = Fight::multiFight($userFightTeam, $targetUserFightTeam);
    $fightResult = NewFight::getFightResult($teams);

//    $isUserAlive        = Fight::isTeamAlive($userFightTeam);
//    $isTargetUserAlive  = Fight::isTeamAlive($targetUserFightTeam);
    $isUserAlive        = NewFight::isTeamAlive($teams['user']);
    $isTargetUserAlive  = NewFight::isTeamAlive($teams['challenger']);

    $data['fight_procedure'] = $fightResult['fight_procedure'];

    //获取之前好友超过此人的用户id和胜利场数
    $userRankingFriendsBefore = PK_Challenge::getFriendsWinNum($userId);

    if(!$isUserAlive && $isTargetUserAlive || $fightResult['is_too_long'] == 1) {
        $data['result']             = PK_Challenge::dealResult($userId, FALSE);
        $data['result']['win']      = 0;
        $data['result']['is_dead']  = 1;
        if($fightResult['is_too_long']) {
            $data['result']['is_dead'] = 0;
        }
        PK_Challenge::whenFail($userId);
    } else {
        $data['result']['win'] = 1;
        PK_Challenge::whenWin($userId);
        $data['result']['win_continue_num'] = $fightStatus['win_continue_num'] + 1;
        $data['result']['integral']         = ($fightStatus['win_continue_num']+1) * PK_Challenge::PK_GET_INTEGRAL; //积分
        $data['result']['popularity']       = ($fightStatus['win_continue_num']+1) * PK_Challenge::PK_GET_POPULARITY;
        if(is_array($userRankingFriendsBefore) && count($userRankingFriendsBefore)) {
            if($fightStatus['win_num'] + 1 > $userRankingFriendsBefore['win_num']) {
                $friendInfo = User_Info::getUserInfoByUserId($userRankingFriendsBefore['user_id']);
                $data['result']['exceed_friends'] = $friendInfo['user_name'];
            }
        }
    }
    $data['result']['use_time'] = $fightResult['use_time'];
    //记录最后一次战斗信息
    PK_Challenge::setLastChallengeInfo($userId, $data, $fightResult['use_time']);
    PK_Challenge::updateFightedUserIdInCache($userId, $targetUserId);
} catch (Exception $exc) {
    $code = $e->getCode();
    $msg  = $e->getMessage();
}