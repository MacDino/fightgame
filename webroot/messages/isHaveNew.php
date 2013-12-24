<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';


$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';
$msgId = isset($_REQUEST['msg_id'])?$_REQUEST['msg_id']:'';

$data = Message::isHaveNew($userId, $msgId) > 0 ? TRUE:FALSE;
