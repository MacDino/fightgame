<?php
//显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId     = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//用户ID
//echo "UserId=====".$userId;exit;

//数据进行校验,非空,数据内
if(!$userId)
{
    $code = 1;
    //$msg = '传入参数不正确!';
    $msg = '1';
    die;
}
$reslut = Friend_Info::getFriendInfo($userId);
//var_dump($reslut);
try {
    //显示好友
    Friend_Info::getFriendInfo($userId);
//    $code = 0;
//    $msg = 'OK';
//    die;
} catch (Exception $e) {
    $code = 1;
    //$msg = '显示好友失败!';
    $msg = '99';
    die;    
}


?>
<a href="http://kaedezyf.com/webroot/test/index.php?user_id=<?=$userId?>">主页</a>
<table>
<form method="GET" action="createFriend.php" name="createFriend">
<tr><td><input type="button" onclick="document.getElementById('div').style.display=(document.getElementById('div').style.display=='none')?'':'none'"  value="添加好友"/></td></tr>
<tr><td>
<div id="div" style="width: 300px;border: 1px dashed #CCCCCC;background-color: #FFFFCC; display:none">
<input align="left" id="friend_id" name="friend_id" value="">
<input align="middle" id="user_id" name="user_id" value="<?=$userId?>" style="display:none;">
<input type="submit" value="提交"></div>
</td></tr>
</form>
</table>

<table>
<? foreach ($reslut as $i){?>
	<tr>
		<td>好友名字:<?=$i['user_name']?></td><td>好友等级:<?=$i['user_level']?></td>
		
		<td>
		<?php if($i['pass'] == 2){?>
		<a href="deteleFriend.php?user_id=<?=$userId?>&friend_id=<?=$i['friend_id']?>">删除</a>
		<?php }else{ ?>
		<a href="agreeFriend.php?user_id=<?=$userId?>&friend_id=<?=$i['friend_id']?>">同意</a>
		<?php }?>
		</td>
	</tr>
<? }?>
</table>