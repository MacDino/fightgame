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
$userLastCopyResult     = Copy_FightResult::getResult($userId, 0, $copyId, date("Y-m-d",time()));
if(is_array($userLastCopyResult) && count($userLastCopyResult)) {
	$jsonResult = json_decode($userLastCopyResult['last_fight_result'], TRUE);
	$lastIsWin = $jsonResult['result']['win'];
	$lastFightDate = date("Y-m-d",strtotime($userLastCopyResult['create_time']));
	$isTodayFight = $lastFightDate == date("Y-m-d", time());

	$preMonsterGroup = $jsonResult['result']['monster_group'];
	/*
	 * 限制每天打一次此副本
	 */
	if ( $isTodayFight && !$lastIsWin) {
		//$code = 170004;	
		//exit;
	}
	/*
	 * 已打赢的副本则不再重复进入
	 */
	if ($userLastCopyResult['win_monster_num'] >= $copy['monster_num']) {
		//$code = 170005;
		//exit;	
	}

    $accessDiffTime = time() - $userLastCopyResult['fight_start_time'];//一定为大于0的值
    if($accessDiffTime < $userLastCopyResult['use_time']) {
        //调用时间小于应该花费的时间
        $result = json_decode($userLastCopyResult['last_fight_result']);
        $code   = 0;
        $data   = $result;
        exit();
	}
}


//$monsterGroupDeadCount = 0;
//while($monsterGroupDeadCount<2){
	try {
		//判断调用哪一组怪
		if ($preMonsterGroup == 2||!$preMonsterGroup) {
			$monster_group = 1;
			$monster            = Copy_Config::getGroupMonsterByCopyId($copyId, 1, $userInfo['user_level']);
		} else {
			$monster_group = 2;
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
			$monsterFightInfo = NewFight::getMonsterFightInfo($teams['monster'][$k], $v);
			$data['participant']['monster'][]    = $monsterFightInfo;
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
		$data['result']['experience_sum']   =  $userInfo['experience'];
		/*
		 * 处理一组怪物中单个怪物死亡时，掉落
		 */
		foreach ($teams['monster'] as $k=>$obj) {
			if(!$obj->isAlive()) {
				$data['result'][$k]['experience']  = Monster::getMonsterExperience($monster[$k]) * 2;
				$data['result'][$k]['money']       = Monster::getMonsterMoney($monster[$k]) * 2;
				$data['result'][$k]['equipment']   = Monster::getMonsterEquipment($monster[$k]);

              	//经验掉落
				User_Info::addExperience($userId, $data['result']['experience']);
				//金钱掉落
				User_Info::addMoney($userId, $data['result']['money']);
				//装备掉落
				if(is_array($data['result']['equipment']) && count($data['result']['equipment'])) {
					$getEquipSetting = Fight_Setting::isEquipMentCan($userId);
					foreach ($data['result']['equipment'] as $equipment) {
						if($getEquipSetting[$equipment['color']]) {
							Equip::createEquip($equipment['color'], $userId, $equipment['level']);
						}
					}
				}
			}
		}


		if(!$isUserAlive && $isMonsterAlive) {
			$data['result']['win']  = 0;
			$msg    = '您被打败了';
		} else {
			$data['result']['win']  = 1;
			/*
			$data['result']['experience']         = Monster::getMonsterExperience($monster);
			$data['result']['money']              = Monster::getMonsterMoney($monster);
			$data['result']['equipment']          = Monster::getMonsterEquipment($monster);
			 */
			$msg                        = '怪物已消灭';

			$monsterGroupDeadCount++;
			/*
			 * 打赢时，怪物计数
			 * 否则重新计数
			 */
			if(isset($isTodayFight) && $isTodayFight) {
				$win_monster_count = $userLastCopyResult['win_monster_num'] + 2;
				//$win_monster_count = 4;
			} else {
				$win_monster_count = 2;
			}

			/*
			 * 每层完成时,领取奖励
			 */
			if ($win_monster_count%$copy['monster_num'] == 0) {
				//记录通关次数
				$passedTime = $userLastCopyResult['passed_time'] + 1;
				$data['result']['passed_time'] = $passedTime;

				$data['result']['reward'] = getReward($userId, $copyId, 0 , $monster[0]['map_id']);
				$data['result']['reward_count'] = Copy_RewardLog::getCountGroupByType($userId, $copyId, 0);
			}


			$isLevelUp = User_Info::isLevel($userId);
			if($isLevelUp) {
				$data['result']['level_up'] = $isLevelUp;
			}
			$data['result']['win_monster_num'] = $win_monster_count;
			$data['result']['monster_group'] = $monster_group; 
		}
		$code   = 0;
	} catch (Exception $e) {
		$code   = 1;
		$msg    = '攻击操作失败';
	}
//}
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





function getReward($userId, $copyId, $levelId = 0, $mapId){
	$copySecond = array (
		Equip::EQUIP_COLOUR_BLUE => Equip::EQUIP_TYPE_ARMS,
		Equip::EQUIP_COLOUR_PURPLE => Equip::EQUIP_TYPE_ARMS,
		Equip::EQUIP_COLOUR_ORANGE => Equip::EQUIP_TYPE_ARMS,
		Equip::EQUIP_COLOUR_BLUE => Equip::EQUIP_TYPE_CLOTHES,
		Equip::EQUIP_COLOUR_PURPLE => Equip::EQUIP_TYPE_CLOTHES,
		Equip::EQUIP_COLOUR_ORANGE => Equip::EQUIP_TYPE_CLOTHES,
	);	
	$copyThird = array(
		Equip::EQUIP_COLOUR_BLUE => Equip::EQUIP_TYPE_HELMET,
		Equip::EQUIP_COLOUR_PURPLE => Equip::EQUIP_TYPE_HELMET,
		Equip::EQUIP_COLOUR_ORANGE => Equip::EQUIP_TYPE_HELMET,
		Equip::EQUIP_COLOUR_BLUE => Equip::EQUIP_TYPE_NECKLACE,
		Equip::EQUIP_COLOUR_PURPLE => Equip::EQUIP_TYPE_NECKLACE,
		Equip::EQUIP_COLOUR_ORANGE => Equip::EQUIP_TYPE_NECKLACE,
	);
	$copyForth = array (
		Equip::EQUIP_COLOUR_BLUE => Equip::EQUIP_TYPE_BELT,
		Equip::EQUIP_COLOUR_PURPLE => Equip::EQUIP_TYPE_BELT,
		Equip::EQUIP_COLOUR_ORANGE => Equip::EQUIP_TYPE_BELT,
		Equip::EQUIP_COLOUR_BLUE => Equip::EQUIP_TYPE_SHOES,
		Equip::EQUIP_COLOUR_PURPLE => Equip::EQUIP_TYPE_SHOES,
		Equip::EQUIP_COLOUR_ORANGE => Equip::EQUIP_TYPE_SHOES,
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
	$equipLevel = Monster::getMonsterEquipmentLevel($mapId);
	$equipId = Equip_Create::createEquip($equipColour, $userId, $equipLevel, $equipType);
	$logData = array(
		'copy_id' => $copyId,
		'level_id'=> $levelId ? $levelId : 0,
		'type'	  => "equip",
		'num'	  => 1,
		'ctime'	  => time(),
		'equip_id'=> $equipId,		
		'user_id' => $userId,
	);
	Copy_RewardLog::insert($logData);
	return Equip_Info::getEquipInfoById($equipId);
}
