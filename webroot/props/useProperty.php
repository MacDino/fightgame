<?php
/*
 * 宝箱类不能使用此接口
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
$propsId	    = isset($_REQUEST['props_id'])?(int)$_REQUEST['props_id']:'';//道具ID
if(!$userId || !$propsId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}
try{
	switch ($propsId){
		//双倍咒符
		case User_Property::DOUBLE_HARVEST:
			$data = User_Property::useDoubleHarvest($userId);
			break;
		//PK咒符
		case User_Property::PK:
			$data = User_Property::usePkNum($userId);
			break;
		//属性增强
		case User_Property::ATTRIBUTE_ENHANCE:
			$data = User_Property::useAttributeEnhance($userId);
			break;
		//人宠
		case User_Property::PET:
			$data = User_Property::usePetNum($userId);
			break;
		//背包
		case User_Property::PACKAGE:
			$data = User_Property::usePackNum($userId);
			break;
		//自动挂机
		case User_Property::AUTO_FIGHT:
			$data = User_Property::useAutoFight($userId);
			break;
		//好友上限
		case User_Property::FRIEND:
			$data = User_Property::useFriendNum($userId);
			break;
		//装备锻造
		case User_Property::EQUIP_FORGE:
			$data = User_Property::useEquipForge($userId);
			break;
		//装备成长
		case User_Property::EQUIP_GROW:
			$equipId = isset($_REQUEST['equip_id'])?(int)$_REQUEST['equip_id']:'';
			$data = User_Property::useEquipGrow($userId, $equipId);
			break;
		default:
			echo '没有此装备';
			break;
	}
} catch (Exception $e){
	$code = $e->getCode();
	$msg = $e->getMessage();
}
