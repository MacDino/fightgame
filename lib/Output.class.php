<?php
class Output {
    
    public static function generalOutPut()
    {   
        global $code, $data, $doNotPut;
        if($doNotPut)return;
        $code   = intval ( $code );
        echo self::outputJson ( $code, $data );
        return true;
    }   
 
    private static function outputJson($code, $data)
    {   
        $array = array(
            'c'  => $code,
            'd'  => $data,
        );  
        return json_encode($array);
    }   
}
