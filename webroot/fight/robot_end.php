<?php
/**
 * 挂机战斗
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : 0;

if($userId <= 0) {
    $code = 100030;
    $msg  = '缺少参数';
    exit;
}

$info = RobotFight::getInfoByUserId($userId);
//有记录且记录为挂机中且地图id相同
if(is_array($info) && count($info) && $info['status'] != 1) {
    $time       = intval((time() - $info['start_time'])/60); //分钟
    $time       = $time > 0 ? ($time < 720 ? $time : 720): 0;//是否大于0？是否小于720分？范围为1-720分
    $userInfo   = User_Info::getUserInfoByUserId($userId);
    $mapId      = $info['map_id'];
    //限制用户等级与地图的相关差距
    $userShouldInMapIds = Map_Config::getUserShouldMapIds($userInfo['user_level']);
    if(in_array($mapId, $userShouldInMapIds)) {
        $dropThingsRate = 1;
    } else {
        $userShouldInMapId = $userShouldInMapIds[0];
        $mapIdRangeNum     = abs(intval($userShouldInMapId - $mapId));
        $dropThingsRate    = $mapIdRangeNum > 0 ?  (1 - ($mapIdRangeNum * 0.4)) : 1;
        $dropThingsRate    = $dropThingsRate * 100 > 0 && $dropThingsRate * 100 < 100 ? $dropThingsRate : 0;
    }
    if($time) {
        $data = RobotFight::getResult($info, $time, $dropThingsRate);
    }  else {
        $data = array(
            'money' => 0,
            'experience' => 0,
            'equipment' => array(),
        );
    }
    $code = 0;
    RobotFight::updateStatus($userId);
} else {
    $code = 130002;
    $msg = '没有挂机战斗';
}

