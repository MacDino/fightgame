<?php
/*
 * 处理挑战模式的强制退出
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : 0;
if($userId < 0) {
    $code = 1;
    $msg  = '用户id必须';
    exit;
}
try {
    //显示战果
    $data['result'] = PK_Challenge::dealResult($userId, TRUE);
    //强制退出不打了。设置连胜为0，删除已战斗过的用户ids
    PK_Challenge::setWinContinueNumZero($userId);
    PK_Challenge::delFightedUserIds($userId);
} catch (Exception $exc) {
    $code   = $exc->getCode();
    $msg    = $exc->getMessage();
}

