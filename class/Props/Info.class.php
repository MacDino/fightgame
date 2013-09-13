<?php
class Props_Info{
	
	const TABLE_NAME = "props";

	public static function getPropsListByCateId($cateId){
		if(!$cateId) return false;
		$where = array(
			'cate_id' => $cateId,	
		);
		$res = MySql::select(self::TABLE_NAME, $where);
		return $res;
	}

}
