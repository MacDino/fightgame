<?php
class Output {
    
    public static function generalOutPut()
    {   
        global $code, $data, $msg, $doNotPut;
        if($doNotPut)return;
        $code   = intval ( $code );
        echo self::outputJson ( $code, $msg, $data );
        return true;
    }   
 
    private static function outputJson($code, $msg, $data)
    {   
        $array = array(
            'c'  => $code,
            'd'  => $data,
        );  
        return json_encode($array);
    }   
}
