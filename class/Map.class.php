<?php
class Map {
	public static function getMonster($map_id) {
		if (!$map_config = Map_Config::getMapConfig($map_id)) {
			throw new Exception('map not exists');
		}
		return array(
			'map_id'        => $map_id,
			'race_id'       => $map_config['map_race_id'],
			'level'         => mt_rand($map_config['start_level'], $map_config['end_level']),
			'monster_id'    => array_rand($map_config['monsters']),
			'prefix'        => PerRand::getRandResultKey(Monster_PrefixConfig::monsterPrefixRateList()),
			'suffix'        => PerRand::getRandResultKey(Monster_SuffixConfig::monsterSuffixRateList()),
		);
	}
}
