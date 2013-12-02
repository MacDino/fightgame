<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : 0;

if($userId <= 0) {
    $code = 1;
    $msg  = '缺少参数';
    exit;
}

$info = RobotFight::getInfoByUserId($userId);

$data['user_id']  = $userId;
$data['is_robot'] = 0;
if(is_array($info) && count($info)) {
    if($info['status'] == 0) {
        $data['map_id'] = $info['map_id'];
        $data['is_robot'] = 1;
    }
}