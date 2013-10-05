<?php
//更新用户基本信息,其实真正的业务应该用不上这个方法
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$act 			= isset($_REQUEST['act'])?$_REQUEST['act']:'';//动作

//轻易不更改
$user_name   	= isset($_REQUEST['user_name'])?$_REQUEST['user_name']:'';//用户名
$race_id  		= isset($_REQUEST['race_id'])?$_REQUEST['race_id']:'';//种族
$sex 			= isset($_REQUEST['sex'])?$_REQUEST['sex']:'';//性别

$user_level   	= isset($_REQUEST['user_level'])?$_REQUEST['user_level']:'';//等级

//更改频率高,需优化
$experience     = isset($_REQUEST['experience'])?$_REQUEST['experience']:'';//经验
$money   		= isset($_REQUEST['money'])?$_REQUEST['money']:'';//金钱
$resultngot   		= isset($_REQUEST['ingot'])?$_REQUEST['ingot']:'';//元宝

$pack_num   	= isset($_REQUEST['pack_num'])?$_REQUEST['pack_num']:'';//背包上限
$pk_num			= isset($_REQUEST['pk_num'])?$_REQUEST['pk_num']:'';//PK次数
$pk_num			= isset($_REQUEST['pk_num'])?$_REQUEST['pk_num']:'';//PK次数


$skil_point   	= isset($_REQUEST['skil_point'])?$_REQUEST['skil_point']:'';//技能点
$reputation   	= isset($_REQUEST['reputation'])?$_REQUEST['reputation']:'';//声望
$resultntegral   	= isset($_REQUEST['integral'])?$_REQUEST['integral']:'';//积分

$userId     	= isset($_COOKIE['user_id'])?$_COOKIE['user_id']:'';//用户ID\

if($act == 'edit'){
	$res = User_Info::editUserInfo($_POST, $userId);
	if($res){
		echo "<script>location.href='editUserBaseInfo.php';</script>";
	}
}else{
	$result = User_Info::getUserInfoByUserId($userId);
	print_r($result);
	$base = User_Info::getUserInfoFightAttribute($userId);
	$value = User_Info::getUserInfoFightAttribute($userId, TRUE);
}
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<form action="?act=edit" method="POST"?>
<table>
<? if(!empty($result)){?>
		<tr><td>名字:<input name="user_name" value="<?=$result['user_name']?>"?></td></tr>
		<tr><td>种族:
		<select name="race_id">
			<option value ="1" <? if($result['race_id'] == 1)echo "selected";?>>人族</option>
		    <option value ="2" <? if($result['race_id'] == 2)echo "selected";?>>仙族</option>
		    <option value ="3" <? if($result['race_id'] == 3)echo "selected";?>>魔族</option>
		</select>
		</td></tr>
		<tr><td>性别:
		<select name="sex">
			<option value ="0" <? if($result['sex'] == 0)echo "selected";?>>男</option>
		    <option value ="1" <? if($result['sex'] == 1)echo "selected";?>>女</option>
		</select>
		</td></tr>
		<tr><td>等级:<input name="user_level" value="<?=$result['user_level']?>"?></td></tr>
		<tr><td>经验:<input name="experience" value="<?=$result['experience']?>"?></td></tr>
		<tr><td>金钱:<input name="money" value="<?=$result['money']?>"?></td></tr>
		<tr><td>元宝:<input name="ingot" value="<?=$result['ingot']?>"?></td></tr>
		<tr><td>技能点:<input name="skil_point" value="<?=$result['skil_point']?>"?></td></tr>
		<tr><td>声望:<input name="reputation" value="<?=$result['reputation']?>"?></td></tr>
		<tr><td>积分:<input name="integral" value="<?=$result['integral']?>"?></td></tr>
		<tr><td>背包上限:<input name="pack_num" value="<?=$result['pack_num']?>"?></td></tr>
		<tr><td>好友上限:<input name="friend_num" value="<?=$result['friend_num']?>"?></td></tr>
		<tr><td>人宠上限:<input name="pet_num" value="<?=$result['pet_num']?>"?></td></tr>
		<tr><td>PK剩余次数:<input name="pk_num" value="<?=$result['pk_num']?>"?></td></tr>
<? }?>
<tr><td><input value="修改数据" type="submit"></td><td><a href="index.php">选角色</a></td><td><a href="login.php">选功能</a></td></tr>
</table>
</form>


--------------------------------------基本属性--------------------------------------------------
   
    
<? if(!empty($base)){?>
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
