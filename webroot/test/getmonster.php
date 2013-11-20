<?php
include $_SERVER['DOCUMENT_ROOT'].'/init.inc.php';
error_reporting(0);
$doNotPut = TRUE;
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';


$mapId = isset($_REQUEST['map_id'])?$_REQUEST['map_id']:12;
echo '<pre>';


$configDefineList = ConfigDefine::skillList();
$configDefineList += ConfigDefine::titleList();
$configDefineList += ConfigDefine::equipList();
$configDefineList += ConfigDefine::AttributeList();
$configDefineList += ConfigDefine::aptitudeTypeList();
$configDefineList += ConfigDefine::aptitudeList();


$mapList = Version::getMapList();
foreach($mapList as $mapInfo)
{
	if($mapInfo['id'] == $mapId)
	{
		echoStr('当前所在地图ID为', $mapId);
		echoStr('当前所在地图为', $mapInfo['name']);
	}
}

$res = Map::getMonster($mapId);

$raceList = User_Race::getRaceList();
foreach ($raceList as $raceId => $raceName) {
	if($raceId == $res['race_id'])
	{
		echoStr('当前怪物种族ID为', $raceId);
		echoStr('当前怪物种族为', $raceName);
	}
}

echoStr('当前怪物ID为', $res['monster_id']);
$monsterList = Version::getMonsterList();
foreach($monsterList as $monsterInfo)
{
	if($monsterInfo['id'] == $res['monster_id'])
	{
		echoStr('当前怪物为', $monsterInfo['name']);
	}
}
echoStr('当前怪物前缀ID为', $res['prefix']);
echoStr('当前怪物前缀为', $configDefineList[$res['prefix']]);
echoStr('当前怪物后缀ID为', $res['suffix']);
echoStr('当前怪物后缀为', $configDefineList[$res['suffix']]);
echoStr('当前怪物成长率为', $res['grow_per']);
echoStr('当前怪物资质类型为', $configDefineList[$res['aptitude_type']]);



function echoStr($str, $str1)
{
	echo $str.'：'.$str1."<br />";
}
echoStr('当前怪物等级为', $res['level']);

//$monsterFightTeam = Fight::createMonsterFightable($res);
$monsterFightTeam = NewFight::createMonsterObj($monster);

//echoStr('当前怪物血量为', $monsterFightTeam->getCurrentBlood());
//echoStr('当前怪物魔法值为', $monsterFightTeam->getCurrentMagic());


//$attributesList = $monsterFightTeam->getAttributes();
$attributesList = Monster::getMonsterAttribute($res);
foreach($attributesList as $attributeId => $value)
{
	echoStr('当前属性ID为', $attributeId);
	echoStr('当前属性为', $configDefineList[$attributeId]);
	echoStr('当前属性值为', $value);
	echo "</p>";
}

echo '</pre>';
