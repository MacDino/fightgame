<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
$props_id	     	= isset($_REQUEST['props_id'])?(int)$_REQUEST['props_id']:'';//道具ID
if(!$userId || !$props_id)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}
try{
	switch ($props_id){
		case User_Property::ATTRIBUTE_ENHANCE:
			$data = User_Property::useAttributeEnhance($userId);
			break;
		case User_Property::AUTO_FIGHT:
			$data = User_Property::useAutoFight($userId);
			break;
		case User_Property::DOUBLE_HARVEST:
			$data = User_Property::useDoubleHarvest($userId);
			break;
		case User_Property::EQUIP_FORGE:
			$data = User_Property::useEquipForge($userId);
			break;


	}
} catch (Exception $e){
	$code = $e->getCode();
	$msg = $e->getMessage();
}
