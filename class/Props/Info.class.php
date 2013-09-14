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

	/*
	 *  产品详情
	 */
	public static function getPropsInfo($propsId){
		if(!is_numeric($productId))return FALSE;
		$res = MySql::selectOne(self::TABLE_NAME, array('props_id' => $propsId));
		return $res;
	}

}
