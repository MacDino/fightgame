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
    /**
     * @todo 获取用户的征服次数
     * **/
    $isCanFight = PK_Conf::isCanFight($userId, PK_Conf::PK_MODEL_CONQUER);
    if(!$isCanFight['is_free'] && $userInfo['pk_num'] <= 0) {
        $code = 1;
        $msg = '本日征服次数已用完';
        exit;
    }

    $userFightTeam[]        = Fight::createUserFightable($userInfo['user_id'], $userInfo['user_level'],'user');
    $targetUserFightTeam[]  = Fight::createUserFightable($targetUserInfo['user_id'], $targetUserInfo['user_level'],'target');
    /**获取战斗结果**/
    $fightResult            = Fight::multiFight($userFightTeam, $targetUserFightTeam);

    $isUserAlive = $isTargetUserAlive = FALSE;
    foreach ($userFightTeam as $userFight) {
        $isUserAlive = $userFight->isAlive() || $isUserAlive;
    }
    foreach ($targetUserFightTeam as $targetUserFight) {
        $isTargetUserAlive = $targetUserFight->isAlive() || $isTargetUserAlive;
    }
    $data['participant']['user']    = Fight::getPeopleFightInfo($userFightTeam[0], $userInfo);
    $data['participant']['target']  = Fight::getPeopleFightInfo($userFightTeam[0], $targetUserInfo);
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

