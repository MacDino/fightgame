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

	/*
	 * 宝箱类普通、精品定义
	 */
	public static $treasure_box_package = array(
		//普通
		array(
			array(
				'id' 	=> 10,
				'level' => 30,
			),
			array(
				'id' 	=> 12,
				'level' => 40,
			),
			array(
				'id' 	=> 14,
				'level' => 50,
			),
			array(
				'id' 	=> 16,
				'level' => 60,
			),
			array(
				'id' 	=> 18,
				'level' => 70,
			),
			array(
				'id' 	=> 20,
				'level' => 80,
			),
			array(
				'id' 	=> 22,
				'level' => 90,
			),
			array(
				'id' 	=> 24,
				'level' => 100,
			),
		),		
		//精品
		array(
			array(
				'id' 	=> 11,
				'level' => 30,
			),
			array(
				'id' 	=> 13,
				'level' => 40,
			),
			array(
				'id' 	=> 15,
				'level' => 50,
			),
			array(
				'id' 	=> 17,
				'level' => 60,
			),
			array(
				'id' 	=> 19,
				'level' => 70,
			),
			array(
				'id' 	=> 21,
				'level' => 80,
			),
			array(
				'id' 	=> 23,
				'level' => 90,
			),
			array(
				'id' 	=> 25,
				'level' => 100,
			),
			
		),
	);

}
