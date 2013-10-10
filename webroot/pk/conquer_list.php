<?php
/**
 * 征服模式
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : 0;
if($userId > 0) {
    $conquerRes = User_Info::nearUser($userId);
    foreach ($conquerRes as $user) {
        $data['list'][] = array(
            'user_id' => $user['user_id'],
            'user_name' => $user['user_name'],
            'user_level' => $user['user_level'],
            'power' => 10,
            'range' => 10
        );
    }
}