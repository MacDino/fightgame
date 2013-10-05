<?php
/**
 * @desc 技能学习
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$skillId   = isset($_REQUEST['skill_id']) ? $_REQUEST['skill_id'] : 0;

$skillLevel    = Skill_Info::getSkillInfo($userId, $skillId);
$userInfo  = User_Info::getUserInfoByUserId($userId); 
//金钱判断
$needMoney = Skill_Info::getSkillMoney($skillLevel);
if($userInfo['money'] < $needMoney){
	$code = 2;
    $msg    = '您金钱不足';
    die;
}
/*//新学技能
if(empty($skillLevel) || $skillLevel < 1){
    $learned_skill_num  = Skill_Info::getLearnedSkillNum($userId, $skillId);
    $allowed_skill_num  = Skill_Info::getAllowedSkillNum($userInfo['user_level']);
    if($learned_skill_num >= $allowed_skill_num){
        $code   = 1;
        $msg    = '您已达到技能学习最大数';
        die;
    }
}*/
if($skillLevel+1 > $userInfo['user_level']+30){
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
	$data   = Skill_Info::updateSkill($userId, $skillId);
    if($data){
        //扣除金钱
        User_Info::subtractMoney($userId, $needMoney);
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
