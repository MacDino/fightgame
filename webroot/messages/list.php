<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';


$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';
$msgId = isset($_REQUEST['msg_id'])?$_REQUEST['msg_id']:'';
$limit = isset($_REQUEST['limit'])?$_REQUEST['limit']:5;

if($limit>10)$limit = 10;

$res = Message::listMeg($userId, $msgId, $limit);

if($res && is_array($res))
{
    foreach($res as $value)
    {
        $tpl_data = json_decode($value['tpl_data'], true);
        $userIds[] = $tpl_data['user_id'];
    }
    $userInfo = User_Info::getUserInfoByUserIds($userIds);
    $tplList = Message::msgTplList();
    foreach($res as $value)
    {
        $tpl_data = json_decode($value['tpl_data'], true);
        $userName =  isset($userInfo[$tpl_data['user_id']]['user_name'])?$userInfo[$tpl_data['user_id']]['user_name']:'无名氏';
        $targetUserName = '你';
        $money = isset($tpl_data['money'])?$tpl_data['money']:0;
        $msg = str_replace(array('{userName}', '{targetUserName}', '{money}'), array($userName), $tplList[$value['tpl_id']]); 
        $messageList[] = array(
            'msg_id' => $value['message_id'],
            'type' => $value['tpl_id'] - 1,
            'dec' => $msg,
            'coin' => $money,
            'used_id' => $tpl_data['user_id'],
        );
    }
}

$data = $messageList;
