<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

echo "<pre>";
$mapList = Map_Config::getMapList();
$skillInfos = Skill::skillListWLGJ()+Skill::skillListFSGJ()+Skill::skillListFYJN()+ Skill::skillListBDJN();
//var_dump($skillInfos);
?>
<style>
    table td {
        border-bottom: 1px #CCCCCC dashed;
        padding: 5px;
    }
</style>
<table width="100%">
    <tr>
        <th>地图名称</th>
        <th>设置此地图怪物可使用的技能</th>
        <th>操作</th>
    </tr>
    <?php 
foreach ($mapList as $mapInfo) {
    $thisMapSkill = Map_Skill::getAllSkills($mapInfo['map_id']);
    $suffixMustHave = Map_Skill::getAllSuffixMustHave($mapInfo['map_id']);
    $suffixMinNum = Map_Skill::getSuffixMinCount($mapInfo['map_id']);
    ?>
    <tr>
        <td><?php echo $mapInfo['map_name']?></td>
        <td>
            <?php
            echoSkillInfo($thisMapSkill, $skillInfos);
            ?>
        </td>
        <td>
            <a href="set.php?map_id=<?php echo $mapInfo['map_id'];?>">详细设置</a>
        </td>
    </tr>
    <?php
}

function echoSkillInfo($thisMapSkill, $skillInfos) {
    foreach ((array)$thisMapSkill as $skillKey => $skillValue) {
        if($skillKey == 'attack') {
            echo "攻击技能：";
            foreach ((array)$skillValue as $skillId) {
                echo $skillInfos[$skillId]."&nbsp;";
            }
        }elseif($skillKey == 'defense') {
            echo "防御技能：";
            foreach ((array)$skillValue as $skillId) {
                echo $skillInfos[$skillId]."&nbsp;";
            }
        }elseif($skillKey == 'passive') {
            echo "被动技能：";
            foreach ((array)$skillValue as $skillId) {
                echo $skillInfos[$skillId]."&nbsp;";
            }
        }
        echo "<br />";
    }
    echo '&nbsp';
}
    ?>
</table>