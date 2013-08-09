<?php
class Map {
	const MAP_HUA_GS = 1001;
	const MAP_CHANG_SJW = 1002;

	public static function getMonster($map_id)
	{
		if ( ! $map_config = Map_Config::getMapConfig($map_id))
		{
			throw new Exception('map not exists');
		}

		return array(
			'map' => $map_id,
			'race' => $map_config['race'],
			'level' => mt_rand($map_config['level'][0], $map_config['level'][1]),
			'type' => array_rand($map_config['monsters']),
			'prefix' => PerRand::getRandResultKey(Monster_PrefixConfig::monsterPrefixRateList()),
			'suffix' => PerRand::getRandResultKey(Monster_SuffixConfig::monsterSuffixRateList()),
		);
	}
}
