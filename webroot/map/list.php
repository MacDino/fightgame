<?php
/**
 * @desc 地图列表
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';


try {
    $data   = Map_Config::getMapList();
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '地图列表生成失败';
}
