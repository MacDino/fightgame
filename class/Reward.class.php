<?php
//获取奖励
class Reward{
	
    //登陆奖励
    public static function Login($userId){
        //赠送2次双倍
        User_Property::addAmulet($userId, User_Property::DOUBLE_HARVEST, 2);    
        //赠送2次挂机符
        User_Property::addAmulet($userId, User_Property::AUTO_FIGHT, 2);    
        //赠送50元宝
        User_Info::updateSingleInfo($userId, 'ingot', 50, 1);
    }

    //首充奖励
    public static function FirstCharge($userId, $propsId){
        //赠送一份所购买的产品
        User_Property::addAmulet($userId, $propsId, 1);    
        //赠送20级角色升华种族套装一套    
        //还没写
    } 

    //升级奖励
    public static function Upgrade($userId, $level){
        //赠送10000储备金
        if($level > 0 && $level % 5 == 0){
            User_Info::updateSingleInfo($userId, 'reserve', 10000, 1);
        }
    }
}
