<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] :"";
$type		= isset($_REQUEST['type']) ? $_REQUEST['type'] :"";

try {
	$data   = Skill_Info::getStudySkillList($userId, $type);
//	print_r($data);
	$code   = 0;
	$msg    = 'OK';
} catch (Exception $e) {
	$code   = 1;
	$msg    = '未查询到该用户技能列表';
}
