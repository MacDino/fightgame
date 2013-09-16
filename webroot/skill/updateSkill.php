<?php
/**
 * @desc 技能学习
 */
include $_SERVER['DOCUMENT_ROOT'].'/../init.inc.php';

$user_id    = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$skill_id   = isset($_REQUEST['skill_id']) ? $_REQUEST['skill_id'] : 0;
$add_level  = isset($_REQUEST['add_level']) ? $_REQUEST['add_level'] : 1;

$skill_level    = Skill_Info::getSkillInfo($user_id, $skill_id);
$user_info  = User_Info::getUserInfoByUserId($user_id); 
//金钱判断
$need_money = Skill_Info::getSkillMoney(($skill_level + $add_level), $skill_level);
if($user_info['money'] < $need_money){
    $msg    = '您金钱不足';
    exit;
}
//新学技能
if(empty($skill_level) || $skill_level < 1){
    $learned_skill_num  = Skill_Info::getLearnedSkillNum($user_id, $skill_id);
    $allowed_skill_num  = Skill_Info::getAllowedSkillNum($user_info['user_level']);
    if($learned_skill_num >= $allowed_skill_num){
        $code   = 1;
        $msg    = '您已达到技能学习最大数';
        exit;
    }
}
//技能点数判断
if($user_info['skill_point'] < 1){
    $msg    = '您技能点数不足';
    exit;
}
try {
	$data   = Skill_Info::updateSkill($user_id, $skill_id, $add_level);
    if($data){
        //扣除金钱
        User_Info::updateUserInfo($user_id, array('money' => ($user_info['money'] - $need_money)));
        //减技能点数
    }
	$code   = 0;
	$msg    = 'OK';
} catch (Exception $e) {
	$code   = 1;
	$msg    = '技能学习失败';
}
