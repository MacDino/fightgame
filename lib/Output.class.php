<?php
class Output {
    const MESSAGE = '操作成功';
    
    public static function generalOutPut()
    {   
        global $code, $msg, $data;
        $code   = intval ( $code );
        $msg    = ( string ) $msg;
        if($code == 0) {
            $msg = self::MESSAGE;
        }   
        echo self::outputJson ( $code, $msg, $data );
        return true;
    }   
 
    private static function outputJson($code, $msg, $data)
    {   
        $array = array(
            'code'  => $code,
            'msg'   => $msg,
            'data'  => $data,
        );  
        return json_encode($array);
    }   
}
