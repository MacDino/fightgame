<?php
/**
 * 单人/多人 对战 单怪物
 * @author lishengwei
 * 战斗结果的数据体结构需要进行重构
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId             = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$mapId              = isset($_REQUEST['map_id']) ? $_REQUEST['map_id'] : 0;
if($userId <=0 ) {
    $code = 1; $msg = '没有对应的人物';
    exit();
}
$userLastResult     = Fight_Result::getResult($userId, $mapId);
if(is_array($userLastResult) && count($userLastResult)) {
    $accessDiffTime = time() - $userLastResult['fight_start_time'];//一定为大于0的值
    if($accessDiffTime < $userLastResult['use_time']) {
        //调用时间小于应该花费的时间
        $result = json_decode($userLastResult['last_fight_result']);
        $code   = 0;
        $data   = $result;
        exit();
    }
}

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
    /**此次战斗耗时
     * @todo 定义完毕战斗数据结构体后，此部分计算需要在fight类中计算好后返回
     * **/
    $fightUseTime   = count($fightProcedure) * Fight::FIGHT_USE_TIME_BASE;

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
        /**
         * @todo 经验和金钱数据入用户库里
         * @todo 装备计算以及装备数据入用户库里
         * **/
    }
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '攻击操作失败';
}

 /**记录战斗结果入库，战斗记录一个用户永远只保存一条**/
$result = array(
    'user_id'   => $userId,
    'map_id'    => $mapId,
    'use_time'  => $fightUseTime,
    'last_fight_result' => $data,
);
Fight_Result::create($result);