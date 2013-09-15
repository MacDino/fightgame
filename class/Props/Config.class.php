<?php
class Props_Config{

	const KEY_PROPS = 1;
	const KEY_INGOT = 2;
	/*
	 * 欢乐月道具元宝套餐赠送包
	 */
	public static $month_package = array(
		self::KEY_PROPS => array(
			array(
				'id' 	=> 1,
				'num'	=> 4,
			),
			array(				//pk咒符入user_info表
				'id' 	=> 2,
				'num'	=> 5,
				'is_pk' => 1,
			),
			array(
				'id' 	=> 3,
				'num'	=> 4,
			),
			array(
				'id' 	=> 6,
				'num'	=> 4,
			),
		),
		self::KEY_INGOT => 100 ,
	);


	/*
	 * 装备成长符价格表
	 * key : user level
	 * value : price
	 */
	public static $equip_grow_price = array(
		30 => 2000,
		40 => 3000,
		50 => 4000,
		60 => 5000,		
		70 => 6000,
		80 => 7000,
		90 => 8000,
	); 

}
