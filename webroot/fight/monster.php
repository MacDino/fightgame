<?php
include $_SERVER['DOCUMENT_ROOT'].'/../init.inc.php';

$user_id        = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$map_id         = isset($_REQUEST['map_id']) ? $_REQUEST['map_id'] : 0;
//怪物fight对象
$monster        = Map::getMonster($map_id);
$monster_fight  = Monster::fightable($monster);

//当前角色fight对象
$fight_data     = array();
$user_info      = User_Info::getUserInfoByUserId($user_id);
//基本属性 成长属性 装备属性
$base_attr      = User_Info::getUserInfoFightAttribute($user_info['user_id']);
$skill_list     = Skill_Info::getSkill($user_info['user_id']);
//技能属性加成
$skill_attr     = Skill::getRoleAttributesWithSkill($grouth_attr, $skill_list);
$fight_skill    = Skill::getFightSkillList($skill_list);
$user_fight     = new Fightable($user_info['user_level'], $skill_attr, $fight_skill);

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

