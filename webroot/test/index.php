<?php 
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//
?>
<table>
	<tr>
		<td>地图</td>
	</tr>
	<tr>
		<td>选择地图</td><td>日志显示</td><td>装备拾取</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td>角色</td>
	</tr>
	<tr>
		<td><a href="../user/getUserPackInfo.php?user_id=<?=$userId?>">背包</a></td>
		<td><a href="../user/getUserInfo.php?user_id=<?=$userId?>">属性</a></td>
		<td><a href="../user/getUserPetInfo.php?user_id=<?=$userId?>">人宠</a></td>
		<td><a href="../user/getUserSkill.php?user_id=<?=$userId?>">技能</a></td>
		<td><a href="../user/getUserReward.php?user_id=<?=$userId?>">奖励</a></td>
		<td>锻造</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td>PK</td>
	</tr>
	<tr>
		<td>擂台</td><td>征服</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td>商店</td>
	</tr>
	<tr>
		<td><a href="../user/getUserPropertyInfo.php?user_id=<?=$userId?>">道具列表</a></td><td>充值</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td><a href="../friend/listFriend.php?user_id=<?=$userId?>">好友</a></td>
	</tr>
</table>