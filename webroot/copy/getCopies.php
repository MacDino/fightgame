<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$userId = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;

$copies = Copy::getCopyList();

foreach ($copies as $k => $v){
	if($v['copies_id'] == 1) {
		continue;	
	}
	$fightRes = Copy_FightResult::getResult($userId, 0, $v['copies_id'],date("Y-m-d", time()));
	$copies[$k]['win_monster_num'] = $fightRes['win_monster_num'] ? $fightRes['win_monster_num'] : 0;
	$copies[$k]['residue_degree'] = $v['monster_num'] - $fightRes['win_monster_num'];
}
$data = $copies;
