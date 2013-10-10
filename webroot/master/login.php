<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$userId 			= isset($_GET['user_id'])?$_GET['user_id']:'';//用户ID

if(!empty($userId)){
	setcookie('user_id', $userId);
}
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<p><a href="editUserBaseInfo.php">修改人物基本属性</a></p>
<p><a href="createEquip.php">给本角色生成装备</a></p>