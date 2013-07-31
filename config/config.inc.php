<?php
//本项目根目录
define('ROOT', dirname(__FILE__) . '/../');
define('LIB', ROOT . 'lib/');
define('CLS', ROOT . 'class/');
define('PEAR' , LIB);


if($_SERVER['SERVER_NAME'] == 'fightgame.sinaapp.com')
{
    define('DEVELOPER', FALSE);
}else{
    define('DEVELOPER', TRUE);
}

if(DEVELOPER)
{
    $MYSQL_CONFIG = array(
        'default' => array(
            'db_host' => 'localhost',
            'db_user' => 'root',
            'db_passwd' => '', 
            'db_name' => 'app_fightgame',
            'db_port' => 3306,
        ),  
    );
}else{
    $MYSQL_CONFIG = array(
        'default' => array(
            'db_host' => SAE_MYSQL_HOST_M,
            'db_user' => SAE_MYSQL_USER,
            'db_passwd' => SAE_MYSQL_PASS, 
            'db_name' => SAE_MYSQL_DB,
            'db_port' => SAE_MYSQL_PORT,
        ),  
    );
}
