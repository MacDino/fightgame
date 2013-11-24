<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    		= isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] :"";
$skillType		= isset($_REQUEST['skill_type']) ? $_REQUEST['skill_type'] :"";
if(!$userId)
{
	$code = 100001;
    $msg = '缺少必传参数';
    die;
}

try {
	$userInfo = User_Info::getUserInfoByUserId($userId);
	$data['skill_info']   = NewSkillStudy::getStudySkillList($userId, $skillType);
	$data['skill_point'] = $userInfo['skil_point'];
	$data['money'] = $userInfo['money'];
	$code   = 0;
	$msg    = 'OK';
	die;
} catch (Exception $e) {
	$code = 100099;
    $msg = '程序内部错误';
    die;
}
