<?php

class Message
{
    CONST TABLE_NAME = 'messages';

    public static function createFriendRequestMsg($receiveUserId, $userId)
    {
        $data['user_id'] = $receiveUserId;
        $data['tpl_id'] = 1;
        $data['tpl_data'] = array('user_id' => $userId);
        return self::_createData($data);
    }

    public static function createEmploymentMsg($receiveUserId, $userId, $money)
    {
        $data['user_id'] = $receiveUserId;
        $data['tpl_id'] = 2;
        $data['tpl_data'] = array('user_id' => $userId, 'money' => $money);
        return self::_createData($data);
    }

    public static function createConquerMsg($receiveUserId, $userId)
    {
        $data['user_id'] = $receiveUserId;
        $data['tpl_id'] = 3;
        $data['tpl_data'] = array('user_id' => $userId);
        return self::_createData($data);
    }

    private static function _createData($data)
    {
        if(is_array($data['tpl_data']))$data['tpl_data'] = json_encode($data['tpl_data']);
        $data['is_read'] = 0;
        $data['create_time'] = date('Y-m-d H:i:s');
        return MySql::insert(self::TABLE_NAME, $data, true);
    }

    public static function delete($userId, $messageId)
    {
        return MySql::delete(self::TABLE_NAME, array('user_id' => $userId, 'message_id' => $messageId));
    }

    public static function read($userId, $messageId)
    {
         return MySql::update(self::TABLE_NAME, array('is_read' => 1), array('user_id' => $userId, 'message_id' => $messageId));
    }

    public static function isHaveNew($userId, $msgId = 0)
    {
       return MySql::selectCount(self::TABLE_NAME, array('is_read' => 0, 'user_id' => $userId, 'message_id' => array('opt' => '>=' , 'val' => $msgId)));
    }

    public static function listMeg($userId, $msgId = 0 , $offset)
    {
        return MySql::select(self::TABLE_NAME, array('user_id' => $userId, 'is_read' => 0, 'message_id' => array('opt' => '>=' , 'val' => $message_id)), NULL, array('message_id DESC'), 0, $limit);
    }

    public static function msgTplList()
    {
        $tplList = array(
            1 => "{userName}发送了一条好友请求",
            2 => "{userName}雇佣了{targetUserName}，{targetUserName}获得了{money}金钱",
            3 => "{userName}征服了{targetUserName}",
        );
        return $tplList;
    }
}
