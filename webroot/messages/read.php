<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';
$messageId = isset($_REQUEST['message_id'])?$_REQUEST['message_id']:'';

Message::read($userId, $messageId);
