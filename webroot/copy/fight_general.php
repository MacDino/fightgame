<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$copyId     = isset($_REQUEST['copy_id']) ? $_REQUEST['copy_id'] : 0;

$copy = Copy::getCopyInfoByCopyId($copyId); 
if (!$copy) {
	$code = 170001; $msg = "无此副本";exit;
}
$userInfo           = User_Info::getUserInfoByUserId($userId);
if ( $userInfo['user_level'] < $copy['level_limit']) {
	$code = 170002;
	$msg = "您当前的等级未达到此副本的要求";
	exit();
}

if($userId <=0 ) {
    $code = 170003; $msg = '没有对应的人物';
    exit();
}
$userLastCopyResult     = Copy_FightResult::getResult($userId, 0, $copyId);
if(is_array($userLastCopyResult) && count($userLastCopyResult)) {
	$jsonResult = json_decode($userLastCopyResult['last_fight_result'], TRUE);
	$lastIsWin = $jsonResult['result']['win'];
	$lastFightDate = date("Y-m-d",strtotime($userLastCopyResult['create_time']));
	$isTodayFight = $lastFightDate == date("Y-m-d", time());
	/*
	 * 限制每天打一次此副本
	 */
	if ( $isTodayFight && !$lastIsWin) {
		$code = 170004;	
		exit;
	}
	/*
	 * 已打赢的副本则不再重复进入
	 */
	if ($userLastCopyResult['win_monster_num'] >= $copy['monster_num']) {
		$code = 170005;
		exit;	
	}

    $accessDiffTime = time() - $userLastCopyResult['fight_start_time'];//一定为大于0的值
    if($accessDiffTime < $userLastResult['use_time']) {
        //调用时间小于应该花费的时间
        $result = json_decode($userLastResult['last_fight_result']);
        $code   = 0;
        $data   = $result;
        exit();
    }
}
$copyLevId = $copyLevId > 0 ? $copyLevId : ($userLastResult['copy_level_id'] > 0 ? $userLastResult['copy_level_id'] : 1);

