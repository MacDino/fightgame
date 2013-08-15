<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$a = 10000;

$b = $a * (1 - USER::ATTEIBUTEENHANCE );
echo $b;
