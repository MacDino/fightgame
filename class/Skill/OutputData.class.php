<?php

class Skill_OutputData
{
    //普通攻击
    public static function ptSkill($averageUserLevel, $ratioValue = 1, $userAttributeHit, $userAttributeHurt, $randUserAttributtePower)
    {
        $hurt = $averageUserLevel + $userAttributeHit/3 + $userAttributeHurt + $randUserAttributtePower;
        $hurt = $hurt*$ratioValue;
        return $hurt;
    }
    //普通攻周加成
    public static function ptAddition($hurt, $userSkillLevel = NULL)
    {
        return $hurt*1; 
    }
    //重击
    public static function zjSkill($averageUserLevel, $ratioValue = 1, $userAttributeHit, $userAttributeHurt, $randUserAttributtePowe, $userSkillLevel)
    {
        $hurt = $averageUserLevel + ($userAttributeHit + $userSkillLevel*4)/3 + $userAttributeHurt + $randUserAttributtePower;
        $hurt = $hurt*$ratioValue;
        return $hurt;
    }
    //重击加成
    public static function zjAddition($hurt, $userSkillLevel = NULL)
    {
        return $hurt*(1.2 + $userSKillLevel * 0.005);
    }
    //连击
    public static function ljSkill($averageUserLevel, $ratioValue = 1, $userAttributeHit, $userAttributeHurt, $randUserAttributtePowe, $userSkillLevel)
    {
        $hurt = $averageUserLevel + $userAttributeHit/3 + $userAttributeHurt + $userSkillLevel*4 + $randUserAttributtePower;
        $hurt = $hurt*$ratioValue;
        $hurtList[] = $hurt*0.7;
        $hurtList[] = $hurt*0.8;
        $hurtList[] = $hurt*1.0;
        return $hurtList;
    }
    //连击加成
    public static function ljAddition($hurt, $userSkillLevel = NULL)
    {
        return $hurt*1; 
    }
    //灵犀一指
    public static function lxyzSkill($averageUserLevel, $ratioValue = 1, $userAttributeHit, $userAttributeHurt, $randUserAttributtePowe, $userSkillLevel)
    {
        $hurt = $averageUserLevel + ($userAttributeHit + $userSkillLevel *4)/3 + $userAttributeHurt + $skillLevel*2 + $randUserAttributtePower;
        $hurt = $hurt*$ratioValue;
        $hurt = $hurt + 20 + $userSkillLevel*4;
        return $hurt;
    }
    //灵犀一指加成
    public static function lxyzAddition($hurt, $userSkillLevel = NULL)
    {
        return $hurt*1; 
    }
    //三昧真火
    public static function swzhSkill($averageUserLevel, $ratioValue = 1, $userAttributePsychic, $randUserAttributteHurt, $userSkillLevel)
    {
        $hurt = $userAttributePsychic + $skillLevel*2 + $randUserAttributteHurt + $userSkillLevel*1.3;
        $hurt = $hurt + $averageUserLevel;
        $hurt = $hurt*$ratioValue;
        return $hurt;
    }
    //三昧真火加成
    public static function swzhAddition($hurt, $userSkillLevel = NULL)
    {
        return $hurt*($userSkillLevel*0.005 + 1.2);
    }
    //呼风唤雨
    public static function hfhySkill($averageUserLevel, $ratioValue = 1, $userAttributePsychic, $randUserAttributteHurt, $userSkillLevel)
    {
        $hurt = $userAttributePsychic + $userSkillLevel*1 + $randUserAttributteHurt + $userSkillLevel*1.2;
        $hurt = $hurt + $averageUserLevel;
        $hurt = $hurt*$ratioValue;
        $hurtList[] = $hurt;
        $hurtList[] = $hurt;
        return $hurtList;
    }
    //呼风唤雨火加成
    public static function hfhyAddition($hurt, $userSkillLevel = NULL)
    {
        return $hurt*1;
    }
    //五雷决
    public static function wljSkill($averageUserLevel, $ratioValue = 1, $userAttributePsychic, $randUserAttributteHurt, $userSkillLevel)
    {
        $hurt = $userAttributePsychic + $userSkillLevel*1 + $randUserAttributteHurt + $userSkillLevel*1.1;
        $hurt = $hurt + $averageUserLevel;
        $hurt = $hurt*$ratioValue;
        return $hurt;
    }
     //五雷决火加成
    public static function wljAddition($hurt, $userSkillLevel = NULL)
    {
        return $hurt*1;
    }
    //反击加成
    public static function fjAddition($hurt, $userSkillLevel = NULL)
    {
        return $hurt*self::fjSkill($userSkillLevel); 
    }

    //物防修-被动技能
    public static function wfxSkill($hurt, $skillLevel)
    {
        return $hurt = $hurt - $hurt*0.02*0.1*$skillLevel - 5*0.1*$skillLevel; 
    }
    //法防修-被动技能
    public static function ffxSkill($hurt, $skillLevel)
    {
        return $hurt = $hurt - $hurt*0.02*0.1*$skillLevel - 5*0.1*$skillLevel; 
    }
    //物攻修-被动技能
    public static function wgxSkill($hurt, $skillLevel)
    {
    	return $hurt*pow(1.002, $skillLevel) + 0.5*(pow(1.002, $skillLevel) -1)/(1.002 -1);
    }
    //法攻修-被动技能
    public static function fgxSkill($hurt, $skillLevel)
    {
        return $hurt = $hurt + $hurt*0.02*0.1*$skillLevel + 5*0.1*$skillLevel; 
    }
    //防御--防御技能
    public static function fySkill($skillLevel)
    {
        return 5 + $skillLevel*1;
    }
    //反击--防御技能
    public static function fjSkill($skillLevel)
    {
        return 0.5 + $skillLevel*0.01;
    }
    //法盾--防御技能 
    public static function fdSkill($skillLevel)
    {
        return 10 + $skillLevel*2;
    } 
}
