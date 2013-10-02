<?php
//创建角色
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$masterId     = isset($_REQUEST['master_id'])?$_REQUEST['master_id']:'';//账户ID
$raceId     = isset($_REQUEST['race_id'])?(int)$_REQUEST['race_id']:'';//种族ID
$userName   = isset($_REQUEST['user_name'])?$_REQUEST['user_name']:'';//用户昵称
$areaId   = isset($_REQUEST['area_id'])?$_REQUEST['area_id']:'';//分区
$sex   = isset($_REQUEST['sex'])?$_REQUEST['sex']:'';//性别

if(!$userName || !$masterId || !$areaId)
{
    $code = 9;
    die;
}

try {

    //创建用户
    $userId = User_Info::createUserInfo(array(
    	'race_id' => $raceId, 
    	'user_name' => $userName, 
    	'login_user_id' => $masterId, 
    	'area_id' => $areaId, 
    	'sex' => $sex,
    	));

    if($userId)
    {
        //创建蓝色0级装备一套
        Equip_Create::createEquip(Equip::EQUIP_COLOUR_BLUE, $userId, 0, Equip::EQUIP_TYPE_ARMS, Equip::EQUIP_QUALITY_GENERAL);
        Equip_Create::createEquip(Equip::EQUIP_COLOUR_BLUE, $userId, 0, Equip::EQUIP_TYPE_HELMET, Equip::EQUIP_QUALITY_GENERAL);
        Equip_Create::createEquip(Equip::EQUIP_COLOUR_BLUE, $userId, 0, Equip::EQUIP_TYPE_NECKLACE, Equip::EQUIP_QUALITY_GENERAL);
        Equip_Create::createEquip(Equip::EQUIP_COLOUR_BLUE, $userId, 0, Equip::EQUIP_TYPE_CLOTHES, Equip::EQUIP_QUALITY_GENERAL);
        Equip_Create::createEquip(Equip::EQUIP_COLOUR_BLUE, $userId, 0, Equip::EQUIP_TYPE_BELT, Equip::EQUIP_QUALITY_GENERAL);
        Equip_Create::createEquip(Equip::EQUIP_COLOUR_BLUE, $userId, 0, Equip::EQUIP_TYPE_SHOES, Equip::EQUIP_QUALITY_GENERAL);
        //创建道具仓位
        User_Property::createPropertylist($userId, User_Property::ATTRIBUTE_ENHANCE);
        User_Property::createPropertylist($userId, User_Property::DOUBLE_HARVEST);
        User_Property::createPropertylist($userId, User_Property::AUTO_FIGHT);
        User_Property::createPropertylist($userId, User_Property::EQUIP_FORGE);
		//初始化宝箱道具仓位
        User_Property::initTreasureBox($userId);
        //初始化奖励列表
        //初始化...
//		echo "<script>location.href='getUserInfo.php?user_id=$userId';</script>"; 
        //User_Property::createPropertylist($userId, User_Property::EQUIP_GROW);
        $data = $userId;
        $code = 0;
   		$msg = 'ok';
        die;
    }
    
} catch (Exception $e) {
    $code = 1;
}
