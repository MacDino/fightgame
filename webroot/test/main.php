<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';
if($userId)
{
    $interFace = 'user/getUserInfo';
    $params = array('user_id' => $userId);
    $data = Curl::sendRequest($interFace, $params);
    if($data['c'] == 0)
    {
    
    
    }
    setcookie('user_info', json_encode($userInfo),  time()+360000);    
}

$currentUserInfo = isset($_COOKIE['user_info'])?json_decode($_COOKIE['user_info'], true):'';

if(!$currentUserInfo)
{
    echo '无法获得当前用户信息';
    exit;
}

?>

用户信息<br />
名称:<?php echo $currentUserInfo['user_name']?> <br />
等级:<?php echo $currentUserInfo['user_level']?><br />
铜钱:<?php echo $currentUserInfo['money']?><br />
元宝:<?php echo $currentUserInfo['ingot']?><br />
经验:<?php echo $currentUserInfo['experience']?><br />
生命:0<br />
魔法:0<br />



<a href="map.php">地图</a>
<a href="race.php">角色</a>
<a href="pk.php">PK</a>
<a href="shop.php">商店</a>
<a href="friend.php">好友</a>
<a href="other.php">其他</a>
