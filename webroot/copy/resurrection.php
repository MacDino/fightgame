<?php
/*
 * 复活
 */
$resurrectionType = $_REQUEST['type'] ? $_REQUEST['type'] : '';
$user_id = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;
$copyLevelId = $_REQUEST['level_id'] ? $_REQUEST['level_id'] :0;
$copy = Copy_Config::getCopyLevelInfoByLevelId($copyLevId);

$userInfo = User_Info::getUserInfoByUserId($userId);
$money = $userInfo['money'];
$ingot = $userInfo['ingot'];
//金币复活
if ($resurrectionType == 1) {
	if ($money < Copy_Config::RESSURRECTION_MONEY) {
		$code = "180001";		
		exit;
	}
	$decrementMoney = User_Info::subtractMoney($user_id, Copy_Config::RESSURRECTION_MONEY);	
	if ($decrementMoney) {
		$sets = array (
			'copy_id' => $copy['copy_id'],
			'copy_level_id' => $copy['copy_level_id'],
			'user_id' => $user_id,
			'pay_type' => $resurrectionType,
			'pay_value' => Copy_Config::RESSURRECTION_MONEY,
			'resurrect_time' => time(),
		);		
		$data = MySql::insert('copies_resurrection_log', $sets);
	}


//元宝复活
} else if($resurrectionType == 2){
	if ($ingot < Copy_Config::RESSURRECTION_INGOT) {
		$code = "180002";		
		exit;
	}
	$decrementIngot = User_Info::subtractIngot($user_id, Copy_Config::RESSURRECTION_INGOT);
	if ($decrementIngot) {
		$sets = array (
			'copy_id' => $copy['copy_id'],
			'copy_level_id' => $copy['copy_level_id'],
			'user_id' => $user_id,
			'pay_type' => $resurrectionType,
			'pay_value' => Copy_Config::RESSURRECTION_INGOT,
			'resurrect_time' => time(),
		);		
		$data = MySql::insert('copies_resurrection_log', $sets);
	}
}
