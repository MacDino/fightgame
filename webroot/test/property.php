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

$auxiliary = Props_Info::getPropsListByCateId(1);
$box 	   = Props_Info::getPropsListByCateId(3);
$forge	   = Props_Info::getPropsListByCateId(2);
?>

<p>现有元宝:<?=$userInfo['ingot']?></p>


<h1>辅助咒符</h1>
<? 
$html = "<table>";

foreach ($auxiliary as $v) {
	switch($v['props_id']){
		case 1:
			$href = "../props/buyUserProps.php";
			$num = User_Property::getPropertyNum($userId, $v['props_id']);
			break;
		case 2:
			$href = "../props/buyPkNum.php";
			$num  = $userInfo['pk_num'];
			break;
		case 3:
			$href = "../props/buyUserProps.php";
			$num = User_Property::getPropertyNum($userId, $v['props_id']);
			break;
		case 4:
			$href = "../props/buyPetNum.php";
			$num  = $userInfo['pet_num'];
			break;
		case 5:
			$href = "../props/buyPackNum.php";
			$num  = $userInfo['pack_num'];
			break;
		case 6:
			$href = "../props/buyUserProps.php";
			$num = User_Property::getPropertyNum($userId, $v['props_id']);
			break;
		case 7:
			$href = "../props/buyFrinedNum.php";
			$num  = $userInfo['friend_num'];
			break;
	}
	$html.= '<tr><td>道具名称:</td><td>'.$v["props_name"].'</td><td>道具数量:'.$num.'</td>';
	$html.= '<td><a href="'.$href.'?user_id='.$userId.'&props_id='.$v["props_id"].'">购买道具</a></td>';
	$html.= '<td><a href="../props/useProperty.php?user_id='.$userId.'&props_id='.$v["props_id"].'">使用道具</a></td>';
}  
$html.= "</table>";
echo $html;
?>


<h1>宝箱咒符</h1>
<?
$html = "<table>";
foreach ($box as $v) {
	$html.= '<tr><td>宝箱名称:</td><td>'.$v["props_name"].'</td>';
	$html.= '<td><a href="../props/buyUserProps.php?user_id='.$userId.'&props_id='.$v["props_id"].'">购买</a></td>';
}
$html.= "</table>";
echo $html;
?>
<h1>锻造咒符</h1>
<?php

$html = "<table>";
foreach ($forge as $v){
	$num = User_Property::getPropertyNum($userId, $v['props_id']);
	$html.= '<tr><td>道具名称:</td><td>'.$v["props_name"].'</td><td>道具数量:'.$num.'</td>';
	$html.= '<td><a href="../props/buyUserProps.php?user_id='.$userId.'&props_id='.$v["props_id"].'">购买</a></td>';
	$html.= '<td><a href="../props/useProperty.php?user_id='.$userId.'&props_id='.$v["props_id"].'">使用道具</a></td>';
}
$html.= "</table>";
echo $html;
?>
</table>

<a href="map.php">地图</a>
<a href="race.php">角色</a>
<a href="pk.php">PK</a>
<a href="shop.php">商店</a>
<a href="friend.php">好友</a>
<a href="other.php">其他</a>
