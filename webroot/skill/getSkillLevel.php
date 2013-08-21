<?php
include $_SERVER['DOCUMENT_ROOT'].'/../init.inc.php';

$user_id    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$level_id   = isset($_REQUEST['level_id']) ? $_REQUEST['level_id'] : 0;

try {
	$data   = Skill_Info::getSkillInfo($user_id);
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '技能查询失败';
}
