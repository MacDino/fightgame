<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$areaId = isset($_GET['area_id'])?$_GET['area_id']:'';
$loginUserId = isset($_COOKIE['login_user_id'])?$_COOKIE['login_user_id']:'';

if(!$areaId || !$loginUserId)
{
    echo "<script>location.href='index.php'</script>"; 
}
$interFace = 'user/getUserRaceList';
$params = array('login_user_id' => $loginUserId, 'area_id' => $areaId);
$data = Curl::sendRequest($interFace, $params);

$data = json_decode($data, true);

if($data['c'] == 0)
{
    $data = $data['d'];
    if($data['user_race_list'])
    {
        $userRaceList = $data['user_race_list'];
        $userId = $userRaceList[0]['user_id'];
        echo '<script>location.href="main.php?user_id='.$userId.'"</script>';
    }else{
        foreach($data['race_list'] as $raceId => $raceName)
        {
            echo $raceName."<a href='createRace.php?area_id=".$areaId."&race_id=".$raceId."'>创建角色</a><br />";
        } 
    }
}else{
    echo '无法获得用户角色信息';
}
