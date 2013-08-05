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

	//获取数组全部转为INT所需要乘以的系统
	public static function getChangeIntRation($data)
	{
		$ration = 1;
		if(!$data || !is_array($data))return $ration;
		$data = array_filter($data, 'self::arrayFilterFloat');
		$ration = 1;
		foreach ($data as $value) {
			if(!filter_var($value*$ration, FILTER_VALIDATE_INT))
			{
				$valueLen = strlen($value);
				$ration = $valueLen-1;	
			}else{
				continue;
			}
		}
		return (int)str_pad(1, $ration, 0);
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
}