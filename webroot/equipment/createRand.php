<?php
//创建随机装备
include $_SERVER['DOCUMENT_ROOT'].'/../init.inc.php';
error_reporting(2047);
$r = Equip_Create::createOneRandEquip(Equip::EQUIP_COLOUR_ORANGE, 1);
var_dump($r);
