<?php
require($_SERVER['DOCUMENT_ROOT'] . '/../config/config.inc.php');
require LIB.'MI.php';
#autoload函数
if(!function_exists('autoload_sae')) 
{
    function autoload_sae($className) 
    {
        $fileName = str_replace('_', '/',$className) . '.class.php';
        $filePath = LIB . $fileName;
        if(file_exists($filePath)) 
        {
            return require($filePath);
        }   
        $filePath = CLS . $fileName;
        if(file_exists($filePath)) 
        {
            return require($filePath);
        }   
    }                                                                                
}
                                                                              
MI::registerAutoload('autoload_sae');
MI::registerAutoload(array('MI', 'loadClass'));

register_shutdown_function(array("Output", "generalOutPut"));
