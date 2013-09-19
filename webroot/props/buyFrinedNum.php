<?php
//购买好友上限
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

try {
    $data =  User_Property::buyFriendNum($userId);
} catch (Exception $e) {
    $code = $e->getCode();
    $msg = $e->getMessage();
}
