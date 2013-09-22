<?php
/*
 * 记录地图战斗设置
 * 日志显示  战况log、战果result、金币gold、经验exp、道具prop、
 * 道具拾取  灰色gray、白色white、绿色green、蓝色blue、紫色purple、橙色orange
 * 0表示关闭 1表示开启
 * 关闭/开启哪个值传哪个值过来
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

try {
    Fight_Setting::create($_REQUEST);
    $code = 0;
    $data = Fight_Setting::getSettingByUserId($_REQUEST['user_id']);
} catch (Exception $exc) {
    $code = 1;
    $msg = $exc->getMessage();
}