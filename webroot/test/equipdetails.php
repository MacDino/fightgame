<?php
//获取装备详细信息
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$equipId   = isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID

$userInfo = json_decode($_COOKIE['user_info'], TRUE);
$userId = $userInfo['user_id'];

if(!$userId || !$equipId)
{
	echo "无法获得当前用户信息";
}else{
	$interFace = 'equipment/getInfoById';
	$params = array('equip_id' => $equipId);
	$data = Curl::sendRequest($interFace, $params);
	$res = json_decode($data, TRUE);
//	var_dump($res);
	$result = $res['d'];
}
?>
<table>
<?php foreach ($result as $i=>$key){?>
<tr><td><?=$i?></td><td><?=$key?></td></tr>
<?php } ?>
</table>

<p>
<a href="pack.php">返回包裹</a>
</p>
<p>
<a href="map.php">地图</a>
<a href="race.php">角色</a>
<a href="pk.php">PK</a>
<a href="shop.php">商店</a>
<a href="friend.php">好友</a>
<a href="other.php">其他</a>
</p>