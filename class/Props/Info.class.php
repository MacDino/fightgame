<?php
class Props_Info{
	
	const TABLE_NAME = "props";
	const PRICE_TYPE_STATIC　= 1;
	const PRICE_TYPE_DYNAMIC = 2;

	const TREASURE_BOX_CATE_ID = 3;	//宝箱分类id


	public static function getPropsList(){
		$res = MySql::select(self::TABLE_NAME);
		return $res;
	}
	public static function getPropsListByCateId($cateId){
		if($cateId) {
	    	$where = array(
	     		'props_cate_id' => $cateId,     
	    	);
		}
		$res = MySql::select(self::TABLE_NAME, $where);
		return $res;
	}

	public static function getCateList(){
		$res = MySql::select("props_cate");
		return $res;
	}

	/*
	 *  产品详情
	 */
	public static function getPropsInfo($propsId){
		if(!is_numeric($propsId))return FALSE;
		$res = MySql::selectOne(self::TABLE_NAME, array('props_id' => $propsId));
		return $res;
	}
	/*
	 * 获取宝箱类的道具id
	 */
	public static function getTreasureBoxPropsId(){
		$where = array(
			'props_cate_id' => self::TREASURE_BOX_CATE_ID,
		);
		$res = MySql::select(self::TABLE_NAME, $where, array('props_id'));
		return $res;
	}

}
