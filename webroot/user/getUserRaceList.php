<?php
//获取用户绑定角色信息

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$areaId = isset($_REQUEST['area_id'])?$_REQUEST['area_id']:'';
$masterId = isset($_REQUEST['matser_id'])?$_REQUEST['matser_id']:'';

if(!$areaId || !$masterId)
{
    $code = 1;
    die;
}

$raceList = User_Race::getRaceList();

$userRaceList =  User_Info::listUser($masterId, $areaId); 


$data['race_list'] = $raceList;
$data['user_race_list'] = $userRaceList;
