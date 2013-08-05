<?php
//创建角色
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$raceId     = isset($_REQUEST['race_id'])?(int)$_REQUEST['race_id']:'';//种族ID
$bindType   = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:'';//绑定用户类别
$bindValue  = isset($_REQUEST['user_value'])?$_REQUEST['user_value']:'';//绑定用户值
$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户user_id
$userName   = isset($_REQUEST['user_name'])?$_REQUEST['user_name']:'';//用户昵称

if(!$raceId || !$bindType || !$bindValue || !$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

$trueUserId = User_Bind::getBindUserId($bindType ,$bindValue);
if($userId != $trueUserId)
{
    $code = 1;
    $msg = '用户不一至!';
    die;
}

$userInfo = User_info::getUserInfoByUserId($userId);
if($userInfo)
{
    $code = 1;
    $msg = '用户已存在!';
    $data = $userInfo;
    die;
}

try {
    //创建用户
    User_Info::createUserInfo($userId, array('race_id' => $raceId, 'user_name' => $userName));
    //创建蓝色0级装备一套
    Equip_Create::createEquip(Equip::EQUIP_TYPE_ARMS, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_HELMET, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_NECKLACE, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_CLOTHES, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_BELT, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
    Equip_Create::createEquip(Equip::EQUIP_TYPE_SHOES, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, $userId);
} catch (Exception $e) {
    $code = 1;
    $msg = '创建用户失败!';
    die;    
}
