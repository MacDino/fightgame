<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$act = isset($_REQUEST['act'])?$_REQUEST['act']:'';
$areaId = isset($_REQUEST['area_id'])?$_REQUEST['area_id']:'';
$raceId = isset($_REQUEST['race_id'])?$_REQUEST['race_id']:'';
$masterId = isset($_COOKIE['matser_id'])?$_COOKIE['matser_id']:'';
if(!$areaId || !$raceId || !$masterId)
{
    echo '无法获得信息！';
    exit;
}
if($act == 'create')
{
    $userName = isset($_REQUEST['user_name'])?$_REQUEST['user_name']:'';
    if($userName)
    {
        $interFace = 'user/createUser';
        $params = array('matser_id' => $masterId, 'area_id' => $areaId, 'race_id' => $raceId, 'user_name' => $userName);
        $data = Curl::sendRequest($interFace, $params);
        $data = json_decode($data, true);
        if($data['c'] == 0)
        {
            setcookie('user_info', json_encode($data['d']['user_info']),  time()+360000);    
            echo "<script>location.href='main.php'</script>"; 
        }
        echo '创建角色失败';
    }else{
        echo '无法获得用户名!';
    }
    exit;
}
 Equip_Create::createEquip(Equip::EQUIP_TYPE_ARMS, Equip::EQUIP_COLOUR_BLUE, Equip::EQUIP_QUALITY_GENERAL, 27);

?>
<form method="POST" action="" name="createUser">
昵称<input id="user_name" name="user_name" value="">
<input type="submit" value="提交">
<input type="hidden" name ="act" value="create">
</form>
