<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';


$userId = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';

$data = array(
    'new_equip' => false,
    'new_skill' => false,
    'new_reward' => false,
);

if($userId)
{
    $data['new_equip'] = Equip_Info::isHaveNew($userId);
    $data['new_skill'] = NewSkillStudy::isSkill($userId);
    $data['new_reward'] = Reward::isReward($userId);
    //Counter::remove($newEquipKey);
}
