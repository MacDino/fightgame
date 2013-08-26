<?php
//读取用户所有装备,对应前台 "角色-背包"
//返回的格式应该是 array(装备名, 等级, 是否装备, json格式的基本属性, json格式的附加属性, json格式的强化属性);
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID

if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确';
    $msg = '1';
    die;
}

//背包中全部装备
$equipInfo = Equip_Info::getEquipListByUserId($userId);
//var_dump($equipInfo);

?>

<a href="http://kaedezyf.com/webroot/test/index.php?user_id=<?=$userId?>">主页</a>
<table align="center">
<? foreach ($equipInfo as $i){?>
<tr>
	<th>装备ID:<?=$i["user_equid_id"]?></th><th>装备颜色:<?=$i["equip_colour"]?></th><th>装备名称:<?=$i["equip_type"]?></th>
</tr>
<tr>
	<th>是否使用:<?=$i["is_used"]?></th><th>装备种族:<?=$i["race_id"]?></th><th>装备级别:<?=$i["equid_level"]?></th>
</tr>
<tr>
	<th><a href="">打造装备</a></th><th><a href="../equipment/getInfobyId.php?equip_id=<?=$i["user_equid_id"]?>">查看装备详情</a></th><th><a href="">卖出装备</a></th><th><a href="">使用装备</a></th>
</tr>
<? }?>
</table>