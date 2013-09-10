<?php
/**
 * 静态资源
 * 会根据版本号进行数据的输出
 * **/
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$version = $_REQUEST['v'] ? intval($_REQUEST['v']) : 0;
//获取当前版本号
$currentVersion = Version::getStaticResourceVersion();

$code = 0;
$data['v'] = $currentVersion;
if($version < $currentVersion) {
    //地图列表
    $data['map_list'] = Map_Config::getMapList();
    //跟地图相关的怪物列表
    $data['monster_list'] = Monster_Config::getList();
    
}
