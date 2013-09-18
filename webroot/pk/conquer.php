<?php
/**
 * 征服模式
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : 0;
$targetUserId = $_REQUEST['target_id'] > 0 ? $_REQUEST['target_id'] : 0;
try{
    $userInfo = User_Info::getUserInfoByUserId($userId);
    $targetUserInfo = User_Info::getUserInfoByUserId($targetUserId);
    if(!(is_array($userInfo) && count($userInfo)) || !(is_array($targetUserInfo) && count($targetUserInfo))) {
        $code = 1;
        $msg  = '不存在的用户';
        exit();
    }
    /**
     * @todo 不知道是否需要加载人宠
     * **/
    $userFightTeam[]        = Fight::createUserFightable($userInfo['user_id'], $userInfo['user_level']);

    $targetUserFightTeam[]  = Fight::createUserFightable($targetUserInfo['user_id'], $targetUserInfo['user_level']);
    /**获取战斗结果**/
    $fightResult            = Fight::multiFight($userFightTeam, $targetUserFightTeam);

    $isUserAlive = $isTargetUserAlive = FALSE;
    foreach ($userFightTeam as $userFight) {
        $isUserAlive = $userFight->isAlive() || $isUserAlive;
    }
    foreach ($targetUserFightTeam as $targetUserFight) {
        $isTargetUserAlive = $targetUserFight->isAlive() || $isTargetUserAlive;
    }

    if(!$isUserAlive && $isTargetUserAlive) {
        $msg = '您输掉了此次战斗';
    }  else {
        //
//        $data['']
    }


}  catch (Exception $e) {
    $code = $e->getCode();
    $msg  = $e->getMessage();
}

