<?php
//更新用户基本信息,其实真正的业务应该用不上这个方法
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$equipId 			= isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//装备ID


$res = Equip_Info::getEquipInfoById($equipId);


$base = json_decode($res['attribute_base_list'], true);
$value = json_decode($res['attribute_list'], true);
print_r($base);
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
	<tr><td>命中:<? echo $base['1106'];?></td></tr>
	<tr><td>伤害:<? echo $base['1107'];?></td></tr>
	<tr><td>魔法:<? echo $base['1108'];?></td></tr>
	<tr><td>气血:<? echo $base['1109'];?></td></tr>
	<tr><td>灵力:<? echo $base['1110'];?></td></tr>
	<tr><td>速度:<? echo $base['1111'];?></td></tr>
	<tr><td>防御:<? echo $base['1112'];?></td></tr>
	<tr><td>躲闪:<? echo $base['1113'];?></td></tr>
	<tr><td>幸运:<? echo $base['1114'];?></td></tr>
	<tr><td>释放概率:<? echo $base['1301'];?></td></tr>
	
	<tr><td>重击:<? echo $base['1201'];?></td></tr>
	<tr><td>连击:<? echo $base['1202'];?></td></tr>
	<tr><td>灵犀一指:<? echo $base['1203'];?></td></tr>
	<tr><td>三昧真火:<? echo $base['1204'];?></td></tr>
	<tr><td>呼风唤雨:<? echo $base['1205'];?></td></tr>
	<tr><td>五雷决:<? echo $base['1206'];?></td></tr>
	<tr><td>物防修:<? echo $base['1207'];?></td></tr>
	<tr><td>法防修:<? echo $base['1208'];?></td></tr>
	<tr><td>攻修:<? echo $base['1209'];?></td></tr>
	<tr><td>法修:<? echo $base['1210'];?></td></tr>
	<tr><td>锻造:<? echo $base['1212'];?></td></tr>
	<tr><td>防御:<? echo $base['1212'];?></td></tr>
	<tr><td>反击:<? echo $base['1213'];?></td></tr>
	<tr><td>法盾:<? echo $base['1214'];?></td></tr>
	<tr><td>体修:<? echo $base['1215'];?></td></tr>
	<tr><td>普通攻击:<? echo $base['1216'];?></td></tr>
</table>
<? }?>
--------------------------------------成长属性----------------------------------------------------------
<? if(!empty($value)){?>
<table>
	<tr><td>力量:<? echo $value['1101'];?></td></tr>
	<tr><td>魔力:<? echo $value['1102'];?></td></tr>
	<tr><td>体质:<? echo $value['1103'];?></td></tr>
	<tr><td>耐力:<? echo $value['1104'];?></td></tr>
	<tr><td>敏捷:<? echo $value['1105'];?></td></tr>
	<tr><td>命中:<? echo $value['1106'];?></td></tr>
	<tr><td>伤害:<? echo $value['1107'];?></td></tr>
	<tr><td>魔法:<? echo $value['1108'];?></td></tr>
	<tr><td>气血:<? echo $value['1109'];?></td></tr>
	<tr><td>灵力:<? echo $value['1110'];?></td></tr>
	<tr><td>速度:<? echo $value['1111'];?></td></tr>
	<tr><td>防御:<? echo $value['1112'];?></td></tr>
	<tr><td>躲闪:<? echo $value['1113'];?></td></tr>
	<tr><td>幸运:<? echo $value['1114'];?></td></tr>
	<tr><td>释放概率:<? echo $value['1301'];?></td></tr>

	<tr><td>重击:<? echo $value['1201'];?></td></tr>
	<tr><td>连击:<? echo $value['1202'];?></td></tr>
	<tr><td>灵犀一指:<? echo $value['1203'];?></td></tr>
	<tr><td>三昧真火:<? echo $value['1204'];?></td></tr>
	<tr><td>呼风唤雨:<? echo $value['1205'];?></td></tr>
	<tr><td>五雷决:<? echo $value['1206'];?></td></tr>
	<tr><td>物防修:<? echo $value['1207'];?></td></tr>
	<tr><td>法防修:<? echo $value['1208'];?></td></tr>
	<tr><td>攻修:<? echo $value['1209'];?></td></tr>
	<tr><td>法修:<? echo $value['1210'];?></td></tr>
	<tr><td>锻造:<? echo $value['1212'];?></td></tr>
	<tr><td>防御:<? echo $value['1212'];?></td></tr>
	<tr><td>反击:<? echo $value['1213'];?></td></tr>
	<tr><td>法盾:<? echo $value['1214'];?></td></tr>
	<tr><td>体修:<? echo $value['1215'];?></td></tr>
	<tr><td>普通攻击:<? echo $value['1216'];?></td></tr>
</table>
<? }?> 