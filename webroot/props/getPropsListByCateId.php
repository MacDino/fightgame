<?php
/*
 * 根据分类获取下属的道具列表
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$cateId = $_REQUEST['cate_id'] ? $_REQUEST['cate_id'] : 0;
try {
	$data = Props_Info::getPropsListByCateId($cateId);
} catch (Exception $e) {
	$code   = 1;
}
