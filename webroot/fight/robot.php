<?php
/**
 * 挂机战斗
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : 0;
$mapId  = $_REQUEST['map_id'] > 0 ? $_REQUEST['map_id'] : 0;

if($userId <= 0 || $mapId <= 0) {
    $code = 1;
    $msg  = '缺少参数';
    exit;
}

$info = RobotFight::getInfoByUserId($userId);
if(is_array($info) && count($info) && $info['status'] == 1 || !$info) {
    $attrbuteArr    = User_Info::getUserInfoFightAttribute($userId, TRUE);
    $params = array(
        'user_id'   => $userId,
        'map_id'    => $mapId,
        'lucky'     => intval($attrbuteArr[ConfigDefine::USER_ATTRIBUTE_LUCKY]),
    );
    RobotFight::create($params);
}
