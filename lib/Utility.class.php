<?php

class Utility
{
	public static function arrayDiffAssocRecursive($array1, $array2) {
	    $difference=array();
	    foreach($array1 as $key => $value) {
	        if( is_array($value) ) {
	            if( !isset($array2[$key]) || !is_array($array2[$key]) ) {
	                $difference[$key] = $value;
	            } else {
	                $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
	                if( !empty($new_diff) )
	                    $difference[$key] = $new_diff;
	            }
	        } else if( !array_key_exists($key,$array2) || $array2[$key] !== $value ) {
	            $difference[$key] = $value;
	        }
	    }
	    return $difference;
	}

	//获取数组全部转为INT所需要乘以的系数
	public static function getChangeIntRation($data)
	{
		$data = array_filter($data, "Utility::arrayFilterFloat");
		$max_decimals = 0;
		foreach($data as $value)
		{
			$decimals = strlen(strstr($value, '.')) - 1;
			if ($decimals > $max_decimals)
			{
				$max_decimals = $decimals;
			}
		}

		return pow(10, $max_decimals);
	}

	//去除数组中为0的值
	public static function arrayFilterFloat($value)
	{
	    if(!$value || (float)$value <= 0)
	    {
	      return;
	    }else{
	      return (float)$value;
	    }
	}

	// 以最左侧数组为基准，相乘数组中键值相同的元素
	// $a = array('a' => 1, 'b' => 2); $b = array('a' => 0.1, 'b' => 0.2);
	// Utility::arrayMultiply($a, $b) ==> array('a' => 0.1, 'b' => 0.4);
	public static function arrayMultiply()
	{
		$args = array_filter(func_get_args(), 'is_array');
		$base = array_shift($args);
		while ($args)
		{
			$multiple = array_shift($args);
			foreach($base as $key => &$value)
			{
				if (isset($multiple[$key]))
				{
					$value *= $multiple[$key];
				}
			}
		}

		return $base;
	}

	// 将一个多维数组转换为以$key的值为索引的新数组
	// $a = array(array('id' => 'a'), array('id' => 'b')); 
	// Utility::arrayAssociate($a) ==> array('a' => array('id' => 'a'), 'b' => array('id' => 'b'));
	public static function arrayAssociate($array, $key = 'id')
	{
		$ret = array();
		if ( ! is_array($array))
	   	{
			return $ret;
		}

		foreach ($array as $value) 
		{
			if (isset($value[$key]))
		   	{
				$ret[$value[$key]] = $value;
			}
		}

		return $ret;
	}
}
