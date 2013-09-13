<?php
/**
 * 进行战斗或者PK的战斗记录以及相关数据计算
 * review by lishengwei
 * **/
class Fight {

    const FIGHT_USE_TIME_BASE = 1;  //用户战斗耗时基础倍数：1秒
    /**
     * 进行多人对多怪的战斗
     * 可复用至单人对单怪、单人对单怪、多人对多怪
     * 或者单人对单人、单人对多人，多人对单人、对人对多人
     * @author lishengwei
     * **/
    public static function multiFight($team1, $team2) {
        $fight_procedure    = array();
		$attackers          = self::sortByAttackSpeed($team1, $team2);
        $times              = 0;
        while(self::isTeamAlive($team1) && self::isTeamAlive($team2)) {
			foreach($attackers as $attacker) {
				if ($attacker->isDead()) {
					continue;
				}
				//true 不可省略，严格检查是否是同一个对象
				if (in_array($attacker, $team1, true)) {
					$target = self::randTarget($team2);
				} else {
					$target = self::randTarget($team1);
				}
				// 没有目标了，全死光光了
				if (empty($target)) {
					break;
				}
				$harm = $attacker->attack($target);
				$fight_procedure[] = self::_report($attacker, $target, $harm);
                $times++;
			}
		}
		return array(
            'use_time' => $times * self::FIGHT_USE_TIME_BASE,
            'fight_procedure' => $fight_procedure,
        );
    }

    public static function getPeopleFightInfo(Fightable $user) {
        $userIdentity = $user->getInfo();
        return array(
            'user_id'   => $userIdentity['user_id'],
            'blood'     => $user->getCurrentBlood(),
            'magic'     => $user->getCurrentMagic(),
        );
    }

    public static function getMonsterFightInfo(Fightable $monster, $monsterInfo = array()) {
        $monsterInfo['blood'] = $monster->getCurrentBlood();
        $monsterInfo['magic'] = $monster->getCurrentMagic();
        return $monsterInfo;
    }

    //单挑
	public static function start(Fightable $user1, Fightable $user2)
	{
		//速度快者先出手
		if ($user1->speed() > $user2->speed())
		{
			return self::_start($user1, $user2);
		}

		return self::_start($user2, $user1);
	}

	//群殴
	public static function multiStart($team1, $team2)
	{
		$fight_procedure = array();
		$attackers = self::sortByAttackSpeed($team1, $team2);
		while(self::isTeamAlive($team1) && self::isTeamAlive($team2))
		{
			foreach($attackers as $attacker)
			{
				if ($attacker->isDead())
				{
					continue;
				}

				//true 不可省略，严格检查是否是同一个对象
				if (in_array($attacker, $team1, true))
				{
					$target = self::randTarget($team2);
				}
				else
				{
					$target = self::randTarget($team1);
				}

				// 没有目标了，全死光光了
				if (empty($target))
				{
					break;
				}

				$harm = $attacker->attack($target);
				$fight_procedure[] = self::_report($attacker, $target, $harm);
			}
		}
		return $fight_procedure;
	}


    /**
     * 多对多情况下，计算出手速度
     * 按攻击速度降序
     * **/
	public static function sortByAttackSpeed($team1, $team2) {
		$attackers      = array_merge($team1, $team2);
		$attack_speed   = array();
		foreach($attackers as $key => $attacker) {
			$attack_speed[$key] = $attacker->speed();
		}
		arsort($attack_speed);
		$sorted_attackers = array();
		foreach($attack_speed as $key => $speed) {
			$sorted_attackers[] = $attackers[$key];
		}
		return $sorted_attackers;
	}

	public static function isTeamAlive($team) {
		foreach($team as $member) {
			if ($member->isAlive()) {
				return true;
			}
		}
		return false;
	}

	public static function randTarget($team) {
		$target = false;
		$max_attacked_speed = 0;
		foreach ($team as $member) {
			if ($member->isDead()) {
				continue;
			}

			$attacked_speed = $member->attackedSpeed();
			if ($attacked_speed > $max_attacked_speed) {
				$max_attacked_speed = $attacked_speed;
				$target = $member;
			}
		}

		return $target;
	}

	private static function _report($attacker, $target, $harm) {
		return array(
			'attacker'  => $attacker->reportAttack(),
			'target'    => $target->reportDefense(),
			'harm'      => $harm,
		);
	}

	private static function _start($user1, $user2)
	{
		$fight_procedure = array();

		//打到死
		while($user1->isAlive() && $user2->isAlive())
		{
			$harm = $user1->attack($user2);
			$fight_procedure[] = self::_report($user1, $user2, $harm);

			if ($user1->isAlive() && $user2->isAlive())
			{
				$harm = $user2->attack($user1);
				$fight_procedure[] = self::_report($user2, $user1, $harm);
			}
		}

		return $fight_procedure;
	}
}
