<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] :"";
$type		= isset($_REQUEST['type']) ? $_REQUEST['type'] :"";

try {
	$userInfo = User_Info::getUserInfoByUserId($userId);
	$data['skill_info']   = Skill_Info::getStudySkillList($userId, $type);
	$data['skill_point'] = $userInfo['skil_point'];
	$data['money'] = $userInfo['money'];
//	print_r($data);
	$code   = 0;
	$msg    = 'OK';
} catch (Exception $e) {
	$code   = 1;
	$msg    = '未查询到该用户技能列表';
}
