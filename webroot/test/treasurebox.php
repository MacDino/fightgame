<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$treasureBoxId = Props_Info::getTreasureBoxPropsId();
print_r($treasureBoxId);


$userProps = User_Property::initTreasureBox(39);
