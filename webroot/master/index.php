<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userName 			= isset($_REQUEST['user_name'])?$_REQUEST['user_name']:'';//用户名

$where = array();
if(!empty($userName)){$where['user_name'] = $userName;}
$result = User_Info::searchUser($where);

//print_r($result);
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<form action="" method="POST"?>
<table>
	<tr><td>
		<input id="user_name" name="user_name"><input value="按角色名称搜索" type="submit">
	</td></tr>
</table>
</form>
<table>
<? if(!empty($result)){
	foreach ($result as $i){
?>
	<tr>
		<td>名字:<?=$i['user_name']?></td><td>种族:<?
		if($i['race_id'] == 2)echo "仙族";
		if($i['race_id'] == 1)echo "人族";
		if($i['race_id'] == 3)echo "魔族";
		?></td><td>性别:<?php
		if($i['sex'] == 1){echo "女";}else{echo "男";}
		?></td><td>等级:<?=$i['user_level']?></td>
		<td>经验:<?=$i['experience']?></td><td>金钱:<?=$i['money']?></td><td>元宝:<?=$i['ingot']?></td><td><a href="login.php?user_id=<?=$i['user_id']?>">进入</a></td>
	</tr>
<? }}?>
</table>