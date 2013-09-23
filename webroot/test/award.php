<?php
//显示奖励列表
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$userId   = isset($_REQUEST['userId'])?$_REQUEST['userId']:'';

if($userId)
{
		$interFace = 'award/list';
	    $params = array('user_id' => $userId);
	    $data = Curl::sendRequest($interFace, $params);
	    var_dump($data);
		$res = json_decode($data, TRUE);
		if($res['code'] == 0){
			$result = $res['data'];
		}
}
?>

<table>
<? if(is_array($result)){
	foreach ($result as $v){
?>
<tr>
	<td><?=$v["name"]?></td>
	<td><?=$v["desc"]?></td>
	<td>
    <?
        if($v['status'] == 1){
            echo '进行中';    
        }elseif($v['status'] == 2){
            echo '已完成';    
        }
    ?>
    </td>
</tr>
<? }}?>
</table>
