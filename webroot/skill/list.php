<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$user_id    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
try {
	$data   = Skill_Info::getSkillList($user_id, 2);
	$code   = 0;
	$msg    = 'OK';
} catch (Exception $e) {
	$code   = 1;
	$msg    = '未查询到该用户技能列表';
}
