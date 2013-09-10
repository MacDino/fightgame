<?php
/**
 * @desc 地图列表
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$version = $_REQUEST['v'] ? intval($_REQUEST['v']) : 0;
//获取当前版本号
$currentVersion = Version::getStaticResourceVersion();

try {
    $code   = 0;
    $data['v'] = $currentVersion;
    if($version < $currentVersion) {
        $data['map_list']   = Map_Config::getMapList();
    }
} catch (Exception $e) {
    $code   = 1;
    $msg    = '地图列表生成失败';
}
