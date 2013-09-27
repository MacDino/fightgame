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
				$harm = $attacker->doOneRound($target);
				$fight_procedure[] = self::_report($attacker, $target);
                $times++;
			}
		}
		return array(
            'use_time' => $times * self::FIGHT_USE_TIME_BASE,
            'fight_procedure' => $fight_procedure,
        );
    }

    public static function getPeopleFightInfo(Fightable $user, $userInfo = array()) {
        $userIdentity = $user->getInfo();
        return array(
            'user_id'   => $userIdentity['user_id'],
            'user_name' => $userInfo['user_name'],
            'blood'     => $user->getCurrentBlood(),
            'magic'     => $user->getCurrentMagic(),
        );
    }

    public static function getMonsterFightInfo(Fightable $monster, $monsterInfo = array()) {
        return array(
            'monster_id' => $monsterInfo['monster_id'],
            'level' => $monsterInfo['level'],
            'blood' => $monster->getCurrentBlood(),
            'magic' => $monster->getCurrentMagic(),
            'prefix' => $monsterInfo['prefix'],
            'suffix' => $monsterInfo['suffix'],
        );
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

	private static function _report(Fightable $attacker, Fightable $target) {
		$attackInfo = $attacker->reportAttack();
        $targetInfo = $target->reportDefense();
        $info = array_merge($attackInfo, $targetInfo);
        $info['fight_content'] = self::translateFightResult($info);
        $info['attacker_blood'] = intval($info['attacker_blood']);
        $info['attacker_magic'] = intval($info['attacker_magic']);
        $info['target_blood'] = intval($info['target_blood']);
        $info['target_magic'] = intval($info['target_magic']);
        unset($info['attack_indentity']);
        unset($info['target_indentity']);
        unset($info['fight']);
        return $info;
	}

    private static function translateFightResult($fightInfo) {
        $attackCode    = 'attacker';
        $targetCode    = 'target';
        if($fightInfo['status'] == 1) {
            //[攻击者] 处于 练级 虚弱 状态，休息 一 回合
            $res = $attackCode.'|'.ConfigDefine::CHUYU.'|'.ConfigDefine::XURUO.'|'.ConfigDefine::ZHUANGTAI.'|'.ConfigDefine::XIXIU.'|1|'.ConfigDefine::HUIHE;
            return array($res);
        }
        //[攻击者] 对 [目标] 使用了 xx
        $codes         = $attackCode.'|'.ConfigDefine::VS.'|'.$targetCode.'|'.ConfigDefine::SHIYONG.'|'.$fightInfo['skill'].'|';

        $isMultiAttack = (count($fightInfo['fight']) > 1) ? TRUE : FALSE;
        foreach ($fightInfo['fight'] as $k => $item) {
            if($isMultiAttack) {
                //第i次攻击
                if($k == 0) {
                    $return[] = trim($codes, '|');
                }
                $codes = ConfigDefine::DI.'|N:'.($k + 1).'|'.ConfigDefine::GONGJI;
            }
            $codes .= '|'.self::getFightCode($item, $attackCode, $targetCode);
            $return[] = $codes;
        }
        return $return;
    }

    private static function getObjCode($indentity) {
        return $indentity['marking'];
        return $ret;
    }

    private static function getFightCode($item, $attackCode, $targetCode) {
        $item['harm'] = intval($item['harm']);
        $codes = '';
        if($item['is_miss']) {
            //[目标] 躲避 成功，攻击 miss
            $codes .= $targetCode.'|'.ConfigDefine::DUOBI.'|'.ConfigDefine::CHENGGONG.'|'.ConfigDefine::GONGJI.'|'.ConfigDefine::MISS;
        }  elseif($item['fy_skill'] > 0 && $item['fy_skill'] != ConfigDefine::SKILL_FJ) {
            //对象 使用了 [防御]，造成了 xx点 伤害
            $codes .= $targetCode.'|'.ConfigDefine::SHIYONG.'|'.$item['fy_skill'].'|'.ConfigDefine::ZAOCHENG.'|H:'.$item['harm'].'|'.ConfigDefine::SHANGHAI;
        }  elseif ($item['fy_skill'] > 0 && $item['fy_skill'] == ConfigDefine::SKILL_FJ) {
            //造成了 xx点 伤害，[目标] 使用了 [反击]
            $codes .= ConfigDefine::ZAOCHENG.'|H:'.$item['harm'].'|'.$targetCode.'|'.ConfigDefine::SHIYONG.'|'.$item['fy_skill'].'|';
            //对 [攻击者] 造成了 xx点 伤害
            $codes .= ConfigDefine::VS.'|'.$attackCode.'|'.ConfigDefine::ZAOCHENG.'|H:'.$item['fj_harm'].'|'.ConfigDefine::SHANGHAI;
        }  elseif($item['is_bj']) {
            //造成了 暴击 xxx点 伤害
            $codes .= ConfigDefine::ZAOCHENG.'|'.ConfigDefine::BAOJI.'|H:'.$item['harm'].'|'.ConfigDefine::SHANGHAI;
        }  else {
            //造成了 xx点 伤害
            $codes .= ConfigDefine::ZAOCHENG.'|H:'.$item['harm'].'|'.ConfigDefine::SHANGHAI;
        }
        return $codes;
    }

    /**
     * @desc 根据user_id生成战斗对象
     */
    public static function createUserFightable($user_id, $user_level,$marking = '', $isHelpfull = FALSE, $isHarmfull = FALSE) {
        $skill_list     = Skill_Info::getSkillList($user_id);
        $attrbuteArr    = User_Info::getUserInfoFightAttribute($user_id, TRUE);

        $fight_skill    = Skill::getFightSkillList($skill_list);
        return new Fightable($user_level, $attrbuteArr, $fight_skill, array('user_id' => $user_id, 'marking' => $marking));
    }

    /**
     * 生成一个怪物的战斗对象
     * 此时的怪物跟用户类似但
     * 计算的属性加成点是自己进行计算的
     * 并未跟用户那块的加成计算在一起。
     * **/
	public static function createMonsterFightable($monster, $marking = '') {
		$skill      = Monster::getMonsterSkill($monster);
		$attribute  = Monster::getMonsterAttribute($monster);
		//技能加成后的属性
		$attribute  = Monster::attributeWithSkill($attribute, $skill, $monster);
		return new Fightable($monster['level'], $attribute, $skill, array('monster_id' => $monster['monster_id'],'marking' => $marking));
	}

    public static function calculateHelpAndHarmfull($userRaceId, $petRaceId, $targetRaceId) {
        $return['user'] = array(
            'helpfull' => self::isHelpfull($userRaceId, $petRaceId),
            'harmfull' => self::isHarmfull($userRaceId, $targetRaceId),
        );
        return $return;
    }

    //同队的种族
    public static function isHelpfull($raceId, $teamRaceId) {
        $helpfullRaceMatch = array(
            User_Race::RACE_HUMAN       => User_Race::RACE_TSIMSHIAN,       //人生仙 即 同队的种族是人，对应与我的种族是仙族。有益，下同
            User_Race::RACE_TSIMSHIAN   => User_Race::RACE_DEMON,           //仙生魔
            User_Race::RACE_DEMON       => User_Race::RACE_HUMAN            //魔生人
        );
        if($helpfullRaceMatch[$teamRaceId] == $raceId) {
            return TRUE;
        }
        return FALSE;
    }

    //异队的种族
    public static function isHarmfull($raceId, $targetRaceId) {
        $harmfullRaceMatch = array(
            User_Race::RACE_HUMAN       => User_Race::RACE_DEMON,           //人克魔 即 异队的种族是人，对应与我的种族是魔族。有害，下同
            User_Race::RACE_DEMON       => User_Race::RACE_TSIMSHIAN,       //魔克仙
            User_Race::RACE_TSIMSHIAN   => User_Race::RACE_HUMAN            //仙克人
        );
        if($harmfullRaceMatch[$targetRaceId] == $raceId) {
            return TRUE;
        }
        return FALSE;
    }
}
