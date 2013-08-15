<?php
class Fight {

	public static function start(Fightable $user1, Fightable $user2)
	{
		//速度快者先出手
		if ($user1->speed() > $user2->speed())
		{
			return self::_start($user1, $user2);
		}

		return self::_start($user2, $user1);
	}

	private static function _start($user1, $user2)
	{
		//打到死
		while($user1->isAlive() && $user2->isAlive())
		{
			$user1->attack($user2);
			$user2->attack($user1);
		}
	}
}

