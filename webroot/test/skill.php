<?php
//显示技能
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$act   = isset($_REQUEST['act'])?$_REQUEST['act']:'';//动作
//echo $act;
$userInfo = json_decode($_REQUEST['user_info'], TRUE);
$userId = $userInfo['user_id'];

if($userId)
{
	if($act == 'update'){//升级技能
		
	}elseif($act == 'get'){//技能等级
		
	}else{
//		echo 3;exit;
		$interFace = 'skill/list';
	    $params = array('user_id' => $userId);
	    $data = Curl::sendRequest($interFace, $params);
		$res = json_decode($data, TRUE);
		if($res['c'] == 0){
			$result = $res['d'];
		}
	}
}
?>

<table>
<? if(is_array($result)){
	foreach ($result as $i){
?>
<tr>
	<td>技能名称:<?=$i["skill_id"]?></td><td>技能等级:<?=$i["skill_level"]?></td>
</tr>
<? }}?>
</table>