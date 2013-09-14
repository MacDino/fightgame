<?php
class Skill_Common {
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
