<?php
//创建角色
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$masterId     = isset($_REQUEST['master_id'])?$_REQUEST['master_id']:'';//账户ID
$raceId     = isset($_REQUEST['race_id'])?(int)$_REQUEST['race_id']:'';//种族ID
$userName   = isset($_REQUEST['user_name'])?$_REQUEST['user_name']:'';//用户昵称
$area   = isset($_REQUEST['area'])?$_REQUEST['area']:'';//分区

if(!$raceId || !$masterId || !$userName)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

try {
    //创建用户
    $userId = User_Info::createUserInfo(array('race_id' => $raceId, 'user_name' => $userName, 'master_id' => $masterId, 'area' => $area));
    //创建蓝色0级装备一套
    Equip_Create::createEquip(Equip::EQUIP_TYPE_ARMS, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_HELMET, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_NECKLACE, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_CLOTHES, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_BELT, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_SHOES, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    //创建道具仓位
    User_Property::createPropertylist($userId, User_Property::ATTRIBUTE_ENHANCE);
    User_Property::createPropertylist($userId, User_Property::DOUBLE_HARVEST);
    User_Property::createPropertylist($userId, User_Property::AUTO_FIGHT);
//    User_Property::createPropertylist($userId, User_Property::EQUIP_FORGE);
//    User_Property::createPropertylist($userId, User_Property::EQUIP_GROW);
} catch (Exception $e) {
    $code = 1;
    $msg = '创建用户失败!';
    die;    
}
?>

<a href="getUserInfo.php?user_id=<?=$userId?>">进入游戏</a> || <a href="listUser.php?master_id=<?=$masterId?>&area=<?=$area?>">返回列表</a>
