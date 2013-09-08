<?php
//获取用户信息，包括用户基本信息，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$userId = isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'27';//用户ID
if(!$userId)
{
    echo '无法获得当前用户信息';
    exit;
}
?>

<p>
<a href="pack.php">背包</a>
<a href="attribute.php">属性</a>
<a href="pet.php">人宠</a>
<a href="skill.php">技能</a>
<a href="award.php">奖励</a>
<a href="forge.php">锻造</a>
</p>

<p>
<a href="map.php">地图</a>
<a href="race.php">角色</a>
<a href="pk.php">PK</a>
<a href="shop.php">商店</a>
<a href="friend.php">好友</a>
<a href="other.php">其他</a>
</p>