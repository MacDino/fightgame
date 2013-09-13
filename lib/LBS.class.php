<?php
/*
根据自己的经纬度,取出某半径下所有的其他用户信息
eg:
    $common = new common();

	$lon = "116.417384";
	$lat = "39.941462,";

    $_array = $common->delta_lng_lat($lon, $lat);  
    $min_lng = $_array[0];
    $max_lng = $_array[1];
    $min_lat = $_array[2];
    $max_lat = $_array[3];

在附近表里面查找每个用户上报上来的 经纬度 做比较，不包含自己的
WHERE longitude<=$max_lng and longitude>=$min_lng 
                  and latitude<=$max_lat and latitude>=$min_lat and user_info.userid!=$userid";

*/

define('DISTANCE',500);			//距离
define('EARTH_RADIUS',6378137);			//地球半径

class LBS {
	/*function __construct() {
		parent::__construct(NULL);
		//数据库
		$this->mysql = new SaeMysql();
		//存儲

		$this->errcode = HTTP_RETURNCODE_OK;
	}

	function __destruct() {
		parent::__destruct();
		//do something destroy
		$this->mysql->closeDb();
	}*/

//=========================get_lng_and_lat======================================//
    public function getlng($lng = 0, $lat = 0){
//    	echo $lat;exit;
        $lat_r = EARTH_RADIUS * cos($lat);
        if($lat_r == 0){
            return 0;
        }
        $angle = (180.0/M_PI) * DISTANCE/$lat_r;
        return abs($angle);
    }

    public function getlat($lng = 0, $lat = 0){
        $angle = (180.0/M_PI) * DISTANCE/EARTH_RADIUS;
        return abs($angle);
    }

    public static function delta_lng_lat($lng, $lat){

        $lngx = $this->getlng($lng, $lat);
        $latx = $this->getlat($lng, $lat);

        $min_lng = $lng - $lngx;
        $max_lng = $lng + $lngx;
        $min_lat = $lat - $latx;
        $max_lat = $lat + $latx;

        return array($min_lng, $max_lng, $min_lat, $max_lat);
    }

    private function rad($d){
        return $d * 3.1415926535898 / 180.0;
    }

//==================================check=======================================//

    function check_longitude($longitude)
    {
        $p = "/[0-9]/";
        if($longitude <0 || $longitude >180 || !preg_match($p, $longitude) || $longitude == ""){
            return INVALID_LONGITUDE_VALUE;
        }
    }
    function check_latitude($latitude)
    {
        $p = "/[0-9]/";
        if($latitude <0 || $latitude >=90 || !preg_match($p, $latitude) || $latitude == ""){
            return INVALID_LATITUDE_VALUE;
        }
    }

	function check_lon($str)
	{
		$pattern = "/^(\+|\-)(\d+)\.(\d+)$/";
		if(!preg_match($pattern, $str, $matches))
		{
			return INVALID_LONGITUDE_VALUE;
		}else{
			if($matches[2] <= 0 || $matches[2] >= 180)
			{
				return INVALID_LONGITUDE_VALUE;
			}
		}
	}
	function check_lat($str)
	{
		$pattern = "/^(\+|\-)(\d+)\.(\d+)$/";
		if(!preg_match($pattern, $str, $matches))
		{
			return INVALID_LATITUDE_VALUE;
		}else{
			if($matches[2] <= 0 || $matches[2] >= 180)
			{
				return INVALID_LATITUDE_VALUE;
			}
		}
	}
}
?>
