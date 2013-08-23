<?php
include $_SERVER['DOCUMENT_ROOT'].'/../init.inc.php';

$user_id        = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$map_id         = isset($_REQUEST['map_id']) ? $_REQUEST['map_id'] : 0;
//怪物fight对象
$monster        = Map::getMonster($map_id);
$monster_fight  = Monster::fightable($monster);

//当前角色fight对象
$user_info      = User_Info::getUserInfoByUserId($user_id);
$user_fight     = User_Info::fightable($user_id, $user_info['user_level']);

$data   = array();
try {
    Fight::start($user_fight, $monster_fight);
    if($user_fight->is_Dead()){
        //当前角色被打败的处理
        $msg    = '您被打败了';
    } else {
        //获取经验 金币
        $data['experience'] = Monster::getMonsterBaseExperience($monster['level']);
        $data['money']      = Monster::getMonsterBaseMoney($monster['level']);
        $msg    = '怪物已消灭';
    }
	$code   = 0;
} catch (Exception $e) {
	$code   = 1;
	$msg    = '攻击操作失败';
}

