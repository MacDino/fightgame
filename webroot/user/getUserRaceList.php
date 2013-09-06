<?php
//获取用户绑定角色信息

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$areaId = isset($_REQUEST['area_id'])?$_REQUEST['area_id']:'';
$loginUserId = isset($_REQUEST['login_user_id'])?$_REQUEST['login_user_id']:'';

if(!$areaId || !$loginUserId)
{
    $code = 1;
    die;
}

$raceList = User_Race::getRaceList();

$userRaceList =  User_Info::listUser($loginUserId, $areaId); 


$data['race_list'] = $raceList;
$data['user_race_list'] = $userRaceList;
