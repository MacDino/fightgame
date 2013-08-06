<?php

class CheckValue
{
    //检查是否为正整数
    public static function isInt($value)
    {
        if(is_numeric($value) && (int)$value == $value)
        {
            return TRUE; 
        }
        return FALSE;
    }
    
}
