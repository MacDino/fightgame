<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$cateId = $_REQUEST['cate_id'] ? $_REQUEST['cate_id'] : 1;
try {
	$data = Props_Info::getPropsListByCateId($cateId);
} catch (Exception $e) {
	$code   = 1;
}
