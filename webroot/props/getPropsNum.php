<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$userId = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;
$propsId = $_REQUEST['props_id'] ? $_REQUEST['props_id'] : 0;
if(!$userId) {
	$code = '120004';
	exit;
}
if(!$propsId){
	$code = '120090';
	exit;
}

$num = User_Property::getPropertyNum($userId, $propsId);
$data = $num > 0 ? $num : 0;
