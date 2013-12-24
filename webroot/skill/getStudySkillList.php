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
	//最高释放概率
	$high = 0.45;//基础释放概率
	$userInfo = User_Info::getUserInfoFightAttribute($userId, true);//用户属性
	$equipProbability = $userInfo[ConfigDefine::RELEASE_PROBABILITY];//装备释放总概率
	if($equipProbability > 0.45){$equipProbability = 0.45;}
	$high += $equipProbability;




	$userInfo = User_Info::getUserInfoByUserId($userId);
	$data['skill_info']   = NewSkillStudy::getStudySkillList($userId, $skillType);
	foreach ($data['skill_info'] as $k=>$v){
		$data['skill_info'][$k]['probability'] = ceil($v['probability']);
	}
	$data['skill_point'] = $userInfo['skil_point'];
	$data['money'] = $userInfo['money'];
	$data['totalprobability'] = round($high,2);
	$code   = 0;
	$msg    = 'OK';
	die;
} catch (Exception $e) {
	$code = 100099;
    $msg = '程序内部错误';
    die;
}
