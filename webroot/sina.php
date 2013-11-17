<?php
    /*$url = "https://api.weibo.com/2/friendships/friends.json?uid=3192426200&access_token=2.0056QDAEaacJJD38d2ebc51c0DnxKV";
//$url = "https://api.weibo.com/2/friendships/friends/ids.json?access_token=2.0056QDAEaacJJD38d2ebc51c0DnxKV&source=2883678812";
//    $url = "http://kaedezyf.com/fight/monster.php?user_id=27&map_id=1";
    echo $url.'<br />';
     
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    // 设置是否显示header信息 0是不显示，1是显示  默认为0
    curl_setopt($curl, CURLOPT_HEADER, 0);
    // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。0显示在屏幕上，1不显示在屏幕上，默认为0
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // 要验证的用户名密码
    curl_setopt($curl, CURLOPT_USERPWD, "appgamego@gmail.com:ewei820618");
    $data = curl_exec($curl);
    curl_close($curl);
     
    $result = json_decode($data, true);
     
    echo '<pre>';
    print_r($result);
    echo '</pre>';*/
    
    $url = "https://api.weibo.com/2/friendships/friends.json?uid=3192426200&access_token=2.0056QDAEaacJJD38d2ebc51c0DnxKV";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($curl);
curl_close($curl);
 
$result = json_decode($data, true);
 
echo '<pre>';
print_r($result);
echo '</pre>';

