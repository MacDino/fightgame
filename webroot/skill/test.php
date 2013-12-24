<?php
/**
 * @desc 技能学习
 */
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
$userinfo = MySql::select('user_info');
//print_r($userinfo);
foreach($userinfo as $i=>$key){
    $longitude = 116.417301+($i/10);
    $latitude = 39.941401;
    $sql = "REPLACE INTO user_lbs (user_id, longitude, latitude) VALUES('$key[user_id]', '$longitude', '$latitude')";
    MySql::query($sql);
}