$monsterGroupDeadCount = 0;
while($monsterGroupDeadCount<2){
	try {
		//判断调用哪一组怪
		if ($monsterGroupDeadCount == 0) {
			$monster            = Copy_Config::getGroupMonsterByCopyId($copyId, 1, $userInfo['user_level']);
		} else {
			$monster            = Copy_Config::getGroupMonsterByCopyId($copyId, 2, $userInfo['user_level']);
		}
		//print_r($monster);
		foreach ($monster as $k=>$v) {
			$monster[$k]['mark'] = 'monster['.$k.']';
		}
		foreach ($monster as $k=>$v) {
			$teams['monster'][] = Copy_Fight::createGeneralMonsterFightable($v);
		}
		foreach ($monster as $k=>$v) {
    		$data['participant']['monster'][]    = NewFight::getMonsterFightInfo($teams['monster'][$k], $v);
		}

		//当前角色fight对象，如果有人宠，获取人宠
    	$userInfo['mark']   = 'user';
    	$teams['user'][]    = NewFight::createUserObj($userInfo);
    	$data['participant']['user'] = NewFight::getPeopleFightInfo($teams['user'][0], $userInfo);


		if($userInfo['user_level'] > 10) {
			$petInfo    = Pet::usedPet($userId);
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

    	$fightResult = NewFight::getFightResult($teams);
		$fightUseTime   = $fightResult['use_time'];

		$data['fight_procedure']  =  $fightResult['fight_procedure'];
    	$isUserAlive = NewFight::isTeamAlive($teams['user']);
    	$isMonsterAlive = NewFight::isTeamAlive($teams['monster']);
		$data['result']['use_time'] = $fightUseTime;
		if(!$isUserAlive && $isMonsterAlive) {
			$data['result']['win']  = 0;
			$msg    = '您被打败了';
			break;
		} else {
			$data['result']['win']  = 1;
			$data['result']['experience']         = Monster::getMonsterExperience($monster);
			$data['result']['money']              = Monster::getMonsterMoney($monster);
			$data['result']['equipment']          = Monster::getMonsterEquipment($monster);
			$msg                        = '怪物已消灭';

			$monsterGroupDeadCount++;
			/*
			 * 打赢时，怪物计数
			 * 否则重新计数
			 */
			if(isset($isTodayFight) && $isTodayFight) {
				$win_monster_count = $userLastCopyResult['win_monster_num'] + 2;
			} else {
				$win_monster_count = 2;
			}

			/*
			 * 每层完成时,领取奖励
			 */
			if ($win_monster_count == $copy['win_monster_num']) {
				//记录通关次数
				$passedTime = $userLastCopyResult['passed_time'] + 1;
				getReward($userId, $copyId);
			}

			User_Info::addExperience($userId, $data['result']['experience'] * 2);

			$data['result']['experience_sum']   =  $userInfo['experience'];

			$isLevelUp = User_Info::isLevel($userId);
			if($isLevelUp) {
				$data['result']['level_up'] = $isLevelUp;
			}
			$data['result']['win_monster_num'] = $win_monster_count;

			User_Info::addMoney($userId, $data['result']['money'] * 2);

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
}

 /**记录战斗结果入库，战斗记录一个用户永远只保存一条**/
$result = array(
    'user_id'   => $userId,
    'copy_id'    => $copyId,
    'use_time'  => $fightUseTime,
    'last_fight_result' => $data,
	'win_monster_num'   => $win_monster_count,
	'passed_time'	=> $passedTime,
);
Copy_FightResult::create($result);





function getReward($userId, $copyId){
	$copySecond = array (
		EQUIP_COLOUR_BLUE => EQUIP_TYPE_ARMS,
		EQUIP_COLOUR_PURPLE => EQUIP_TYPE_ARMS,
		EQUIP_COLOUR_ORANGE => EQUIP_TYPE_ARMS,
		EQUIP_COLOUR_BLUE => EQUIP_TYPE_CLOTHES,
		EQUIP_COLOUR_PURPLE => EQUIP_TYPE_CLOTHES,
		EQUIP_COLOUR_ORANGE => EQUIP_TYPE_CLOTHES,
	);	
	$copyThird = array(
		EQUIP_COLOUR_BLUE => EQUIP_TYPE_HELMET,
		EQUIP_COLOUR_PURPLE => EQUIP_TYPE_HELMET,
		EQUIP_COLOUR_ORANGE => EQUIP_TYPE_HELMET,
		EQUIP_COLOUR_BLUE => EQUIP_TYPE_NECKLACE,
		EQUIP_COLOUR_PURPLE => EQUIP_TYPE_NECKLACE,
		EQUIP_COLOUR_ORANGE => EQUIP_TYPE_NECKLACE,
	);
	$copyForth = array (
		EQUIP_COLOUR_BLUE => EQUIP_TYPE_BELT,
		EQUIP_COLOUR_PURPLE => EQUIP_TYPE_BELT,
		EQUIP_COLOUR_ORANGE => EQUIP_TYPE_BELT,
		EQUIP_COLOUR_BLUE => EQUIP_TYPE_SHOES,
		EQUIP_COLOUR_PURPLE => EQUIP_TYPE_SHOES,
		EQUIP_COLOUR_ORANGE => EQUIP_TYPE_SHOES,
	);
	switch ($copyId) {
		case 2:
			$equipColour = array_rand($copySecond);
			$equipType = $copySecond[$equipColour];
			break;
		case 3:
			$equipColour = array_rand($copyThird);
			$equipType = $copyThird[$equipColour];
			break;
		case 4:
			$equipColour = array_rand($copyForth);
			$equipType = $copyForth[$equipColour];
			break;
	}
	//Equip_Create::createEquip($equipColour, $userId, $equipLevel, $equipType);
}
