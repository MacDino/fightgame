<?php
//使用技能列表,按类型分开
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$act 			= isset($_REQUEST['act'])?$_REQUEST['act']:'';//动作

//属性
$equip_colour   	= isset($_REQUEST['equip_colour'])?$_REQUEST['equip_colour']:'';//颜色
$equip_type  		= isset($_REQUEST['equip_type'])?$_REQUEST['equip_type']:'';//类型
$equip_quality 		= isset($_REQUEST['equip_quality'])?$_REQUEST['equip_quality']:'';//品质
$equip_level   		= isset($_REQUEST['equip_level'])?$_REQUEST['equip_level']:'';//等级
$race_id   		= isset($_REQUEST['race_id'])?$_REQUEST['race_id']:'';//种族

$userId     	= isset($_COOKIE['user_id'])?$_COOKIE['user_id']:'';//用户ID
if($act == 'add'){
//	print_r($_POST);
	$res = Equip_Create::createEquip($equip_colour, $userId, $equip_level, $equip_type, $equip_quality, $race_id);
	if($res){
		echo "<script>location.href='createEquip.php';</script>";
	}
}elseif($act == 'del'){
	$equip_id   		= isset($_REQUEST['equip_id'])?$_REQUEST['equip_id']:'';//等级
	$res = Equip_Info::delEquip($equip_id);
	if($res){
		echo "<script>location.href='createEquip.php';</script>";
	}
}else{
	$result = Equip_Info::getEquipListByUserId($userId);
}
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<form action="?act=add" method="POST"?>
<table>
		<tr><td>等级:
		<select name="equip_level">
			<option value ="0" >0</option>
			<option value ="10" >10</option>
		    <option value ="20" >20</option>
		    <option value ="30" >30</option>
		    <option value ="40" >40</option>
		    <option value ="50" >50</option>
		    <option value ="60" >60</option>
		    <option value ="70" >70</option>
		    <option value ="80" >80</option>
		    <option value ="90" >90</option>
		</select>
		</td></tr>		

		<tr><td>颜色:
		<select name="equip_colour">
			<option value ="3801" >灰色</option>
		    <option value ="3802" >白色</option>
		    <option value="3803" >绿色</option>
		    <option value ="3804" >蓝色</option>
		    <option value ="3805" >紫色</option>
		    <option value="3806" >橙色</option>
		</select>
		</td></tr>

		<tr><td>位置:
		<select name="equip_type">
			<option value ="3901" >武器</option>
		    <option value ="3902" >头盔</option>
		    <option value="3903" >项链</option>
		    <option value ="3904" >衣服</option>
		    <option value ="3905" >腰带</option>
		    <option value="3906" >鞋子</option>
		</select>
		</td></tr>

		<tr><td>种族:
		<select name="race_id">
			<option value ="" >无种族</option>
			<option value ="1" >人族</option>
		    <option value ="2" >仙族</option>
		    <option value="3" >魔族</option>
		</select>
		</td></tr>
		
		<tr><td>品质:
		<select name="equip_quality">
			<option value ="3701" >普通</option>
		    <option value ="3702" >进阶</option>
		    <option value="3703" >升华</option>
		    <option value="3704" >圣品</option>
		</select>
		</td></tr>
<tr><td><input value="生成装备" type="submit"></td><td><a href="index.php">选角色</a></td><td><a href="login.php">选功能</a></td></tr>
</table>
</form>


--------------------------------------现有装备--------------------------------------------------
<table>
<? if(!empty($result)){
	foreach ($result as $i){
	?>
		<tr>
			<td>等级:<?=$i['equip_level']?></td>
			<td>状态:
				<? if($i['is_used'] == 0)echo "未使用";?>
			    <? if($i['is_used'] == 1)echo "使用中";?>
			</td>
			<td>种族:
				<? if($i['race_id'] == 1)echo "人族";?>
			    <? if($i['race_id'] == 2)echo "仙族";?>
				<? if($i['race_id'] == 3)echo "魔族";?>
			</td>
			<td>颜色:
				<? if($i['equip_colour'] == 3801)echo "灰色";?>
			    <? if($i['equip_colour'] == 3802)echo "白色";?>
				<? if($i['equip_colour'] == 3803)echo "绿色";?>
				<? if($i['equip_colour'] == 3804)echo "蓝色";?>
			    <? if($i['equip_colour'] == 3805)echo "紫色";?>
				<? if($i['equip_colour'] == 3806)echo "橙色";?>
			</td>
			<td>位置:
				<? if($i['equip_type'] == 3901)echo "武器";?>
			    <? if($i['equip_type'] == 3902)echo "头盔";?>
				<? if($i['equip_type'] == 3903)echo "项链";?>
				<? if($i['equip_type'] == 3904)echo "衣服";?>
			    <? if($i['equip_type'] == 3905)echo "腰带";?>
				<? if($i['equip_type'] == 3906)echo "鞋子";?>
			</td>
			<td>品质:
				<? if($i['equip_quality'] == 3701)echo "普通";?>
			    <? if($i['equip_quality'] == 3702)echo "进阶";?>
				<? if($i['equip_quality'] == 3703)echo "升华";?>
				<? if($i['equip_quality'] == 3704)echo "圣品";?>
			</td>
			<td>
			<a href="?act=del&equip_id=<?=$i['user_equip_id']?>">删除</a>
			</td>
			<td>
			<a href="detailsEquip.php?equip_id=<?=$i['user_equip_id']?>" target="_blank">详细属性</a>
			</td>
		</tr>
<? }}?>
</table>