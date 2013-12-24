<?php

class Sina
{
    CONST APP_KEY = '2883678812';
    CONST APP_SECRET  = 'f2237e87046b5e819a988fd5fa6e7419';
    CONST SERVER_HTTPS_URI = 'https://api.weibo.com';

    //根据TOKEN值获取用户USERID
    public static function getSinaUserIdByAccessToken($accessToken)
    {
        $userInfo = self::_getInfoByAccessToken($accessToken);
        if($userInfo && $userInfo['expire_in'] >= 0)
        {
            return $userInfo['uid'];
        }
        return FALSE;
    }



    private static function _getInfoByAccessToken($accessToken)
    {
        $interFace = 'oauth2/get_token_info';
        $params = array(
            'server_uri' => self::SERVER_HTTPS_URI,
            'method_post' => true,
            'access_token' => $accessToken,
            'inter_face_ext' => '',
          );
        Curl::setConfig($params);
        $res = Curl::sendRequest($interFace, $params);
        if($res)
        {
            return json_decode($res, TRUE);
        }
        return FALSE;
    }
}
