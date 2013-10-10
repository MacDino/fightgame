<?php
//获取用户信息,用于查看其他人的详情
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo $userId;exit;
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$userInfo = User_Info::isExistUser(array($userId));
if(!$userInfo){
	$code = 2;
	$msg = "没有这个用户";
	die;
}

try {
	//基本属性
	$data['base_info'] = User_Info::getUserInfoByUserId($userId);
    //使用中装备
    $equip = Equip_Info::getEquipListByUserId($userId, 1);
    foreach ($equip as $i=>$key){
    	$equip[$i]['attribute_list'] = json_decode($key['attribute_list'], true);
    	$equip[$i]['attribute_base_list'] = json_decode($key['attribute_base_list'], true);
    }
    $data['equip_info'] = $equip;
	//角色基本属性(点)
	$data['baseAttribute'] = User_Info::getUserInfoFightAttribute($userId);
	//角色成长属性(值)
	$data['valueAttribute'] = User_Info::getUserInfoFightAttribute($userId, TRUE);
	//技能属性
	$data['skill_info'] = Skill_Info::getSkillList($userId, TRUE);
//	print_r($data);
    $code = 0;
    $msg = 'ok';
//    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}

