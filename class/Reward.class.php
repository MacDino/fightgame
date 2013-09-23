<?php
//获取奖励
class Reward{

    /** 登录奖励 */
    CONST LOGIN = 1;
    /** 等级奖励 */ 
    CONST UPGRADE = 2;
    /** 首充奖励 */
    CONST FIRSTCHARGE = 3;

    //登陆奖励
    public static function login($userId){
        if($userId){
            $data['user_id'] = $userId;
            $data['name'] = '登录奖励';
            $data['desc'] = '登录奖励';
            $data['type'] = self::LOGIN;
            $data['status'] = 1;
            return $this->_insert($data); 
        }
        return FALSE;
    }

    //领取登陆奖励
    public static function doLogin($userId){
        //赠送2次双倍
        User_Property::addAmulet($userId, User_Property::DOUBLE_HARVEST, 2);    
        //赠送2次挂机符
        User_Property::addAmulet($userId, User_Property::AUTO_FIGHT, 2);    
        //赠送50元宝
        User_Info::updateSingleInfo($userId, 'ingot', 50, 1);
    }

    //首充奖励
    public static function firstCharge($userId){
        if($userId){
            $data['user_id'] = $userId;
            $data['name'] = '首充奖励';
            $data['desc'] = '首充奖励';
            $data['type'] = self::FIRSTCHARGE;
            $data['status'] = 1;
            return $this->_insert($data); 
        }
        return FALSE;
    }
    
    //领取首充奖励
    public static function doFirstCharge($userId, $propsId){
        //赠送一份所购买的产品
        User_Property::addAmulet($userId, $propsId, 1);    
        //赠送20级角色升华种族套装一套    
        //还没写
    } 

    //升级奖励
    public static function upgrade($userId){
        if($userId){
            $data['user_id'] = $userId;
            $data['name'] = '升级奖励';
            $data['desc'] = '升级奖励';
            $data['type'] = self::upgrade;
            $data['status'] = 1;
            return $this->_insert($data); 
        }
        return FALSE;
    }

    //领取升级奖励
    public static function doUpgrade($userId, $level){
        //赠送10000储备金
        if($level > 0 && $level % 5 == 0){
            User_Info::updateSingleInfo($userId, 'reserve', 10000, 1);
        }
    }

    //奖励列表
    public static function getList($userId){
        if($userId){
            return MySql::select('user_reward', array('user_id' => $userId);
        }
        return FALSE:
    }

    private static function _insert($data){   
        $data['create_time'] = date('Y-m-d H:i:s');
        return MySql::insert('user_reward', $data);
    }
}
