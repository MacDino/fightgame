<?php
//领取奖励
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$rewardId = isset($_REQUEST['reward_id'])?$_REQUEST['reward_id']:'';//奖励ID
$content = isset($_REQUEST['content'])?$_REQUEST['content']:'';//content_key

if(!$rewardId)
{
    $code = 1;
    $msg = '传入参数不正确';
    die;
}



try {
	$data = Reward::getReward($rewardId, $content);
    $code = 0;
    $msg = 'ok';
    die;
} catch (Exception $e) {
    $code = 99;
    $msg = '内部错误';
    die;    
}