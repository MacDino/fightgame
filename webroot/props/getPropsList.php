<?php
/*
 * 根据分类获取下属的道具列表
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
try {
	$data = Props_Info::getPropsList();
} catch (Exception $e) {
	$code   = 1;
}
