<?php
/**
 * @desc 人和人对打
 */
include $_SERVER['DOCUMENT_ROOT'].'/../init.inc.php';

$user1          = isset($_REQUEST['user1']) ? $_REQUEST['user1'] : 0;
$user2          = isset($_REQUEST['user2']) ? $_REQUEST['user2'] : 0;
//当前角色fight对象
$user1_info     = User_Info::getUserInfoByUserId($user1);
$user1_fight    = User_Info::fightable($user1, $user2_info['user_level']);
//角色2
$user2_info     = User_Info::getUserInfoByUserId($user2);
$user2_fight    = User_Info::fightable($user2, $user2_info['user_level']);

$data   = array();
try {
    $data['fight_procedure'] = Fight::start($user1_fight, $user2_fight);
    if($user1_fight->is_Dead()){
        //当前角色被打败的处理
        $msg    = "您被{$user2_info['user_name']}打败了";
    } else {
        //获取经验 金币
        //$data['experience'] = Monster::getMonsterBaseExperience($monster['level']);
        //$data['money']      = Monster::getMonsterBaseMoney($monster['level']);
        $msg    = "{$user2_info['user_name']}被您打败了";
    }
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '攻击操作失败';
}

