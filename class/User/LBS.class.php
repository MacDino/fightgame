<?php
//坐标
class User_LBS
{
	CONST TABLE_NAME = 'user_lbs';
	
	/** @desc 记录用户坐标 */
	public static function recordLBS($userId, $longitude, $latitude){
		 $last_login_time = time();
		 $sql = "REPLACE INTO " . self::TABLE_NAME . " (user_id, longitude, latitude, last_login_time) VALUES('$userId', '$longitude', '$latitude', '$last_login_time')";
//		 echo $sql;
		 $res = MySql::query($sql);
		 return $res;
	}
	
	/** @desc 根据userid查询坐标 */
	public static function getLBSByUserId($userId){
		$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
		return $res;
	}
	
	/**
	 * @desc 根据自身经纬度获取附近用户
	 * @param int $userId
	 * @param int $lng
	 * @param int $lat
	 */
	public static function getNearbyFriend($userId, $distance = 1000)
	{
		$userLbs = self::getLBSByUserId($userId);
//		print_r($userLbs);
		$lng = $userLbs['longitude'];
		$lng = 116.417300;//假数据
		$lat = $userLbs['latitude'];
		$lat = 39.941400;//假数据
		//简单检测
		if(!$userId || !$lng || !$lat)	return FALSE;

		$_array = LBS::delta_lng_lat($lng, $lat, $distance);
		$min_lng = $_array[0];
		$max_lng = $_array[1];
		$min_lat = $_array[2];
		$max_lat = $_array[3];

		$sql = "SELECT i.user_id as user_id, i.user_name as user_name, i.race_id as race_id, i.user_level as user_level, l.longitude as longitude, l.latitude as latitude
            FROM user_info i ,user_lbs l WHERE longitude<=$max_lng AND longitude>=$min_lng AND latitude<=$max_lat AND latitude>=$min_lat
            AND i.user_id!=$userId and i.user_id = l.user_id";
//		echo $sql;
		$res = MySql::query($sql);
		return $res;
	}
	
	/** @desc 根据坐标计算距离 */
	private static function GetDistance($lat1, $lng1, $lat2, $lng2){
		$radLat1=deg2rad($lat1);
//		echo $radLat1."<br>";
		$radLat2=deg2rad($lat2);
		$radLng1=deg2rad($lng1);
		$radLng2=deg2rad($lng2);
		$a=$radLat1-$radLat2;//两纬度之差,纬度<90
		
		$b=$radLng1-$radLng2;//两经度之差纬度<180
//		echo $a."++";
//		echo $b."<br>";
		$s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137;
//		echo ceil($s)."<br>";
		return ceil($s);
	}
	
	/** @desc 把取出来的用户计算出距离,并且按从近到远排序 */
	public static function getNearUser($data, $userId){
		$userLbs = self::getLBSByUserId($userId);
		$lng = $userLbs['longitude'];
		$lat = $userLbs['latitude'];
		
		if(!empty($data)){
			foreach ($data as $key=>$i){//给每个用户加上距离字段,单位是米
				$distance = self::GetDistance($lat, $lng, $i['latitude'], $i['longitude']);
				$data[$key]['distance'] = $distance;
				$res[$key] = $distance;
			}
		}
		
		asort($res, SORT_NUMERIC);//排序
		foreach ($res as $a=>$b){
			$result[] = $data[$a];
		}

		return $result;
	}
	
}