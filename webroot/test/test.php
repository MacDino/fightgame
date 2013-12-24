<?php
//获取用户信息，包括用户基本信息，用户基本属性，用户成长属性
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$res = Skill_Info::equipSkill(27);
print_r($res);

$a = Skill_Info::getSkillList(27);
print_r($a);

//$b = Skill_Info::getReleaseProbability(27, 1);
//print_r($b);