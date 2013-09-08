<?php
//获取装备详细信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$equipId   = isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID

$userInfo = json_decode($_COOKIE['user_info'], TRUE);
$userId = $userInfo['user_id'];

if(!$userId || !$equipId)
{
	echo "无法获得当前用户信息";
}else{
	$interFace = 'equipment/getInfoById';
	$params = array('equip_id' => $equipId);
	$data = Curl::sendRequest($interFace, $params);
	$res = json_decode($data, TRUE);
	var_dump($res);
}