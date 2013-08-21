<?php
/**
 * @desc 进入地图，随机怪物
 */
include $_SERVER['DOCUMENT_ROOT'].'/../init.inc.php';

$map_id = isset($_REQUEST['map_id']) ? $_REQUEST['map_id'] : 0;

try {
	$data   = Map::getMonster($map_id);
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '怪物生成失败';
}
