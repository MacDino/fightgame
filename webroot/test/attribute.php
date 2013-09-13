<?php
//获取用户信息，包括用户基本信息，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$act   = isset($_REQUEST['act'])?$_REQUEST['act']:'';//好友ID
//echo $act;

$userInfo = json_decode($_COOKIE['user_info'], TRUE);
$userId = $userInfo['user_id'];
//echo $userId;exit;
if(!$userId)
{
	echo "无法获得当前用户信息";
}else{
	$interFace = 'user/getUser';
	$params = array('user_id' => $userId);
	$a = Curl::sendRequest($interFace, $params);
//	error_log($a, 3, 'errors.log');
//	var_dump($a);
	$res = json_decode($a, TRUE);
//	var_dump($res);exit;
	$result = $res['d'];
	$equipInfo = $result['equipInfo'];//使用中装备
	$baseAttribute = $result['baseAttribute'];//角色基本属性(点)
	$valueAttribute = $result['valueAttribute'];//角色成长属性(值)
}

?>


<table><tr>

<td><table align="left">
<tr><th>身上装备</th></tr>
<? if(is_array($equipInfo)){
foreach ($equipInfo as $i){?>
<tr>
	<th>装备颜色:<?=$i["equip_colour"]?></th><th>装备等级:<?=$i["equip_level"]?></th>
</tr>
<tr>
	<th>装备种族:<?=$i["race_id"]?></th><th>装备级别:<?=$i["equip_level"]?></th>
</tr>
<tr>
	<th><a href="equipdetails.php?equip_id=<?=$i["user_equip_id"]?>">查看装备详情</a></th>
</tr>
<? }}?>
</table></td>

<td><table align="center">
<tr><th>属性点</th></tr>
<? if(is_array($baseAttribute)){ 
foreach ($baseAttribute as $i=>$key){?>
<tr>
	<th>属性:<?=$i?></th><th>点数:<?=$key?></th>
</tr>
<? }}?>
</table></td>

<td><table align="right">
<tr><th>属性值</th></tr>
<? if(is_array($valueAttribute)){
foreach ($valueAttribute as $i=>$key){?>
<tr>
	<th>属性:<?=$i?></th><th>数值:<?=$key?></th>
</tr>
<? }}?>
</table></td>

</tr></table>

<p>
<a href="map.php">地图</a>
<a href="race.php">角色</a>
<a href="pk.php">PK</a>
<a href="shop.php">商店</a>
<a href="friend.php">好友</a>
<a href="other.php">其他</a>
</p>