<?php
//登录,获取账户ID
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$bindType   = isset($_REQUEST['bind_type'])?$_REQUEST['bind_type']:'';//绑定用户类别
$bindValue  = isset($_REQUEST['bind_value'])?$_REQUEST['bind_value']:'';//绑定用户值
//echo "bindType==$bindType&&bindValue==$bindValue";

if(!$bindType || !$bindValue)
{
	$code = 1;
//    $msg = '传入参数不正确';
	$msg = '1';
    die;
}

try {
    //获取用户
    $res = User_Info::getMasterInfo($bindType, $bindValue);
} catch (Exception $e) {
    $code = 0;
//    $msg = '获取账户失败!';
	$msg = '999';
    die;    
}
?>

帐号ID:<?=$res?><br>
<table>
<form method="GET" action="listUser.php" name="listUser">
<tr><td>
<select name="area" id="area">
<option selected="1" value="1">一区
<option value="2">二区
<option value="3">三区
</select>种族
<input id="master_id" name="master_id" value="<?=$res?>" style="display:none;">
<input type="submit" value="提交">
</td></tr>
</form>
</table>