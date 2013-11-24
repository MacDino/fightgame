<?php
/**
 * @desc 技能学习
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
$skillId   = isset($_REQUEST['skill_id']) ? $_REQUEST['skill_id'] : "";
$skillType   = isset($_REQUEST['skill_type']) ? $_REQUEST['skill_type'] : "";


$userInfo  = User_Info::getUserInfoByUserId($userId); 
$money = User_Info::getUserMoney($userId);
//金钱判断
$needMoney = Skill_Info::getSkillMoney($skillLevel);
if($needMoney > $money){
	$code = 2;
    $msg    = '您金钱不足';
    die;
}

if($skillLevel+1 > $userInfo['user_level']+10){
	$code = 3;
	$msg = "不能高过人物等级10级";
	die;
}

//技能点数判断

if($userInfo['skil_point'] < 1){
	$code = 4;
    $msg    = '您技能点数不足';
    die;
}
try {
	$data   = $skillLevel    = NewSkillStudy::updateSkill($userId, $skillId, $skillType);
    if($data){
        //扣除金钱
        User_Info::subtractBindMoney($userId, $needMoney);
        //减技能点数
        User_Info::subtractPointNum($userId, 1);
    }
	$code   = 0;
	$msg    = 'OK';
	die;
} catch (Exception $e) {
	$code   = 99;
	$msg    = '内部错误';
	die;
}
