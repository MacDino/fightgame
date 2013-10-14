<?php
class Skill_Common {
    
    //随机5次用户等级，取最大三个值的平均值
    public static function rand5UserLevelGetTop3Average($userLevel)
    {
        $userLevel = (int)$userLevel;
        if($userLevel == 1)return 1;
        if($userLevel < 1)return 0;
        for($i=1;$i<=5;$i++)
        {
            $res[] = PerRand::getRandValue(array(0, $userLevel));
        }
        rsort($res);
        $res = array_slice($res, 0, 3);
        $averageValue = array_sum($res)/3;
        return $averageValue;
    }
    //随机获取系数
    public static function ratioValue()
    {
    	//add by zhengyifeng 10.14
    	$violentPill = Pill_Pill::usedPill($userId);//暴击内丹
    	if($violentPill['pill_type'] == Pill::YUHENGNEIDAN){
    		$isViolent = 1;
    		$violentInfo = Pill::pillAttribute($violentPill['pill_type'], $violentPill['pill_layer'], $violentPill['pill_level']);
    	}
    	
    	
        $ratio = 0.05;
        
        //add by zhengyifeng 10.14
        if($isViolent == 1){$ratio += $violentInfo['probability'];}//暴击概率
        
        $ratioValue = 1;
        $ratioKey = PerRand::getRandResultKey(array($ratio));
        if($rationKey)$ratioValue = 2;
        
        //add by zhengyifeng 10.14
        if($isViolent == 1){$ratioValue += $violentInfo['value'];}//暴击伤害
        
        return $ratioValue; 
    }
    //随机获取用用户力量1%-5% 
    public static function randUserAttributePower($userAttributePower)
    {
        return PerRand::getRandValue($userAttributePower*0.01, $userAttributePower*0.05);
    }
    //随机获取用用户伤害3%-9% 
    public static function randUserAttributeHurt($userAttributeHurt)
    {
        return PerRand::getRandValue($userAttributePower*0.03, $userAttributePower*0.09);
    }





    /**
     * @desc 物理攻击常用值
     */
    public static function wlgjConst($role_level, $power){
        $const              = array();
        $const['rand5']     = self::rand5RoleLevel($role_level); 
        $const['randPower'] = self::randPower(0.05 * $power); 
        $rateValue = 1;
        $rateKey = PerRand::getRandResultKey(array(0.005));
        if($rateKey)$rateValue = 2;
        $const['rate']      = $rateValue;
        return $const;
    }

    /**
     * @desc 法术攻击常用值
     */
    public static function fsgjConst($role_level, $hurt){
        $const              = array();
        $const['rand5']     = self::rand5RoleLevel($role_level);
        $rate   = PerRand::getRandValue(array(0, 0.05));
        $const['rate']      = 2 * $rate;
        $const['hurt_rand'] = PerRand::getRandValue(array(0.03 * $hurt, 0.09 * $hurt));
        return $const;
    }
    /**
     * @desc 根据角色等级随机5次随机
     */
    public static function rand5RoleLevel($level){
        $return = 0;
        if(!empty($level) && $level > 0){
            $rands      = 5;
            $rand_key   = array(0, $level);
            $result     = array();
            while($rands){
                $result[] = PerRand::getRandValue($rand_key);
                $rands --;
            }
            if(rsort($result)) {
                //小数点是否处理 todo
                $return = ($result[1] + $result[2] + $result[3]) / 3;
            }
        }
        return $return;
    }

    /**
     * @desc 力量值随机1次
     */
    public static function randPower($power){
        $return = 0;
        if(!empty($power) && $power > 0){
            $rand_key   = array(0, $power);
            $return     = PerRand::getRandValue($rand_key);
        }
        return $return;
    }
    
}
