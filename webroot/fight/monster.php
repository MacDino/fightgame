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

$isRobot = RobotFight::getInfoByUserId($userId);
if(is_array($isRobot) && count($isRobot) && $isRobot != 1) {
    RobotFight::updateStatus($userId, $isRobot['map_id']);
}
//装备保留的颜色组
if(isset($_REQUEST['colors'])) {
    Fight_Setting::create($userId, $_REQUEST['colors']);
}
try {
    /**初始化一个怪物**/
    $monster            = Map::getMonster($mapId);
//    $monsterFightTeam[] = Fight::createMonsterFightable($monster, 'monster[0]');
    $monster['mark'] = 'monster[0]';
    $teams['monster'][] = NewFight::createMonsterObj($monster);

//    $data['participant']['monster'][]    = Fight::getMonsterFightInfo($monsterFightTeam[0], $monster);
    $data['participant']['monster'][]    = NewFight::getMonsterFightInfo($teams['monster'][0], $monster);
    /**当前角色fight对象，如果有人宠，获取人宠**/
    $userInfo           = User_Info::getUserInfoByUserId($userId);
    $userInfo['mark']   = 'user';
//    $userFightTeam[]    = Fight::createUserFightable($userId, $userInfo['user_level'], 'user');
    $teams['user'][]    = NewFight::createUserObj($userInfo);

//    $data['participant']['user'] = Fight::getPeopleFightInfo($userFightTeam[0], $userInfo);
    $data['participant']['user'] = NewFight::getPeopleFightInfo($teams['user'][0], $userInfo);

    if($userInfo['user_level'] > 10) {
        $friendIdRes    = Friend_Info::isUseFriend($userId);
        $petInfo        = User_Info::getUserInfoByUserId((int)$friendIdRes[0]['friend_id']);
        if(is_array($petInfo) && count($petInfo)) {
            //人宠进入队伍
//            $userFightTeam[] = Fight::createUserFightable($petInfo['user_id'], $petInfo['user_level'],'pet');
            $petInfo['mark'] = 'pet';
            $teams['user'][] = NewFight::createUserObj($petInfo);
//            $data['participant']['pet'] = Fight::getPeopleFightInfo($userFightTeam[1], $petInfo);
            $data['participant']['pet'] = NewFight::getPeopleFightInfo($teams['user'][1], $petInfo);
        }else{
        	$data['participant']['pet'] = NULL;//没有人宠时给空值
        }
    }

    /**进入多人对单怪的战斗**/
//    $fightResult = Fight::multiFight($userFightTeam, $monsterFightTeam);
    $fightResult = NewFight::getFightResult($teams);
    /**此次战斗耗时 * **/
    $fightUseTime   = $fightResult['use_time'];

    $data['fight_procedure']  =  $fightResult['fight_procedure'];
//    $isUserAlive = Fight::isTeamAlive($userFightTeam);
//    $isMonsterAlive = Fight::isTeamAlive($monsterFightTeam);
    $isUserAlive = NewFight::isTeamAlive($teams['user']);
    $isMonsterAlive = NewFight::isTeamAlive($teams['monster']);
    $data['result']['use_time'] = $fightUseTime;

    if(!DEVELOPER && $fightUseTime > 119) {
        sae_set_display_errors(false);//关闭信息输出
        sae_debug(json_encode($data));//记录日志
        sae_set_display_errors(true);
    }

    if(!$isUserAlive && $isMonsterAlive || $fightResult['is_too_long'] == 1) {
        $data['result']['win']      = 0;
        $data['result']['is_dead']  = 1;
        if($fightResult['is_too_long'] == 1) {
            $data['result']['is_dead'] = 0;
        }
        $msg    = '您被打败了';
    } else {
        try{
            $isDuoble = User_Property::isuseDoubleHarvest($userId);
        }  catch (Exception $e) {
            $isDuoble = FALSE;
        }
        $double = $isDuoble ? 2 : 1;
        $data['result']['win']  = 1;
        $data['result']['experience']         = (int)Monster::getMonsterExperience($monster) * $double;
        $data['result']['money']              = (int)Monster::getMonsterMoney($monster) * $double;
        $data['result']['equipment']          = Monster::getMonsterEquipment($monster);
        $msg                        = '怪物已消灭';
        User_Info::addExperience($userId, $data['result']['experience']);
        $data['result']['experience_sum']   =  $userInfo['experience'];
        $isLevelUp                  = User_Info::isLevel($userId);
        if($isLevelUp) {
            $data['result']['level_up'] = $isLevelUp;
        }
        User_Info::addMoney($userId, $data['result']['money']);
        if(is_array($data['result']['equipment']) && count($data['result']['equipment'])) {
            $getEquipSetting = Fight_Setting::isEquipMentCan($userId);
            foreach ($data['result']['equipment'] as $equipKey => $equipment) {
                if($getEquipSetting[$equipment['color']]) {
                    $equipmentNum = Equip_Info::getEquipNum($userId);
                    $equipmentSurplus = $userInfo['pack_num'] - intval($equipmentNum);
                    $equipmentSurplus = $equipmentSurplus > 0 ? $equipmentSurplus : 0;
                    $data['result']['equipment'][$equipKey]['get'] = 0;
                    if($equipmentSurplus > 0) {
                        $get = Equip::createEquip($equipment['color'], $userId, $equipment['level'], $equipment['equipment']);
                        $data['result']['equipment'][$equipKey]['get'] = 1;
                    }
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
