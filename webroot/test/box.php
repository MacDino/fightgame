<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$userId = $_REQUEST['user_id'];
$cateId = $_REQUEST['cate_id'] ? $_REQUEST['cate_id'] : 3;
if($userId && $cateId) {
    $params = array(
        'cate_id' => $cateId,
    );
    $interface = 'props/getPropsListByCateId';
    $res = Curl::sendRequest($interface, $params);
    $result = json_decode($res,true);
	if($result['c'] == 0 && is_array($result['d'])) {
		$d = $result['d'];
		//print_r($d);
		foreach($d as $v){
			$propsId = $v['props_id'];
			echo $v['props_name'] . "&nbsp;&nbsp;价格:".$v['price']. "&nbsp;&nbsp;" . "<a href='/props/buyUserProps.php?user_id=$userId&props_id=$propsId' >购买</a> &nbsp;&nbsp<a href='/props/useBox.php?user_id=$userId&props_id=$propsId' >使用</a> "."<br>";
		}
	}
}
