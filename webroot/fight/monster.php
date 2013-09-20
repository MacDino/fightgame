<?php
/**
 * 单人/多人 对战 单怪物
 * @author lishengwei
 * 战斗结果的数据体结构需要进行重构
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(E_ALL || ~E_NOTICE); //显示除去 E_NOTICE 之外的所有错误信息

$userId             = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$mapId              = isset($_REQUEST['map_id']) ? $_REQUEST['map_id'] : 0;
if($userId <=0 ) {
    $code = 1; $msg = '没有对应的人物';
    exit();
}
//$userLastResult     = Fight_Result::getResult($userId, $mapId);
if(is_array($userLastResult) && count($userLastResult)) {
    $accessDiffTime = time() - $userLastResult['fight_start_time'];//一定为大于0的值
    if($accessDiffTime < $userLastResult['use_time']) {
        //调用时间小于应该花费的时间
        $result = json_decode($userLastResult['last_fight_result']);
        $code   = 0;
        $data   = $result;
        exit();
    }
    $mapId = $mapId > 0 ? $mapId : $userLastResult['map_id'];
}
if($mapId <=0 ) {
    $code = 1; $msg = '请选择对应地图';
    exit();
}

try {
    /**初始化一个怪物**/
    $monster            = Map::getMonster($mapId);

    $monsterFightTeam[] = Fight::createMonsterFightable($monster);
    $data['monster']    = Fight::getMonsterFightInfo($monsterFightTeam[0], $monster);
    /**当前角色fight对象，如果有人宠，获取人宠**/
    $userInfo           = User_Info::getUserInfoByUserId($userId);
    $userFightTeam[]    = Fight::createUserFightable($userId, $userInfo['user_level']);

    $data['user']       = Fight::getPeopleFightInfo($userFightTeam[0]);

    if($userInfo['user_level'] > 40) {
        /**
         * 获取人宠
         * @todo 获取郑毅锋的接口数据
         * **/
        $userPetInfo    = array('user_id' => 27);
        if(is_array($userPetInfo) && count($userPetInfo)) {
            $userPetInfo = User_Info::getUserInfoByUserId($userPetInfo['user_id']);
            //人宠进入队伍
            $userFightTeam[] = Fight::createUserFightable($userPetInfo['user_id'], $userPetInfo['user_level']);
            $data['pet'] = Fight::getPeopleFightInfo($userFightTeam[1]);
        }
    }

    /**进入多人对单怪的战斗**/
    $fightResult = Fight::multiFight($userFightTeam, $monsterFightTeam);
    /**此次战斗耗时 * **/
    $fightUseTime   = $fightResult['use_time'];

    $data['fight_procedure'] =  $fightResult['fight_procedure'];
    $isUserAlive = $isMonsterAlive = FALSE;
    foreach ($userFightTeam as $userFight) {
        $isUserAlive = $userFight->isAlive() || $isUserAlive;
    }
    foreach ($monsterFightTeam as $monsterFight) {
        $isMonsterAlive = $monsterFight->isAlive() || $isMonsterAlive;
    }
    if(!$isUserAlive && $isMonsterAlive) {
        $msg    = '您被打败了';
    } else {
        $data['experience']         = Monster::getMonsterExperience($monster);
        $data['money']              = Monster::getMonsterMoney($monster);
        $data['equipment']          = Monster::getMonsterEquipment($monster);
        $msg                        = '怪物已消灭';
        User_Info::addExperience($userId, $data['experience']);
//        $data['level_up'] = User_Info::isLevel($userId);
        User_Info::addMoney($userId, $data['money']);

        if(is_array($data['equipment']) && count($data['equipment'])) {
            foreach ($data['equipment'] as $equipment) {
                Equip::createEquip($equipment['color'], $userId, $equipment['level'], $equipment['equipment']);
            }
        }

    }
    print_r($data);
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