<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
$propsId	    = isset($_REQUEST['props_id'])?(int)$_REQUEST['props_id']:'';//道具ID
if(!$userId || !$props_id)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}
try{
	switch ($propsId){
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
		case User_Property::EQUIP_GROW:
			$equipId = isset($_REQUEST['equip_id'])?(int)$_REQUEST['equip_id']:'';
			$data = User_Property::useEquipGrow($userId, $equipId);
			break;
	}
} catch (Exception $e){
	$code = $e->getCode();
	$msg = $e->getMessage();
}
