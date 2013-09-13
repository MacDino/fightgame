<?php
//读取用户所有装备,对应前台 "角色-背包"
//返回的格式应该是 array(装备名, 等级, 是否装备, json格式的基本属性, json格式的附加属性, json格式的强化属性);
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$act   = isset($_REQUEST['act'])?$_REQUEST['act']:'';
//echo $act;
$userInfo = json_decode($_COOKIE['user_info'], TRUE);
$userId = $userInfo['user_id'];

if(!$userId)
{
    echo "无法获得当前用户信息";
}else{

$interFace = 'user/getUserPackInfo';
$params = array('user_id' => $userId);
$data = Curl::sendRequest($interFace, $params);

$res = json_decode($data, TRUE);
//print_r($res);
$result = $res['d'];
?>


<table align="center">
<?php foreach ($result as $i){?>
<tr>
	<th>装备ID:<?=$i["user_equip_id"]?></th><th>装备颜色:<?=$i["equip_colour"]?></th><th>装备名称:<?=$i["equip_type"]?></th>
</tr>
<tr>
	<th>是否使用:<?=$i["is_used"]?></th><th>装备种族:<?=$i["race_id"]?></th><th>装备级别:<?=$i["equip_level"]?></th>
</tr>
<tr>
	<th><a href="">打造装备</a></th><th><a href="equipdetails.php?equip_id=<?=$i["user_equip_id"]?>">查看装备详情</a></th><th><a href="">卖出装备</a></th><th><a href="">使用装备</a></th>
</tr>
<?php }?>
</table>


<a href="map.php">地图</a>
<a href="race.php">角色</a>
<a href="pk.php">PK</a>
<a href="shop.php">商店</a>
<a href="friend.php">好友</a>
<a href="other.php">其他</a>

<?php }?>