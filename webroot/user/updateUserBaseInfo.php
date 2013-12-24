<?php
//更新用户基本信息,其实真正的业务应该用不上这个方法
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';


$user_id     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

//轻易不更改
$user_name   	= isset($_REQUEST['user_name'])?$_REQUEST['user_name']:'';//用户名
$race_id  		= isset($_REQUEST['race_id'])?$_REQUEST['race_id']:'';//种族


//更改频率高,需优化
$experience     = isset($_REQUEST['experience'])?$_REQUEST['experience']:'';//经验
$money   		= isset($_REQUEST['money'])?$_REQUEST['money']:'';//金钱
$ingot   		= isset($_REQUEST['ingot'])?$_REQUEST['ingot']:'';//元宝
$pack_num   	= isset($_REQUEST['pack_num'])?$_REQUEST['pack_num']:'';//背包
$skil_point   	= isset($_REQUEST['skil_point'])?$_REQUEST['skil_point']:'';//技能点
$user_level   	= isset($_REQUEST['user_level'])?$_REQUEST['user_level']:'';//经验