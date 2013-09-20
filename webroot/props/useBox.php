<?php
/*
 * 使用宝箱,根据道具id自动区分是普通还是精品
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';
$propsId		= isset($_REQUEST['props_id']) ?(int)$_REQUEST['props_id'] : '';

if(!$userId || !$propsId)
{
    $code = 1;
    $msg = 'user_id and props_id are require';
    die;
}
try {
	foreach(Props_Config::$treasure_box_package[0] as $v){
		$general[] = $v['id'];	
	}
	foreach(Props_Config::$treasure_box_package[1] as $v){
		$choice[] = $v['id'];	
	}
	if ( in_array( $propsId, $general )) {
		$data = User_Property::useGeneralTreasureBox ($userId, $propsId);
	} else if(in_array( $propsId, $choice )){
		$data = User_Property::useChoiceTreasureBox ($userId, $propsId);
	}
} catch (Exception $e) {
	$code = $e->getCode();
	$msg = $e->getMessage();
}
