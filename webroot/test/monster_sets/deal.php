<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo "<pre>";
$mapId = $_POST['map_id'] > 0 ? $_POST['map_id'] : 0;
if($mapId <= 0) {
    echo "未知地图";
    exit();
}
try{
    Map_Skill::saveMapSkill($mapId, $_POST['skillGj'], 'attack');
    Map_Skill::saveMapSkill($mapId, $_POST['skillFy'], 'defense');
    Map_Skill::saveMapSkill($mapId, $_POST['skillBd'], 'passive');
    foreach (getSuffix() as $suffixId => $suffixName) {
        $mustSkill = array();
        $mustSkill['attack'] = $_POST[$suffixId.'_skillMustGj'];
        $mustSkill['defense'] = $_POST[$suffixId.'_skillMustFy'];
        $mustSkill['passive'] = $_POST[$suffixId.'_skillMustBd'];
        Map_Skill::saveSuffixMustHave($mapId, $suffixId, $mustSkill);
        $suffixMinNum['attack']['suffix'][$suffixId] = $_POST[$suffixId.'_attackMinNum'] > 0 ? $_POST[$suffixId.'_attackMinNum'] : 0;
        $suffixMinNum['defense']['suffix'][$suffixId] = $_POST[$suffixId.'_defenseMinNum'] > 0 ? $_POST[$suffixId.'_defenseMinNum'] : 0;
        $suffixMinNum['passive']['suffix'][$suffixId] = $_POST[$suffixId.'_passiveMinNum'] > 0 ? $_POST[$suffixId.'_passiveMinNum'] : 0;
    }
    Map_Skill::saveSuffixMinNum($mapId, $suffixMinNum);
    echo "设置成功";
    echo '<a href="list.php">返回列表</a>';
    echo '<br/>';
}  catch (Exception $e) {
    echo '发生错误，错误信息为：'.$e->getMessage();
}

function getSuffix() {
    return array(
        Monster::MONSTER_SUFFIX_BOSS         => 'Boss',
        Monster::MONSTER_SUFFIX_SACRED       => '圣灵',
        Monster::MONSTER_SUFFIX_UNKNOWN      => '领主',
        Monster::MONSTER_SUFFIX_ADVANCED     => '巨魔',
        Monster::MONSTER_SUFFIX_WILL_EXTINCT => '将领',
        Monster::MONSTER_SUFFIX_CURSED       => '魔王',
        Monster::MONSTER_SUFFIX_ANCIENT      => '长老',
        Monster::MONSTER_SUFFIX_HEAD         => '头头',
    );
}
?>
