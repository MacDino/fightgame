<?php
//技能释放概率更改
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] :'';
$skillId    = isset($_REQUEST['skill_id']) ? $_REQUEST['skill_id'] :'';
$oddsSet   = isset($_REQUEST['odds_set']) ? $_REQUEST['odds_set'] :'';

try {
	$data   = NewSkillStudy::setSkillOdds($userId, $skillId, $oddsSet);
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
}
