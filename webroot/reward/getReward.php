<?php
//领取奖励
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

$rewardId = isset($_REQUEST['reward_id'])?$_REQUEST['reward_id']:'';//奖励ID
$contentId = isset($_REQUEST['content_id'])?$_REQUEST['content_id']:'';//content_key

if(!$rewardId){
    $code = 100001;
    $msg = '缺少必传参数';
    die;
}

$rewardInfo = Reward::getRewardInfoById($rewardId);
if($contentId == 'box'){
    
    $userInfo = User_Info::getUserInfoByUserId($rewardInfo['user_id']);
    $maxPack = $userInfo['pack_num'];
    $nowPack = Equip_Info::getEquipNum($rewardInfo['user_id']);
    //echo $maxPack."<br>";
    //echo $nowPack;exit;
    if($nowPack >= $maxPack){
        $code = 150201;
        $msg = '你的包裹已满,请先清理包裹';
        die;
    }    
}


$content = json_decode($rewardInfo['content'], true);
if(!key_exists($contentId, $content)){
	$code = 150101;
    $msg = '已经领取过了';
    die;
}


try {
	$data = Reward::getReward($rewardId, $contentId);
    $code = 0;
    die;
} catch (Exception $e) {
    $code = 100099;
    $msg = '程序内部错误';
    die;    
}