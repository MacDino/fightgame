<?php
/**
 * @desc 军团对打
 * @param group1 = array(user1,user2,...)
 * @param group2 = array(user1,user2,...)
 */
include $_SERVER['DOCUMENT_ROOT'].'/../init.inc.php';

$group1          = isset($_REQUEST['group1']) ? $_REQUEST['group1'] : array();
$group2          = isset($_REQUEST['group2']) ? $_REQUEST['group2'] : array();
if(empty($group1) || empty($group2)){
    $msg    = '参战双方人数不足';
    $code   = 1;
    exit;
}
$group1_fight   = array();
$group2_fight   = array();
$group1_user_info   = array();
$group2_user_info   = array();
//发起方fight对象
foreach($group1 as $v){
    $user_info      = User_Info::getUserInfoByUserId($v);
    $group1_fight[] = User_Info::fightable($v, $user_info['user_level']);
    $group1_user_info[] = $user_info;
}
//
foreach($group2 as $v){
    $user_info      = User_Info::getUserInfoByUserId($v);
    $group2_fight[] = User_Info::fightable($v, $user_info['user_level']);
    $group2_user_info[] = $user_info;
}

$data   = array();
try {
    //被打死角色
    $dead_list  = '';
    //未死角色
    $win_list   = '';
    $group1_win = 0;
    $group2_win = 0;
    $fight_procedure = Fight::multiStart($group1_fight, $group2_fight);
    foreach($group1_fight as $k => $obj){
        if($obj->is_Dead()){
            $dead_list  .= $group1_user_info[$k]['user_name'].',';
        } else {
            $win_list   .= $group1_user_info[$k]['user_name'].',';
            $group1_win ++;
        }
    }
    foreach($group2_fight as $k => $obj){
        if($obj->is_Dead()){
            $dead_list  .= $group2_user_info[$k]['user_name'].',';
        } else {
            $win_list   .= $group2_user_info[$k]['user_name'].',';
            $group2_win ++;
        }
    }
    $data   = array(
		'fight_procedure' => $fight_procedure,
        'dead'  => rtrim($dead_list, ','),
        'win'   => rtrim($win_list, ',')
    );
    
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '攻击操作失败';
}

