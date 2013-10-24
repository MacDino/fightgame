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
			$res = User_Property::useDoubleHarvest($userId, $propsId);
			break;
		//PK咒符
		case User_Property::PK:
			$res = User_Property::usePkNum($userId, $propsId);
			break;
		//属性增强
		case User_Property::ATTRIBUTE_ENHANCE:
			$res = User_Property::useAttributeEnhance($userId, $propsId);
			break;
		//人宠
		case User_Property::PET:
			$res = User_Property::usePetNum($userId, $propsId);
			break;
		//背包
		case User_Property::PACKAGE:
			$res = User_Property::usePackNum($userId, $propsId);
			break;
		//自动挂机
		case User_Property::AUTO_FIGHT:
			$res = User_Property::useAutoFight($userId, $propsId);
			break;
		//好友上限
		case User_Property::FRIEND:
			$res = User_Property::useFriendNum($userId, $propsId);
			break;
		//装备锻造
		case User_Property::EQUIP_FORGE:
			$res = User_Property::useEquipForge($userId, $propsId);
			break;
		//装备成长
		case User_Property::EQUIP_GROW:
			$equipId = isset($_REQUEST['equip_id'])?(int)$_REQUEST['equip_id']:'';
			$res = User_Property::useEquipGrow($userId, $equipId);
			break;
		default:
			echo '没有此装备';
			break;
	}
	$userPropsNum = User_Property::getPropertyNum($userId, $propsId);
	$data = array(
		'user_id' => $userId,
		'result'  => $res,
		'props_num' => $userPropsNum,	
	);
} catch (Exception $e){
	$code = $e->getCode();
	$msg = $e->getMessage();
}
