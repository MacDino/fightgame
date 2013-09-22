<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$userId = 27;
$equipId = array('3', '2', '1');

$interFace = 'pack/saleEquip';
$params = array('user_id' => $userId, 'equip_id' => json_encode($equipId));
//print_r($params);
$data = Curl::sendRequest($interFace, $params);