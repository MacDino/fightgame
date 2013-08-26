<?php
//选区进入游戏,获取用户列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$masterId   = isset($_REQUEST['master_id'])?$_REQUEST['master_id']:'';//帐号ID
$area	  = isset($_REQUEST['area'])?$_REQUEST['area']:'';//分区
//echo "bindType==$bindType&&bindValue==$bindValue";

if(!$masterId || !$area)
{
	$code = 1;
//    $msg = '传入参数不正确';
	$msg = '1';
    die;
}

try {
    //获取用户
    $res = User_Info::listUser($masterId, $area);
} catch (Exception $e) {
    $code = 0;
//    $msg = '获取账户失败!';
	$msg = '999';
    die;    
}
?>

<table>
<form method="GET" action="createUser.php" name="createUser">
<tr><td><input type="button" onclick="document.getElementById('div').style.display=(document.getElementById('div').style.display=='none')?'':'none'"  value="创建角色"/></td></tr>
<tr><td>
<div id="div" style="width: 300px;border: 1px dashed #CCCCCC;background-color: #FFFFCC; display:none">
<input align="left" id="user_name" name="user_name" value="">用户名
<select name="race_id" id="race_id">
<option selected="1" value="1">人族
<option value="2">仙族
<option value="3">魔族
</select>种族
<input id="master_id" name="master_id" value="<?=$masterId?>" style="display:none;">
<input id="area" name="area" value="<?=$area?>" style="display:none;">
<input type="submit" value="提交"></div>
</td></tr>
</form>
</table>

<table>
<?php foreach ($res as $i){?>
	<tr>
		<td>用户ID:<?=$i['user_id']?></td><td><a href="../test/index.php?user_id=<?=$i['user_id']?>">用户名:<?=$i['user_name']?></a></td><td>种族:<?=$i['race_id']?></td><br>
		<td>等级:<?=$i['user_level']?></td><td>金钱:<?=$i['money']?></td><b><td>元宝:<?=$i['ingot']?></td>
	</tr>
<?php }?>
</table>