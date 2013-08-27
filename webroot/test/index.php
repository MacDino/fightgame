<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$loginUserId = isset($_COOKIE['login_user_id'])?$_COOKIE['login_user_id']:'';
$act = isset($_GET['act'])?$_GET['act']:'';
$curlConfig = array('server_uri' => 'http://fightgame.php/');
Curl::setConfig($curlConfig);
if($act == '')
{
    if($loginUserId)
    {
        echo "<a href='getRace.php?area_id=1'>1区 上古之战-双 繁忙</a>";
    }else{
        echo '<a href="?act=quickLogin">快速登陆</a><br />'; 
        echo '新浪微博帐号登陆<br />';
        echo '微信帐号登陆';
    }
}elseif($act == 'quickLogin'){
   $macAddress = Test::getMacAddress(); 
   $interFace = 'user/getLoginUserId';
   $params = array('bind_type' => 'mac', 'bind_value' => $macAddress);
   $data = Curl::sendRequest($interFace, $params);
   $data = json_decode($data, true);
   if($data['code'] == 0)
   {
      $loginUserId = $data['data']['login_user_id'];
      if($loginUserId)
      {
          setcookie('login_user_id', $loginUserId, time()+360000);
          echo "<script>location.href='index.php'</script>"; 
     }
   }
   echo '无法获得用户信息';
}


exit;

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';//
?>
<table>
	<tr>
		<td>地图</td>
	</tr>
	<tr>
		<td>选择地图</td><td>日志显示</td><td>装备拾取</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td>角色</td>
	</tr>
	<tr>
		<td><a href="../user/getUserPackInfo.php?user_id=<?=$userId?>">背包</a></td>
		<td><a href="../user/getUserInfo.php?user_id=<?=$userId?>">属性</a></td>
		<td><a href="../user/getUserPetInfo.php?user_id=<?=$userId?>">人宠</a></td>
		<td><a href="../user/getUserSkill.php?user_id=<?=$userId?>">技能</a></td>
		<td><a href="../user/getUserReward.php?user_id=<?=$userId?>">奖励</a></td>
		<td>锻造</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td>PK</td>
	</tr>
	<tr>
		<td>擂台</td><td>征服</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td>商店</td>
	</tr>
	<tr>
		<td><a href="../user/getUserPropertyInfo.php?user_id=<?=$userId?>">道具列表</a></td><td>充值</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td><a href="../friend/listFriend.php?user_id=<?=$userId?>">好友</a></td>
	</tr>
</table>
