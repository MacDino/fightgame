<?php

echo strtotime(date("Y-m-d 00:00:00"));
$data = array(
	'participant' => array(
		'user' => array(
			'name' => '郑毅枫',
			'blood'=> '1000',
			'magic'=> '2222',
		),//ID,名字,血量,魔法,
		'pet' => array(
			'name' => '林子',
			'blood'=> '1000',
			'magic'=> '2222',
		),//ID,名字,血量,魔法,
		'monster' => array(
			'0' => array(
				'name' => '李伟',
				'prefix'=> '郁闷的',
				'suffix'=> 'BOSS',
				'blood'=> '1000',
				'magic'=> '2222',
			),//ID,血量,魔法,前缀,后缀
			'1' => array(
				'name' => '郝晓凯',
				'prefix'=> '凶恶的',
				'suffix'=> '队长',
				'blood'=> '1000',
				'magic'=> '2222',
			),
		),
	),
	
	'fight_procedure' => array(
		'0' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'user',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'monster[0]',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'1' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'monster[1]',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'pet',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'2' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'user',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'monster[0]',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'3' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'monster[1]',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'pet',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'4' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'user',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'monster[0]',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'5' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'monster[1]',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'pet',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'6' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'user',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'monster[0]',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'7' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'monster[1]',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'pet',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'8' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'user',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'monster[0]',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
		'9' => array(
			'skill' => '连击',//ID
		
			'attacker' => 'monster[1]',//没想好给什么方便关联,ID会重复,名字没法关联
			'target' => 'pet',
			
			'fight_content'  => array(//不管连续打几次,都这样写,
				'1' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害',//你 对 青蛙 使用了 重击 , 造成了 2700 点 伤害。
				'2' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|对|attacker|造成了|H:2700|点|伤害',//每个对象都替换成静态ID,用|隔开,如果是血就在前面加B: 伤害加 H: 类似
				'n' => 'attacker|对|target|使用了|重击|,|造成了|H:2700|点|伤害|,|target|使用了|反击|,|attacker|躲避|成功',
				
			'attacker_blood' => '900',//最终剩下的
			'attacker_magic' => '1222',//最终剩下的
			
			'target_blood' => '899',//最终剩下的
			'target_magic' => '3333',//最终剩下的
			),
		),
	),
	
	'result' => array(
		'is_success' => '1',//0失败,1成功
		'used_time' => '10',//每一个战斗过程算1秒
		'experience' => '333',
		'money' => '4444',
		'equip' => array(
			'equip_type' => 2,
			'equip_colour' => 3,
		),//只给名字和颜色即可
	),
);