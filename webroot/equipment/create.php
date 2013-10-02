<?php
//创建装备
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(2047);
$r = Equip_Create::createEquip(Equip::EQUIP_TYPE_ARMS, Equip::EQUIP_COLOUR_ORANGE, Equip::EQUIP_QUALITY_HOLY, 1);
//var_dump($r);
