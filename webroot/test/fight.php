<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$userId = $_REQUEST['user_id'];
$mapId = $_REQUEST['map_id'];
if($userId && $mapId) {
    $params = array(
        'user_id' => $userId,
        'map_id' => $mapId,
    );
    $interface = 'fight/monster';
    $res = Curl::sendRequest($interface, $params);
    $result = json_decode($res,true);
//    echo '<pre>';
//    var_dump($result);
    $monsterInfos = Monster_Config::getList();
    foreach ($monsterInfos as $monster) {
        $monsters[$monster['monster_id']] = $monster['monster_name'];
    }
    $monsterPrefix = array(
        1 => '弱小的', 2 => '缓慢的', 3 => '普通的', 4 => '强大的', 5 => '敏捷的',
    );
    $monsterSuffix = array(
        1 => 'Boss',2 => '神圣的',3 => '未知的',4 => '进阶的',5 => '将要灭绝的',6 => '被诅咒的',7=>'远古的',8=>'头头'
    );

    $races = array(
        1=> '人族',2=> '仙族',3=> '魔族',
    );
}
if($result['c'] == 0 && is_array($result['d'])) {
    $d = $result['d'];
?>
user_id:<?php echo $userId?> blood:<?php echo $d['user']['blood'];?> magic:<?php echo $d['user']['magic'];?><br />
monster:<?php echo $monsterPrefix[$d['monster']['prefix']].'-'.$monsters[$d['monster']['monster_id']].'-'.$monsterSuffix[$d['monster']['suffix']].' blood:'.$d['monster']['blood'].' magic:'.$d['monster']['magic'].' 等级：'.$d['monster']['level'].' 种族：'.$races[$d['monster']['race_id']];?>
<br />
战斗记录：<br/>
<?php
foreach ($d['fight_procedure'] as $log) {
    $attacter   = $log['attacker']['identity']['monster_id'] > 0 ? '怪物'.$monsters[$log['attacker']['identity']['monster_id']] : '你';
    $target     = $log['target']['identity']['monster_id'] > 0 ? '怪物'.$monsters[$log['target']['identity']['monster_id']] : '你';
    $skill      = $log['attacker']['skill'] > 0 ? '技能'.$log['attacker']['skill'] : '普通攻击';
    echo $attacter.'对'.$target;
    echo '使用了'.$skill.'，';
    echo $target.'受到了'.$log['harm'].'点伤害';
    echo '<br />';
}
if($d['experience'] > 0) {
    echo $monsters[$d['monster']['monster_id']].'被你击败了，你获得了'.$d['experience'].'点经验，'.$d['money'].'金钱';
}  else {
    echo '你死了';
}
?>
<br />
<?php
}
?>