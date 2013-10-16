<?php
class Props_Log{
	
	const TABLE_NAME = "user_props_log";
	const ACTION_TYPE_BUY = 1;
	const ACTION_TYPE_USE = 2;

	public static function insert($data){
		if(!$data || !is_array($data))return FALSE;
        $res = MySql::insert(self::TABLE_NAME,
              array(
                  'props_id'    	 => $data['props_id'],
                  'user_id'       	 => $data['user_id'],
                  'num'				 => $data['num'],
                  'type'			 => $data['type'],
                  'ctime'    	 	 => date("Y-m-d H:i:s", time()),
                ), TRUE);
		return $res;		
	}
	
	public static function getPropsList($where){
		$res = MySql::select(self::TABLE_NAME, $where);
		return $res;
	}

	public static function getTodayUseNum($userId, $propsId){
		$today = date('Y-m-d', time());
		$sql = "SELECT SUM(num) as sum FROM ".self::TABLE_NAME." WHERE user_id=".$userId." AND props_id=".$propsId." AND ctime LIKE '%".$today."%'";
		$res = MySql::query($sql);
		return $res[0]['sum'];
	}
}
