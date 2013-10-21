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
$mapId = $mapId > 0 ? $mapId : ($userLastResult['map_id'] > 0 ? $userLastResult['map_id'] : 1);

//装备保留的颜色组
if(isset($_REQUEST['colors'])) {
    Fight_Setting::create($userId, $_REQUEST['colors']);
}
try {
    /**初始化一个怪物**/
    $monster            = Map::getMonster($mapId);
    $monsterFightTeam[] = Fight::createMonsterFightable($monster, 'monster[0]');
    $data['participant']['monster'][]    = Fight::getMonsterFightInfo($monsterFightTeam[0], $monster);
    /**当前角色fight对象，如果有人宠，获取人宠**/
    $userInfo           = User_Info::getUserInfoByUserId($userId);
    $userFightTeam[]    = Fight::createUserFightable($userId, $userInfo['user_level'], 'user');

    $data['participant']['user'] = Fight::getPeopleFightInfo($userFightTeam[0], $userInfo);

    if($userInfo['user_level'] > 10) {
        $petInfo    = Pet::usedPet($userId);
        if(is_array($petInfo) && count($petInfo)) {
            $userPetInfo = User_Info::getUserInfoByUserId($petInfo['pet_id']);
            //人宠进入队伍
            $userFightTeam[] = Fight::createUserFightable($userPetInfo['user_id'], $userPetInfo['user_level'],'pet');
            $data['participant']['pet'] = Fight::getPeopleFightInfo($userFightTeam[1], $userPetInfo);
        }else{
        	$data['participant']['pet'] = NULL;//没有人宠时给空值
        }
    }

    /**进入多人对单怪的战斗**/
    $fightResult = Fight::multiFight($userFightTeam, $monsterFightTeam);
    /**此次战斗耗时 * **/
    $fightUseTime   = $fightResult['use_time'];

    $data['fight_procedure']  =  $fightResult['fight_procedure'];
    $isUserAlive = Fight::isTeamAlive($userFightTeam);
    $isMonsterAlive = Fight::isTeamAlive($monsterFightTeam);
    $data['result']['use_time'] = $fightUseTime;
    if(!$isUserAlive && $isMonsterAlive || $fightResult['is_too_long'] == 1) {
        $data['result']['win']      = 0;
        $data['result']['is_dead']  = 1;
        if($fightResult['is_too_long'] == 1) {
            $data['result']['is_dead'] = 0;
        }
        $msg    = '您被打败了';
    } else {
        $data['result']['win']  = 1;
        $data['result']['experience']         = Monster::getMonsterExperience($monster);
        $data['result']['money']              = Monster::getMonsterMoney($monster);
        $data['result']['equipment']          = Monster::getMonsterEquipment($monster);
        $msg                        = '怪物已消灭';
        User_Info::addExperience($userId, $data['result']['experience']);
        $isLevelUp                  = User_Info::isLevel($userId);
        if($isLevelUp) {
            $data['result']['level_up'] = $isLevelUp;
        }

        User_Info::addMoney($userId, $data['result']['money']);

        if(is_array($data['result']['equipment']) && count($data['result']['equipment'])) {
            $getEquipSetting = Fight_Setting::isEquipMentCan($userId);
            foreach ($data['result']['equipment'] as $equipment) {
                if($getEquipSetting[$equipment['color']]) {
                    Equip::createEquip($equipment['color'], $userId, $equipment['level']);
                }
            }
        }

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