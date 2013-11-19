<?php
/**
 * 征服模式
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId         = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : 0;
$targetUserId   = $_REQUEST['target_id'] > 0 ? $_REQUEST['target_id'] : 0;
try{
    $userInfo       = User_Info::getUserInfoByUserId($userId);
    $targetUserInfo = User_Info::getUserInfoByUserId($targetUserId);
    if(!(is_array($userInfo) && count($userInfo)) || !(is_array($targetUserInfo) && count($targetUserInfo))) {
        $code = 1;
        $msg  = '不存在的用户';
        exit();
    }

    $isCanFight = PK_Conf::isCanFight($userId, PK_Conf::PK_MODEL_CONQUER);
    if(!$isCanFight['is_free'] && $userInfo['pk_num'] <= 0) {
        $code = 1;
        $msg = '本日征服次数已用完';
        exit;
    }
    $userInfo['mark'] = 'user';
//    $userFightTeam[]        = Fight::createUserFightable($userInfo['user_id'], $userInfo['user_level'],'user');
//    $targetUserFightTeam[]  = Fight::createUserFightable($targetUserInfo['user_id'], $targetUserInfo['user_level'],'target');
    $teams['user'][]        = NewFight::createUserObj($userInfo);
    $targetUserInfo['mark'] = 'target';
    $teams['target'][]  = NewFight::createUserObj($targetUserInfo);

    $data['participant']['user']    = NewFight::getPeopleFightInfo($teams['user'][0], $userInfo);
    $data['participant']['target']  = NewFight::getPeopleFightInfo($teams['target'][0], $targetUserInfo);
//    $data['participant']['user']    = Fight::getPeopleFightInfo($userFightTeam[0], $userInfo);
//    $data['participant']['target']  = Fight::getPeopleFightInfo($userFightTeam[0], $targetUserInfo);
    /**获取战斗结果**/
//    $fightResult            = Fight::multiFight($userFightTeam, $targetUserFightTeam);
    $fightResult            = NewFight::getFightResult($teams);

//    $isUserAlive = Fight::isTeamAlive($userFightTeam);
//    $isTargetUserAlive = Fight::isTeamAlive($targetUserFightTeam);
    $isUserAlive = NewFight::isTeamAlive($teams['user']);
    $isTargetUserAlive = NewFight::isTeamAlive($teams['target']);
    $data['fight_procedure']        = $fightResult['fight_procedure'];
    $data['result']['win']          = $isUserAlive && !$isTargetUserAlive ? 1 : 0;
    /**
     * @todo 是否在这里处理征服符咒减一？
     * 还是说前端来自己调用接口减一？
     * **/
    if($userInfo['pk_num'] > 0 && !$isCanFight['is_free']) {
        User_Info::subtractPKNum($userId, 1);
    }
    //本次本用户征服次数加1
    PK_Conf::setConquerTimes($userId);
}  catch (Exception $e) {
    $code = $e->getCode();
    $msg  = $e->getMessage();
}

