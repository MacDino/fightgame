<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$currentUserId = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : '';

if($currentUserId) {
    $userInfo = User_Info::getUserInfoByUserId($currentUserId);

    $interFace = 'map/list';
    $res = Curl::sendRequest($interFace,array());
    $mapList = json_decode($res, true);
    if(is_array($mapList['d']['map_list']) && count($mapList['d']['map_list'])) {
        echo '<table>';
        foreach ($mapList['d']['map_list'] as $mapId => $map) {
            echo "<tr><td>";
            echo $map['map_name'];
            echo "</td>";
            if($map['start_level'] <= $userInfo['user_level']) {
                echo "<td><a href=''>进入";
                echo '</a></td></tr>';
            }  else {
                echo '<td></td></tr>';
            }
        }
        echo '</table>';
    }
}
