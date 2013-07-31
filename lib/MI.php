<?php

class MI
{

    public static function loadClass($class) {
        $path = defined('PEAR') ? PEAR : '/usr/share/pear/';
    
        //try load pear class
        $name       = str_replace('_', '/',$class);
        $filename   = "$name.class.php";
        $filepath   = "$path$filename";
        if(file_exists($filepath))
	{
            return require($filepath);
	}
    }   

    /**
     * register or unregister an autoload method
     *
     * @param string $class classname
     * @param boolean $enabled
     */
    public static function registerAutoLoad($func, $enabled = true) {
        if($enabled)
	{
            spl_autoload_register($func);
	}else{
            spl_autoload_unregister($func);
	}
    }
}
