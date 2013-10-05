<?php
//更新用户基本信息,其实真正的业务应该用不上这个方法
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$equipId 			= isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID


$res = Equip_Info::getEquipInfoById($equipId);


$base = json_decode($res['attribute_base_list'], true);
$value = json_decode($res['attribute_list'], true);
print_r($value);
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8">

   
    
<br>
<? if(!empty($base)){?>
--------------------------------------基本属性--------------------------------------------------
<table>
	<tr><td>力量:<? echo $base['1101'];?></td></tr>
	<tr><td>魔力:<? echo $base['1102'];?></td></tr>
	<tr><td>体质:<? echo $base['1103'];?></td></tr>
	<tr><td>耐力:<? echo $base['1104'];?></td></tr>
	<tr><td>敏捷:<? echo $base['1105'];?></td></tr>
</table>
<? }?>
--------------------------------------成长属性----------------------------------------------------------
<? if(!empty($value)){?>
<table>
	<tr><td>命中:<? echo $value['1106'];?></td></tr>
	<tr><td>伤害:<? echo $value['1107'];?></td></tr>
	<tr><td>魔法:<? echo $value['1108'];?></td></tr>
	<tr><td>气血:<? echo $value['1109'];?></td></tr>
	<tr><td>灵力:<? echo $value['1110'];?></td></tr>
	<tr><td>速度:<? echo $value['1111'];?></td></tr>
	<tr><td>防御:<? echo $value['1112'];?></td></tr>
	<tr><td>躲闪:<? echo $value['1113'];?></td></tr>
	<tr><td>幸运:<? echo $value['1114'];?></td></tr>
	<tr><td>释放概率:<? echo $value['301'];?></td></tr>
</table>
<? }?> 