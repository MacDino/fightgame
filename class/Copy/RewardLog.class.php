<?php
class Copy_RewardLog{

	const TABLE_NAME = "copies_reward_log";

	public static function insert($data){
		if(!$data || !is_array($data))return FALSE;
        $res = MySql::insert(self::TABLE_NAME,
              array(
                  'copy_id'    	 => $data['copy_id'],
                  'level_id'     => $data['level_id'],
                  'type' 		 => $data['type'],
                  'num'    	 	 => $data['num'],
                  'ctime'    	 => time(),
				  'equip_id'     => $data['equip_id'],
				  'user_id'		 => $data['user_id'],
                ), TRUE);
		return $res;		
	}
	
	public static function count ($where){
		$res = MySql::selectCount(self::TABLE_NAME, $where);	
		return $res;
	}

	/*
	 * 获取列表 
	 */
	public static function getList($where){
		if(empty($where)) {
			return '';
		}
		$res = MySql::select(self::TABLE_NAME, $where);
		return $res;
	}

	public static function getCountGroupByType ($userId, $copyId, $levelId = 0){
		$sql = "select sum(num) as sum,type from ".self::TABLE_NAME." where user_id=$userId and copy_id=$copyId and level_id=$levelId group by type";
		$res = MySql::query($sql);
		return $res;
	}
}
