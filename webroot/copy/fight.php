<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$copyLevId  = isset($_REQUEST['level_id']) ? $_REQUEST['level_id'] : 0;
$copyId     = isset($_REQUEST['copy_id']) ? $_REQUEST['copy_id'] : 0;

$copyLev = Copy_Config::getCopyLevelInfoByLevelId($copyLevId);
if (!$copyLev) {
	$code = 170001; $msg = "无此副本";exit;
}
$copy = Copy::getCopyInfoByCopyId($copyId); 
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
$userLastCopyResult     = Copy_FightResult::getResult($userId, $copyLevId);
if(is_array($userLastCopyResult) && count($userLastCopyResult)) {
	$jsonResult = json_decode($userLastCopyResult['last_fight_result'], TRUE);
	$lastIsWin = $jsonResult['result']['win'];
	$lastFightDate = date("Y-m-d",strtotime($userLastCopyResult['create_time']));
	$isTodayFight = $lastFightDate == date("Y-m-d", time());
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

//装备保留的颜色组
/*
if(isset($_REQUEST['colors'])) {
    Fight_Setting::create($copyId, $_REQUEST['colors']);
}
 */
try {
    $monster            = Copy::getMonster($copyLevId , $userId);
    $monster['mark'] = 'monster[0]';
    $teams['monster'][] = Copy_Fight::createMonsterFightable($monster);
    $data['participant']['monster'][]    = NewFight::getMonsterFightInfo($teams['monster'][0], $monster);


    //当前角色fight对象，如果有人宠，获取人宠
    $userInfo['mark']   = 'user';
    $teams['user'][]    = NewFight::createUserObj($userInfo);
    $data['participant']['user'] = NewFight::getPeopleFightInfo($teams['user'][0], $userInfo);


    if($userInfo['user_level'] > 10) {
        $friendIdRes    = Friend_Info::isUseFriend($userId);
        $petInfo        = User_Info::getUserInfoByUserId((int)$friendIdRes[0]['friend_id']);
        //$petInfo    = Pet::usedPet($userId);
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
    } else {
        $data['result']['win']  = 1;
        $data['result']['experience']         = Monster::getMonsterExperience($monster);
        $data['result']['money']              = Monster::getMonsterMoney($monster);
        $data['result']['equipment']          = Monster::getMonsterEquipment($monster);
        $msg                        = '怪物已消灭';
		/*
		 * 打赢时，怪物计数
		 * 每天打过100个怪，则通关,启动下一个副本
		 * 否则重新计数
		 */
		if(isset($isTodayFight) && $isTodayFight) {
			$win_monster_count = $userLastCopyResult['win_monster_num'] + 1;
		} else {
			$win_monster_count = 1;
		}

		/*
		 * 每层完成时,领取奖励
		 */
		if ($win_monster_count%$copy['monster_num'] == 0) {
			//记录通关次数
			$passedTime = $userLastCopyResult['passed_time'] + 1;
			$data['result']['reward'] =  getReward($userId, $userInfo['user_level'], $copyId, $copyLevId);
			$data['result']['reward_count'] = Copy_RewardLog::getCountGroupByType($userId, $copyId, $copyLevId);
		}

        User_Info::addExperience($userId, $data['result']['experience']);

        $data['result']['experience_sum']   =  $userInfo['experience'];

        $isLevelUp = User_Info::isLevel($userId);
        if($isLevelUp) {
            $data['result']['level_up'] = $isLevelUp;
        }
        $data['result']['win_monster_num'] = $win_monster_count;

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
    'copies_level_id'    => $copyLevId,
    'use_time'  => $fightUseTime,
    'last_fight_result' => $data,
	'win_monster_num'   => $win_monster_count,
	'passed_time'	=> $passedTime,
);
Copy_FightResult::create($result);










function getReward($userId, $level, $copyId, $levelId = 0){
	$reward = array(
		'double','pk','ingot','money','pill','equip'
	);	
	$k = array_rand($reward);
	$result = $reward[$k];

	$num = 1;
	switch ($result) {
		case 'double':
			$prop_id = 1;	
			$res = Rewardtype::props($userId, 1, $prop_id);
			break;
		case 'pk':
			$prop_id = 2;	
			$res = Rewardtype::props($userId, 1, $prop_id);
			break;
		case 'ingot':
			$num = 10;
			$res = Rewardtype::ingot($userId, $num);
			break;
		case 'money':
			$num = 5000;
			$res = Rewardtype::money($userId, $num);
			break;
		case 'pill':
			$res = Rewardtype::pillStone($userId);
			break;
		case 'equip':
			$equipId = Equip_Create::createEquip(Equip::EQUIP_COLOUR_BLUE, $userId, $level);
			$res = Equip_Info::getEquipInfoById($equipId);
			break;
	}
	$logData = array(
		'copy_id' => $copyId,
		'level_id'=> $levelId,
		'type'	  => $result,
		'num'	  => $num,
		'ctime'	  => time(),
		'equip_id'=> $equipId,		
		'user_id' => $userId,
	);
	Copy_RewardLog::insert($logData);
	return $res;
}
