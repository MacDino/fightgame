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
        $userPetInfo    = User_Info::getUserInfoByUserId($petInfo['pet_id']);
        //人宠进入队伍
        $userFightTeam[] = Fight::createUserFightable($userPetInfo['user_id'], $userPetInfo['user_level'], 'pet');
        $data['participant']['pet'] = Fight::getPeopleFightInfo($userFightTeam[0], $userPetInfo);
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
    $userHelpAndHarm    = Fight::calculateHelpAndHarmfull($userInfo['race_id'], $userPetInfo['race_id'], $targetUserInfo['race_id']);
    //生成用户的战斗对象，进入队中的首位
    array_unshift($userFightTeam, Fight::createUserFightable($userId, $userInfo['user_level'], 'user', $userHelpAndHarm['user']['helpfull'], $userHelpAndHarm['user']['harmfull']));
    $data['participant']['user']        = Fight::getPeopleFightInfo($userFightTeam[0], $userInfo);

    $targetUserFightTeam[]              = Fight::createUserFightable($targetUserId, $targetUserInfo['user_level'], 'challenger');
    $data['participant']['challenger']  = Fight::getPeopleFightInfo($targetUserFightTeam[0], $targetUserInfo);

    $fightResult = Fight::multiFight($userFightTeam, $targetUserFightTeam);

    $isUserAlive        = Fight::isTeamAlive($userFightTeam);
    $isTargetUserAlive  = Fight::isTeamAlive($targetUserFightTeam);

    $data['fight_procedure'] = $fightResult['fight_procedure'];

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
    }
    $data['result']['use_time'] = $fightResult['use_time'];
    //记录最后一次战斗信息
    PK_Challenge::setLastChallengeInfo($userId, $data, $fightResult['use_time']);
    PK_Challenge::updateFightedUserIdInCache($userId, $targetUserId);
} catch (Exception $exc) {
    $code = $e->getCode();
    $msg  = $e->getMessage();
}