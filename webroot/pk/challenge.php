<?php
/**
 * 挑战模式
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
$challengeTimes = 5;
if($challengeTimes <= 0) {
    $code = 1;
    $msg  = '没有挑战次数了';
    exit();
}
$userFightTeam[] = Fight::createUserFightable($userId, $userInfo['user_id']);
$userPetInfo     = array('user_id' => 27);
if(is_array($userPetInfo) && count($userPetInfo)) {
    $userPetInfo = User_Info::getUserInfoByUserId($userPetInfo['user_id']);
    //人宠进入队伍
    $userFightTeam[] = Fight::createMonsterFightable($userPetInfo['user_id'], $userPetInfo['user_level']);
    $data['pet'] = Fight::getPeopleFightInfo($userFightTeam[1]);
}



