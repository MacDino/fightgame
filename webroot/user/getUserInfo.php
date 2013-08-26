<?php
//对应前台"角色-属性"
//包括 使用中装备  角色基本属性  角色成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     	= isset($_REQUEST['user_id'])?(int)$_REQUEST['user_id']:'';//用户ID
if(!$userId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}

//使用中装备
$equipInfo = Equip_Info::getEquipListByUserId($userId, TRUE);
//var_dump($equipInfo);

//角色基本属性(点)
$baseAttribute = User_Info::getUserInfoFightAttribute($userId);
//var_dump($baseAttribute);

//角色成长属性(值)
$valueAttribute = User_Info::getUserInfoFightAttribute($userId, TRUE);
//var_dump($valueAttribute);

?>
<a href="http://kaedezyf.com/webroot/test/index.php?user_id=<?=$userId?>">主页</a>
<table align="center">
<tr><th>身上装备</th></tr>
<? foreach ($equipInfo as $i){?>
<tr>
	<th>装备颜色:<?=$i["equip_colour"]?></th><th>装备等级:<?=$i["equid_level"]?></th>
</tr>
<tr>
	<th>装备种族:<?=$i["race_id"]?></th><th>装备级别:<?=$i["equid_level"]?></th>
</tr>
<tr>
	<th><a href="..">查看装备详情</a></th>
</tr>
<? }?>
</table>

<table align="center">
<tr><th>属性点</th></tr>
<? foreach ($baseAttribute as $i=>$key){?>
<tr>
	<th>属性:<?=$i?></th><th>点数:<?=$key?></th>
</tr>
<? }?>
</table>

<table align="center">
<tr><th>属性值</th></tr>
<? foreach ($valueAttribute as $i=>$key){?>
<tr>
	<th>属性:<?=$i?></th><th>数值:<?=$key?></th>
</tr>
<? }?>
</table>