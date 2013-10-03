<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$masterId = isset($_COOKIE['matser_id'])?$_COOKIE['matser_id']:'';
$act = isset($_GET['act'])?$_GET['act']:'';
if($act == '')
{
    if($masterId)
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
      $masterId = $data['d']['matser_id'];
      if($masterId)
      {
          setcookie('matser_id', $masterId, time()+360000);
          echo "<script>location.href='index.php'</script>"; 
     }
   }
   echo '无法获得用户信息';
}
