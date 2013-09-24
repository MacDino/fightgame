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
//获取此用户挑战次数
//@todo

$isCanFight = PK_Conf::isCanFight($userId, PK_Conf::PK_MODEL_CHALLENGE);

if(!$isCanFight['is_can']) {
    $code = 1;
    $msg  = '没有挑战次数了';
    exit();
}
try {
    $userFightTeam[] = Fight::createUserFightable($userId, $userInfo['user_id']);
    $userPetInfo     = array('user_id' => 27);
    if(is_array($userPetInfo) && count($userPetInfo)) {
        $userPetInfo = User_Info::getUserInfoByUserId($userPetInfo['user_id']);
        //人宠进入队伍
        $userFightTeam[] = Fight::createMonsterFightable($userPetInfo['user_id'], $userPetInfo['user_level']);
        $data['pet'] = Fight::getPeopleFightInfo($userFightTeam[1]);
    }

    /**@todo 随即出来一个战斗对象**/
    $targetUserId   = '';
    $targetUserInfo = User_Info::getUserInfoByUserId($targetUserId);
    $targetUserFightTeam[] = Fight::createUserFightable($targetUserId, $targetUserInfo['user_level']);

    $fightResult = Fight::multiFight($userFightTeam, $targetUserFightTeam);

    $isUserAlive = $isTargetUserAlive = FALSE;
    foreach ($userFightTeam as $userFight) {
        $isUserAlive = $userFight->isAlive() || $isUserAlive;
    }
    foreach ($targetUserFightTeam as $targetUserFight) {
        $isTargetUserAlive = $targetUserFight->isAlive() || $isTargetUserAlive;
    }
    $data['fight_procedure'] = $fightResult['fight_procedure'];
    $data['winner'] =array('user_id' => $isUserAlive && !$isTargetUserAlive ? $userId : $targetUserId);
    if($isUserAlive && !$isTargetUserAlive) {
        /**@todo 记录声望，是否连胜5场，是的话记录积分，记录连胜场次**/
    } else {
        /**@todo 战斗退出 显示战果**/
    }

} catch (Exception $exc) {
    $code = $e->getCode();
    $msg  = $e->getMessage();
}
