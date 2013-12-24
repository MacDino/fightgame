<?php
//获取
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
$skillType    = isset($_REQUEST['skill_type']) ? $_REQUEST['skill_type'] : "";

try {
	//$skillInfo = NewSkillStudy::ReleaseProbability($userId);
	//print_r($a);
	if($skillType == 1){
		$skillInfo = NewSkillStudy::getReleaseProbability($userId);
	}else{
		$skillInfo = NewSkillStudy::getSkillList($userId, 0);//被动技能
	}
	
	$data = $skillInfo;
	$code   = 0;
	$msg    = 'OK';
} catch (Exception $e) {
	$code   = 1;
	$msg    = '未查询到该用户技能列表';
}
