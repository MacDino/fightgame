<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
$type    = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
//echo "userid======$userId&&type====$type";

try {
	$skillInfo   = Skill_Info::getUserUsedSkill($userId, $type);//已使用技能信息
	$count = count($skillInfo);//技能总数
	
	if($type == 1){
		switch ($count){
			case 1:
				$skillProbability = 0.25;
				break;
			case 2:
				$skillProbability = 0.3;
				break;
			case 3:
				$skillProbability = 0.35;
				break;
			case 4:
				$skillProbability = 0.4;
				break;
			case 5:
				$skillProbability = 0.45;
				break;
		}
	}
	
	if($type == 2){
		switch ($count){
			case 1:
				$skillProbability = 0.2;
				break;
			case 2:
				$skillProbability = 0.25;
				break;
			case 3:
				$skillProbability = 0.3;
				break;
			case 4:
				$skillProbability = 0.35;
				break;
			case 5:
				$skillProbability = 0.4;
				break;
		}
	}
	
//	print_r($skillInfo);
	$userInfo = User_Info::getUserInfoFightAttribute($userId, true);//用户属性
//	print_r($userInfo);
	$equipProbability = $userInfo[ConfigDefine::RELEASE_PROBABILITY];//装备释放总概率
//	echo $equipProbability;
	//装备带来的最高释放概率
	if($equipProbability >= 0.45 && $type == 1){
		$equipProbability = 0.45;
	}
	if($equipProbability >= 0.4 && $type == 2){
		$equipProbability = 0.4;
	}
	
	$totalProbability  = $equipProbability + $skillProbability;//最高技能释放概率=装备+技能数
//	echo $totalProbability;
	$skillProbability = Skill_Info::releaseProbability($totalProbability, $skillInfo);//技能释放概率分解
//	print_r($skill);
	foreach ($skillInfo as $i=>$key){
		$skillInfo[$i]['probability'] = intval($skillProbability[$key['skill_id']]);//根据skill_id合成
	}
	$data = $skillInfo;
	$code   = 0;
	$msg    = 'OK';
} catch (Exception $e) {
	$code   = 1;
	$msg    = '未查询到该用户技能列表';
}
