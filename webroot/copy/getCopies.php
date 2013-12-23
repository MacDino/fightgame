<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
$userId = $_REQUEST['user_id'] ? $_REQUEST['user_id'] : 0;

$copies = Copy::getCopyList();

foreach ($copies as $k => $v){
	if($v['copies_id'] == 1) {
		//先临时隐掉
		unset($copies[$k]);
		continue;	
	}
	$fightRes = Copy_FightResult::getResult($userId, 0, $v['copies_id'],date("Y-m-d", time()));
	$copies[$k]['win_monster_num'] = $fightRes['win_monster_num'] ? $fightRes['win_monster_num'] : 0;
	$copyId = $v['copies_id'];
	$count = Copy::getFightNum($userId, "copy_".$copyId);
	$copies[$k]['residue_degree'] = $count['is_free'];
}
sort($copies);
$data = $copies;
