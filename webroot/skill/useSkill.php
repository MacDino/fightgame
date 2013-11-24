<?php
//弃用
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$skillId    = isset($_REQUEST['skill_id']) ? $_REQUEST['skill_id'] : 0;
$type    = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;
$skillLocation    = isset($_REQUEST['skill_location']) ? $_REQUEST['skill_location'] : 0;

try {
	$data   = Skill_Info::useSkill($userId, $skillId, $type, $skillLocation);
	$code   = 0;
	$msg    = 'OK';
} catch (Exception $e) {
	$code   = 1;
	$msg    = '未查询到该用户技能列表';
}
