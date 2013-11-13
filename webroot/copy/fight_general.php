<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$copyId     = isset($_REQUEST['copy_id']) ? $_REQUEST['copy_id'] : 0;

$copy = Copy::getCopyInfoByCopyId($copyId); 
if (!$copy) {
	$code = 1; $msg = "无此副本";exit;
}
$userInfo           = User_Info::getUserInfoByUserId($userId);
if ( $userInfo['user_level'] < $copy['level_limit']) {
	$code = 100050;
	$msg = "您当前的等级未达到此副本的要求";
	exit();
}

if($userId <=0 ) {
    $code = 1; $msg = '没有对应的人物';
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
		$code = 100090;	
		exit;
	}
	/*
	 * 已打赢的副本则不再重复进入
	 */
	if ($userLastCopyResult['win_monster_num'] == $copy['monster_num']) {
		$code = 100091;
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
		$monsterFightTeam[] = Copy_Fight::createMonsterFightable($monster, 'copy');
		$monsterFightInfo = Fight::getMonsterFightInfo($monsterFightTeam[0], $monster);
		$data['participant']['monster'][]  = $monsterFightInfo;


		//当前角色fight对象，如果有人宠，获取人宠
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

		$fightResult = Fight::multiFight($userFightTeam, $monsterFightTeam);
		$fightUseTime   = $fightResult['use_time'];

		$data['fight_procedure']  =  $fightResult['fight_procedure'];
		$isUserAlive = Fight::isTeamAlive($userFightTeam);
		$isMonsterAlive = Fight::isTeamAlive($monsterFightTeam);
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
			 * 每天打过100个怪，则通关,启动下一个副本
			 * 否则重新计数
			 */
			if(isset($isTodayFight) && $isTodayFight) {
				$win_monster_count = $userLastCopyResult['win_monster_num'] + 1;
			} else {
				$win_monster_count = 0;
			}

			/*
			 * 每层完成时,领取奖励
			 */
			if ($win_monster_count == $copy['win_monster_num']) {
					
			}

			User_Info::addExperience($userId, $data['result']['experience']);
			$isLevelUp = User_Info::isLevel($userId);
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
}

 /**记录战斗结果入库，战斗记录一个用户永远只保存一条**/
$result = array(
    'user_id'   => $userId,
    'copy_id'    => $copyId,
    'use_time'  => $fightUseTime,
    'last_fight_result' => $data,
	'win_monster_num'   => $win_monster_count,
);
Copy_FightResult::create($result);
