<?php
//技能输出
class Skill_Output
{
    //普通攻击
    public static function ptSkill($userData)
    {
        $ret['is_double'] = 0;
        $averageUserLevel = Skill_Common::rand5UserLevelGetTop3Average($userData['user_level']);
        $ratioValue = Skill_Common::ratioValue();
        if($ratioValue == 2)$ret['is_double'] = 1;
        $userAttributeHit = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HIT];
        $userAttributeHurt = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HURT];
        $randUserAttributtePower = Skill_Common::randUserAttributePower($userData['attributes'][ConfigDefine::USER_ATTRIBUTE_POWER]);
        $skillValue = Skill_OutputData:: ptSkill($averageUserLevel,$ratioValue, $userAttributeHit, $userAttributeHurt, $randUserAttributtePower);
        $ret['hurt'] = $skillValue;
        $res[] = $ret;
        return $res;
    }
    //重击
    public static function zjSkill($userData)
    {
        $ret['is_double'] = 0;
        $averageUserLevel =Skill_Common::rand5UserLevelGetTop3Average($userData['user_level']);
        $ratioValue = Skill_Common::ratioValue();
        if($ratioValue == 2)$ret['is_double'] = 1;
        $userAttributeHit = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HIT];
        $userAttributeHurt = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HURT];
        $randUserAttributtePower = Skill_Common::randUserAttributePower($userData['attributes'][ConfigDefine::USER_ATTRIBUTE_POWER]);
        $skillValue = Skill_OutputData:: zjSkill($averageUserLevel,$ratioValue, $userAttributeHit, $userAttributeHurt, $randUserAttributtePower, $userData['user_level']);
        $ret['hurt'] = $skillValue;
        $res[] = $ret;
        return $res;
    }
    //连击
    public static function ljSkill($userData)
    {
        $ret['is_double'] = 0;
        $averageUserLevel =Skill_Common::rand5UserLevelGetTop3Average($userData['user_level']);
        $ratioValue = Skill_Common::ratioValue();
        if($ratioValue == 2)$ret['is_double'] = 1;
        $userAttributeHit = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HIT];
        $userAttributeHurt = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HURT];
        $randUserAttributtePower = Skill_Common::randUserAttributePower($userData['attributes'][ConfigDefine::USER_ATTRIBUTE_POWER]);
        $res = Skill_OutputData:: ljSkill($averageUserLevel,$ratioValue, $userAttributeHit, $userAttributeHurt, $randUserAttributtePower, $userData['user_level']);
        foreach($res as $hurt)
        {
            $hurtList[] = array('hurt' => $hurt, 'is_double' => $ret['is_double']);
        }
        return $hurtList;
    }
    //灵犀一指
    public static function lxyzSkill($userData)
    {
        $ret['is_double'] = 0;
        $averageUserLevel =Skill_Common::rand5UserLevelGetTop3Average($userData['user_level']);
        $ratioValue = Skill_Common::ratioValue();
        if($ratioValue == 2)$ret['is_double'] = 1;
        $userAttributeHit = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HIT];
        $userAttributeHurt = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HURT];
        $randUserAttributtePower = Skill_Common::randUserAttributePower($userData['attributes'][ConfigDefine::USER_ATTRIBUTE_POWER]);
        $skillValue = Skill_OutputData::lxyzSkill($averageUserLevel,$ratioValue, $userAttributeHit, $userAttributeHurt, $randUserAttributtePower, $userData['user_level']);
        $ret['hurt'] = $skillValue;
        $res[] = $ret;
        return $res;
    }
    //三昧真火
    public static function swzhSkill($userData)
    {
        $ret['is_double'] = 0;
        $averageUserLevel =Skill_Common::rand5UserLevelGetTop3Average($userData['user_level']);
        $ratioValue = Skill_Common::ratioValue();
        if($ratioValue == 2)$ret['is_double'] = 1;
        $userAttributePsychic = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_PSYCHIC];
        $randUserAttributteHurt = Skill_Common::randUserAttributeHurt($userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HURT]);
        $skillValue = Skill_OutputData::swzhSkill($averageUserLevel,$ratioValue, $userAttributePsychic, $randUserAttributteHurt, $userData['user_level']);
        $ret['hurt'] = $skillValue;
        $res[] = $ret;
        return $res;
    }
    ///呼风唤雨
    public static function hfhySkill($userData)
    {
        $ret['is_double'] = 0;
        $averageUserLevel =Skill_Common::rand5UserLevelGetTop3Average($userData['user_level']);
        $ratioValue = Skill_Common::ratioValue();
        if($ratioValue == 2)$ret['is_double'] = 1;
        $userAttributePsychic = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_PSYCHIC];
        $randUserAttributteHurt = Skill_Common::randUserAttributeHurt($userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HURT]);
        $res = Skill_OutputData::hfhySkill($averageUserLevel,$ratioValue, $userAttributePsychic, $randUserAttributteHurt, $userData['user_level']);
        foreach($res as $hurt)
        {
            $hurtList[] = array('hurt' => $hurt, 'is_double' => $ret['is_double']);
        }
        return $hurtList;
    }
    //五雷决
    public static function wljSkill($userData)
    {
        $ret['is_double'] = 0;
        $averageUserLevel =Skill_Common::rand5UserLevelGetTop3Average($userData['user_level']);
        $ratioValue = Skill_Common::ratioValue();
        if($ratioValue == 2)$ret['is_double'] = 1;
        $userAttributePsychic = $userData['attributes'][ConfigDefine::USER_ATTRIBUTE_PSYCHIC];
        $randUserAttributteHurt = Skill_Common::randUserAttributeHurt($userData['attributes'][ConfigDefine::USER_ATTRIBUTE_HURT]);
        $skillValue = Skill_OutputData::wljSkill($averageUserLevel,$ratioValue, $userAttributePsychic, $randUserAttributteHurt, $userData['user_level']);
        $ret['hurt'] = $skillValue;
        $res[] = $ret;
        return $res;
    }
    //反击
    public static function fjSkill($userData)
    {
        return self::ptSkill($userData);
    }
    //伤害被动技能
    public static function hurtPassive($userSkillId, $userData, $hurt)
    {
        $userHaveSkillIds = $userData['have_skillids'];
        switch($userSkillId)
        {
            //支持物攻修
            case ConfigDefine::SKILL_PT:
            case ConfigDefine::SKILL_ZJ:
            case ConfigDefine::SKILL_LJ:
            case ConfigDefine::SKILL_LXYZ:
                if(is_array($userHaveSkillIds) && isset($userHaveSkillIds[ConfigDefine::SKILL_GX]))
                {
                    $hurt = Skill_OutputData::wgxSkill($hurt, $userHaveSkillIds[ConfigDefine::SKILL_GX]);
                }
                break;
            //支持法攻修
            case ConfigDefine::SKILL_SWZH:
            case ConfigDefine::SKILL_HFHY:
            case ConfigDefine::SKILL_WLJ:
                if(is_array($userHaveSkillIds) && isset($userHaveSkillIds[ConfigDefine::SKILL_FX]))
                {
                    $hurt = Skill_OutputData::fgxSkill($hurt, $userHaveSkillIds[ConfigDefine::SKILL_FX]);
                }
                break;
            default:
                break;
        }
        return $hurt;
    }
    //防御被动技能
    public static function defencePassive($userSkillId, $targetUserData, $hurt)
    {
        $userHaveSkillIds = $targetUserData['have_skillids'];
        switch($userSkillId)
        {
            //支持物防修
            case ConfigDefine::SKILL_PT:
            case ConfigDefine::SKILL_ZJ:
            case ConfigDefine::SKILL_LJ:
            case ConfigDefine::SKILL_LXYZ:
                if(is_array($userHaveSkillIds) && isset($userHaveSkillIds[ConfigDefine::SKILL_WFX]))
                {
                    $hurt = Skill_OutputData::wfxSkill($hurt, $userHaveSkillIds[ConfigDefine::SKILL_WFX]);
                }
                break;
            //支持法防修
            case ConfigDefine::SKILL_SWZH:
            case ConfigDefine::SKILL_HFHY:
            case ConfigDefine::SKILL_WLJ:
              if(is_array($userHaveSkillIds) && isset($userHaveSkillIds[ConfigDefine::SKILL_FFX]))
                {
                    $hurt = Skill_OutputData::ffxSkill($hurt, $userHaveSkillIds[ConfigDefine::SKILL_FFX]);
                }
                break;
            default:
                break;
        }
        return $hurt;
    }
    //防御处理方法
    public static function defenceFunction($userSkillId, $targetUserData)
    {
        switch($userSkillId)
        {
            //支持物理防御
            case ConfigDefine::SKILL_PT:
            case ConfigDefine::SKILL_ZJ:
            case ConfigDefine::SKILL_LJ:
            case ConfigDefine::SKILL_LXYZ:
            case ConfigDefine::SKILL_FJ:
                $userAttributeDefence = $targetUserData['attributes'][ConfigDefine::USER_ATTRIBUTE_DEFENSE];
                $userSkillDefence = self::_wlfy($targetUserData['skill_ids']);
                break;
            //支持法术防御
            case ConfigDefine::SKILL_SWZH:
            case ConfigDefine::SKILL_HFHY:
            case ConfigDefine::SKILL_WLJ:
                $userAttributeDefence = $targetUserData['attributes'][ConfigDefine::USER_ATTRIBUTE_PSYCHIC];
                $userSkillDefence = self::_fsfy($targetUserData['skill_ids']);
            default:
                break;
        }
        return (array)($userAttributeDefence + $userSkillDefence[0]);
    }
    //物理防御
    private static function _wlfy($skillIds)
    {
        if(!is_array($skillIds))return array();
        foreach($skillIds as $skillId => $skillLevel)
        {
          if($skillId == ConfigDefine::SKILL_FY)
          {
              $res[] = Skill_OutputData::fySkill($skillLevel);
          }else{
              $res[] = 0;
          }
        }
        return $res;
    }
    //法术防御
    private static function _fsfy($skillIds)
    {
        if(!is_array($skillIds))return array();
        foreach($skillIds as $skillId => $skillLevel)
        {
          if($skillId == ConfigDefine::SKILL_FD)
          {
              $res[] = Skill_OutputData::fySkill($skillLevel);
          }else{
              $res[] = 0;
          }
        }
        return $res;
    }
}
