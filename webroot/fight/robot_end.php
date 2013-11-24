<?php
/**
 * 挂机战斗
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : 0;
$mapId  = $_REQUEST['map_id'] > 0 ? $_REQUEST['map_id'] : 0;
echo '<pre>';
if($userId <= 0 || $mapId <= 0) {
    $code = 1;
    $msg  = '缺少参数';
    exit;
}

$info = RobotFight::getInfoByUserId($userId);
//有记录且记录为挂机中且地图id相同
if(is_array($info) && count($info) && $info['status'] == 0 && $info['map_id'] == $mapId) {
    $time = intval((time() - $info['start_time'])/60); //分钟
    $time = $time > 0 ? ($time < 720 ? $time : 720): 0;//是否大于0？是否小于720分？范围为1-720分
    if($time) {
        $data = RobotFight::getResult($info, $time);
    }  else {
        $data = array(
            'money' => 0,
            'experience' => 0,
            'equipment' => array(),
        );
    }
    $code = 0;
    RobotFight::updateStatus($userId, $mapId);
} else {
    $code = 1;
    $msg = '没有挂机战斗';
}

