<?php
class Props_Config{

	const KEY_PROPS = 1;
	const KEY_INGOT = 2;
	/*
	 * 欢乐月道具元宝套餐赠送包
	 */
	public static $month_package = array(
		self::PROPS => array(
			array(
				'id' 	=> 1,
				'num'	=> 4,
			),
			array(
				'id' 	=> 2,
				'num'	=> 5,
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
		self::INGOT => 100 ,
	);

	public static $props = array(
		array(
			
		)	
	);
}
