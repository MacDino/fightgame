<?php

include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo "<pre>";
$mapId = $_REQUEST['map_id'] > 0 ? $_REQUEST['map_id'] : '';
if($mapId > 0) {
    $mapInfo = Map_Config::getOneByMapId($mapId);
    $skillGj = Skill::skillListWLGJ() + Skill::skillListFSGJ();
    $skillFy = Skill::skillListFYJN();
    $skillBd = Skill::skillListBDJN();
    $mapSkillsHave = Map_Skill::getAllSkills($mapId);
    $suffixMinNum = Map_Skill::getSuffixMinCount($mapId);
}


?>
<style>
    table td {
        border-bottom: 1px #CCCCCC dashed;
        padding: 5px;
    }
</style>
<table>
    <tr>
        <td>地图id：<?php echo $mapInfo['map_id'];?></td>
        <td>地图名称：<?php echo $mapInfo['map_name'];?></td>
        <td>地图怪物等级：<?php echo $mapInfo['start_level'].'--'.$mapInfo['end_level'];?></td>
    </tr>
</table>
<form action="deal.php" method="POST">
    <input type="hidden" name="map_id" value="<?php echo $mapId;?>" />
    <table>
        <tr>
        <td>请设置地图怪物可使用技能：</td>
            <td>
                攻击技能
                <?php
                foreach ($skillGj as $gjId => $gjTitle) {
                    $strgj = '<input type="checkbox" name="skillGj[]" ';
                    if($gjId > 0 && in_array($gjId, (array)$mapSkillsHave['attack'])) {
                        $strgj .= ' checked="checked" ';
                    }
                    $strgj .= 'value="'.$gjId.'" />'.$gjTitle;
                    echo $strgj;
                }
                ?>
                <br />
                防御技能
                <?php
                foreach ($skillFy as $fyId => $fyTitle) {
                    $strFy = '<input type="checkbox" name="skillFy[]" ';
                    if($fyId > 0 && in_array($fyId, (array)$mapSkillsHave['defense'])) {
                        $strFy .= ' checked="checked" ';
                    }
                    $strFy .= 'value="'.$fyId.'" />'.$fyTitle;
                    echo $strFy;
                }
                ?>
                <br />
                被动技能
                <?php
                foreach ($skillBd as $bdId => $bdTitle) {
                    $strBd = '<input type="checkbox" name="skillBd[]" ';
                    if($bdId > 0 && in_array($bdId, (array)$mapSkillsHave['passive'])) {
                        $strBd .= ' checked="checked" ';
                    }
                    $strBd .= 'value="'.$bdId.'" />'.$bdTitle;
                    echo $strBd;
                }
                ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <?php 
        foreach (getSuffix() as $suffixId => $suffixName) {
            $suffixMustHave = Map_Skill::getSuffixMustHave($mapId, $suffixId);
        ?>
        <tr>
            <td>请设置后缀&nbsp;<?php echo $suffixName;?>&nbsp;必须有的技能：</td>
            <td>
                攻击技能
                <?php
                foreach ($mapSkillsHave['attack'] as $gjId) {
                    $strgj = '<input type="checkbox" name="'.$suffixId.'_skillMustGj[]" ';
                    if($gjId > 0 && in_array($gjId, (array)$suffixMustHave['attack'])) {
                        $strgj .= ' checked="checked" ';
                    }
                    $strgj .= 'value="'.$gjId.'" />'.$skillGj[$gjId];
                    echo $strgj;
                }
                ?>
                <br />
                防御技能
                <?php
                foreach ($mapSkillsHave['defense'] as $fyId) {
                    $strFy = '<input type="checkbox" name="'.$suffixId.'_skillMustFy[]" ';
                    if($fyId > 0 && in_array($fyId, (array)$suffixMustHave['defense'])) {
                        $strFy .= ' checked="checked" ';
                    }
                    $strFy .= 'value="'.$fyId.'" />'.$skillFy[$fyId];
                    echo $strFy;
                }
                ?>
                <br />
                被动技能
                <?php
                foreach ($mapSkillsHave['passive'] as $bdId) {
                    $strBd = '<input type="checkbox" name="'.$suffixId.'_skillMustBd[]" ';
                    if($bdId > 0 && in_array($bdId, (array)$suffixMustHave['passive'])) {
                        $strBd .= ' checked="checked" ';
                    }
                    $strBd .= 'value="'.$bdId.'" />'.$skillBd[$bdId];
                    echo $strBd;
                }
                ?>
            </td>
            <td>
                最少<input type="text" name="<?php echo $suffixId;?>_attackMinNum" size="5" value="<?php echo $suffixMinNum['attack'][$suffixId];?>"  />个<br/>
                最少<input type="text" name="<?php echo $suffixId;?>_defenseMinNum" size="5" value="<?php echo $suffixMinNum['defense'][$suffixId];?>"  />个<br/>
                最少<input type="text" name="<?php echo $suffixId;?>_passiveMinNum" size="5" value="<?php echo $suffixMinNum['passive'][$suffixId];?>"  />个<br/>
            </td>
        </tr>
        <?php 
        }
        ?>
        <tr>
            <td colspan="3">
                <input type="submit" value="提交" />
            </td>
        </tr>
    </table>

</form>

<?php
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