<?php
/*
 * 内购产品列表接口
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
try {
	$data = Props_Info::getCateList();
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '道具分类列表获取失败';
}
