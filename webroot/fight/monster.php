<?php
/**
 * 单人/多人 对战 单怪物
 * @author lishengwei
 * 战斗结果的数据体结构需要进行重构
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId             = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$mapId              = isset($_REQUEST['map_id']) ? $_REQUEST['map_id'] : 0;
/**初始化一个怪物**/
$monster            = Map::getMonster($mapId);
$monsterFightTeam[] = Monster::fightable($monster);
/**当前角色fight对象，如果有人宠，获取人宠**/
$userInfo           = User_Info::getUserInfoByUserId($userId);
$userFightTeam[]    = User_Info::fightable($userId, $userInfo['user_level']);
if($userInfo['user_level'] > 40) {
    /**
     * 获取人宠
     * @todo 获取郑毅锋的接口数据
     * **/
    $userPetInfo    = array('user_id' => 27);
    if(is_array($userPetInfo) && count($userPetInfo)) {
        $userPetInfo = User_Info::getUserInfoByUserId($userPetInfo['user_id']);
        //人宠进入队伍
        $userFightTeam[] = User_Info::fightable($userPetInfo['user_id'], $userPetInfo['user_level']);
    }
}

try {
    /**进入多人对单怪的战斗**/
    $fightProcedure = Fight::multiFight($userFightTeam, $monsterFightTeam);
    $data = array(
        'fight_procedure' => $fightProcedure
    );
    $isUserAlive = $isMonsterAlive = FALSE;
    foreach ($userFightTeam as $userFight) {
        $isUserAlive = $userFight->isAlive() || $isUserAlive;
    }
    foreach ($monsterFightTeam as $monsterFight) {
        $isMonsterAlive = $monsterFight->isDead() || $isMonsterAlive;
    }
    if(!$isUserAlive) {
        $msg    = '您被打败了';
    } else {
        $data['fight_procedure']    = $fightProcedure;
        $data['experience']         = Monster::getMonsterExperience($monster);
        $data['money']              = Monster::getMonsterMoney($monster);
        $data['equipment_color']    = Monster::getMonsterEquipmentColor($monster);
        $msg                        = '怪物已消灭';
    }
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '攻击操作失败';
}