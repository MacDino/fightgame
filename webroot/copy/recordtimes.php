<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$user_id = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;
$type = $_REQUEST['type'] ? $_REQUEST['type'] : "";
$data = PK_Conf::setInfo($user_id, $type);
