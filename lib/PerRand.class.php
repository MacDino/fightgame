<?php
//计算概率方法
class PerRand
{
	public static function getRandValue($data)
	{
		if(!is_array($data) || !$data)return FALSE;
		$ration = Utility::getChangeIntRation($data);
		$randValue = mt_rand($data[0]*$ration, $data[1]*$ration);
		return $randValue/$ration;
	}
	//多维数组随机 - 目前实现二维
	public static function getMultiRandResultKey($multArrayData)
	{
		if(!is_array($multArrayData) || !$multArrayData)return array();
		foreach ($multArrayData as $key => $value) {
			$hitList[] = self::getRandResultKey($value);
		}
		return $hitList;
	}

	public static function getRandResultKey($data)
	{
		
		if ( ! is_array($data))
		{
			return false;
		}

		$data = array_filter($data);
		if ( ! $data || array_sum($data) > 1)
		{
			return false;
		}

		$min = min($data);
		$length = strlen($min) - 1;
		$times = pow(10, $length);

		$range_from = 0;
		foreach ($data as &$value)
		{
			$value = $value * $times + $range_from;
			$range_from = $value;
		}
		unset($value);

		$rand = mt_rand(0, $times - 1);
		
		foreach ($data as $key => $value)
		{
			if ($rand < $value)
			{
				return $key;
			}
		}

		return false;
	}
}
