<?php
class Map 
{
    public static function getMonster($map_id) {
        if (!$map_config = Map_Config::getMapConfig($map_id)) {
                throw new Exception('map not exists');
        }
        $level = mt_rand($map_config['start_level'], $map_config['end_level']);
        $aptitudeTypeId = Monster::randAptitudeType();
        $aptitude = Monster::getMonsterAptitude($map_id, $aptitudeTypeId);
        return array(
                'map_id'        => $map_id,
                'race_id'       => $map_config['map_race_id'],
                'level'         => $level,
                'monster_id'    => array_rand($map_config['monsters']),
                'prefix'        => PerRand::getRandResultKey(Monster_PrefixConfig::monsterPrefixRateList()),
                'suffix'        => PerRand::getRandResultKey(Monster_SuffixConfig::monsterSuffixRateList()),
                'grow_per'		=> Monster::getGrowPercentage($map_id),
                'aptitude_type' => $aptitudeTypeId,
                'aptitude'		=> $aptitude,
        );
    }
}
