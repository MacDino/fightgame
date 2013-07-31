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
		$minValue = min($data);
		while(!filter_var($minValue, FILTER_VALIDATE_INT))
		{
		  $minValue *= 10;
		  $ration *= 10;
		}
		return $ration;
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