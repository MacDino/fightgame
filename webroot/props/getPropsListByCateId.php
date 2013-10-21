<?php
/*
 * 根据分类获取下属的道具列表
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$cateId = $_REQUEST['cate_id'] ? $_REQUEST['cate_id'] : 0;
$userId = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;
try {
	$res = Props_Info::getPropsListByCateId($cateId);
	empty($res) && $res = array();
	foreach ($res as $k => $v) {
		$userPropsNum = User_Property::getPropertyNum($userId, $v['props_id']);
		$res[$k]['props_num'] = $userPropsNum > 0 ? $userPropsNum : 0;	
	}	
	$data = $res;
} catch (Exception $e) {
	$code   = 1;
}
