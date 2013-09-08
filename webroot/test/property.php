<?php
//读取用户所有道具,对应"道具-主页"
//返回的格式应该是 array('道具ID' => '道具数量');
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

//所有拥有道具
$userInfo = User_Info::getUserInfoByUserId($userId);
$propertyInfo = User_Property::getUserProperty($userId);
//var_dump($propertyInfo);

?>

<table align="center">
<tr><th>现有元宝:<?=$userInfo['ingot']?></th></tr>
<? foreach ($propertyInfo as $i){?>
<tr>
	<th>道具名称:<?=$i["property_id"]?></th><th>道具数量:<?=$i["property_num"]?></th>
	<th><a href=../property/useProperty.php?user_id=<?=$userId?>&type=<?=$i["property_id"]?>>使用道具</a></th>
	<th><a href="../property/buyProperty.php?user_id=<?=$userId?>&type=<?=$i["property_id"]?>">购买道具</a></th>

<? }?>
</table>

<a href="map.php">地图</a>
<a href="race.php">角色</a>
<a href="pk.php">PK</a>
<a href="shop.php">商店</a>
<a href="friend.php">好友</a>
<a href="other.php">其他</a>