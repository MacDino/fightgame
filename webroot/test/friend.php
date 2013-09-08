<?php
//显示好友
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$act   = isset($_REQUEST['act'])?$_REQUEST['act']:'';//动作
//echo $act;
$userInfo = json_decode($_REQUEST['user_info'], TRUE);
$userId = $userInfo['user_id'];

if($userId)
{
	if($act == 'del'){
		$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
		$interFace = 'friend/deteleFriend';
	    $params = array('user_id' => $userId, 'friend_id' => $friendId);
	    $data = Curl::sendRequest($interFace, $params);
		$res = json_decode($data, TRUE);
		if($res['c'] == 0){
			echo "<script>alert('删除成功');location.href='friend.php'</script>";
		}else{
			echo "<script>alert('删除失败');location.href='friend.php'</script>";
		}
	}elseif($act == 'add'){
		$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
		$interFace = 'friend/createFriend';
	    $params = array('user_id' => $userId, 'friend_id' => $friendId);
	    $data = Curl::sendRequest($interFace, $params);
		$res = json_decode($data, TRUE);
		if($res['c'] == 0){
			echo "<script>alert('申请成功');location.href='friend.php'</script>";
		}else{
			echo "<script>alert('申请失败');location.href='friend.php'</script>";
		}
	}elseif($act == 'agr'){
		$friendId   = isset($_REQUEST['friend_id'])?$_REQUEST['friend_id']:'';//好友ID
		$interFace = 'friend/agreeFriend';
	    $params = array('user_id' => $userId, 'friend_id' => $friendId);
	    $data = Curl::sendRequest($interFace, $params);
		$res = json_decode($data, TRUE);
		if($res['c'] == 0){
			echo "<script>alert('添加成功');location.href='friend.php'</script>";
		}else{
			echo "<script>alert('添加失败');location.href='friend.php'</script>";
		}
	}else{
		$interFace = 'friend/listFriend';
	    $params = array('user_id' => $userId);
	    $data = Curl::sendRequest($interFace, $params);
		$res = json_decode($data, TRUE);
		$result = $res['d'];
	
    
//	print_r($result);
}
?>
<table>
<form method="GET" action="" name="createFriend">
<tr><td><input type="button" onclick="document.getElementById('div').style.display=(document.getElementById('div').style.display=='none')?'':'none'"  value="添加好友"/></td></tr>
<tr><td>
<div id="div" style="width: 300px;border: 1px dashed #CCCCCC;background-color: #FFFFCC; display:none">
<input align="left" id="friend_id" name="friend_id" value="">
<input id="act" name="act" value="add" style="display:none;">
<input type="submit" value="提交"></div>
</td></tr>
</form>
</table>

<table>
<? if(is_array($result)){
foreach ($result as $i){?>
	<tr>
		<td>好友名字:<?=$i['user_name']?></td><td>好友等级:<?=$i['user_level']?></td>
		
		<td>
		<?php if($i['pass'] == 2){?>
		<a href="?act=del&friend_id=<?=$i['friend_id']?>">删除</a>
		<?php }else{ ?>
		<a href="?act=agr&friend_id=<?=$i['friend_id']?>">同意</a>
		<?php }?>
		</td>
		
	</tr>
<? }}?>
</table>
<?php }?>


<p>
<a href="map.php">地图</a>
<a href="race.php">角色</a>
<a href="pk.php">PK</a>
<a href="shop.php">商店</a>
<a href="friend.php">好友</a>
<a href="other.php">其他</a>
</p>