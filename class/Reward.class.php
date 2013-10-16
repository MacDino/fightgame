<?php
//获取奖励
class Reward{
	
	CONST TABLE_NAME = 'user_reward';//奖励列表

    /** 登录奖励 */
    CONST LOGIN = 1;
    /** 等级奖励 */ 
    CONST UPGRADE = 2;
    /** 首充奖励 */
    CONST FIRSTCHARGE = 3;
    /** 积分奖励 */
    CONST INTEGRAL = 4;
    /** 月卡奖励 */
    CONST MONTHCARD = 5;
    /** 其他奖励 */
    CONST OTHER = 9;
    
    /** @desc 奖励列表 */
    public static function getList($userId){
    	$sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE user_id = '$userId' AND status = 0 AND (create_time = '" . date('Y-m-d') . "' OR `condition` <> 0)";
    	//echo $sql;
    	$res = MySql::query($sql);
        return $res;
    }
    
    /** @desc 根据ID查 */
    public static function getRewardInfoById($rewardId){
    	$res = MySql::selectOne(self::TABLE_NAME, array('id' => $rewardId));
    	return $res;
    }
    
    /** @desc 根据类型查 */
    public static function getRewardInfoByType($type){
    	$res = MySql::select(self::TABLE_NAME, array('type' => $type));
    	return $res;
    }

    /** @desc 登陆奖励 */
    public static function login($userId){
    	
        $data['user_id'] = $userId;
        $data['name'] = '登录奖励';
        $data['content'] = json_encode(array(
        	6301 => 2,
        	6306 => 2,
        ));
        $data['type'] = self::LOGIN;
        
        $now = self::getRewardInfoByType(self::LOGIN);
        
        if(!empty($now)){
    		if($now['create_time'] != date('Y-m-d')){//记录不是今天的
    			return self::_update($data, $now['reward_id']); 
    		}
    	}else{
    		return self::_insert($data); 
    	}
    }
    
    /** @desc 月卡奖励 */
    public static function monthCard($userId){
    	
        $data['user_id'] = $userId;
        $data['name'] = '战斗宝分红';
        $data['content'] = json_encode(array(
        	6301 => 4,
        	6302 => 5,
        	6303 => 4,
        	6306 => 4,
        	'ingot' => 100,
        ));
        $data['type'] = self::MONTHCARD;
        
        $now = self::getRewardInfoByType(self::MONTHCARD);
        
        if(!empty($now)){
    		if($now['create_time'] != date('Y-m-d')){//记录不是今天的
    			return self::_update($data, $now['reward_id']); 
    		}
    	}else{
    		return self::_insert($data); 
    	}
    }

    //首充奖励
    public static function firstCharge($userId, $num){
    	
    	$data['user_id'] = $userId;
        $data['name'] = '首充奖励';
        $data['content'] = json_encode(array(
        	'ingot' => $num,
        ));
        $data['type'] = self::FIRSTCHARGE;
    	
    	$now = self::getRewardInfoByType(self::FIRSTCHARGE);
    	if(empty($now)){
    		return self::_insert($data); 
    	}else{
    		return false;
    	}
    }

    //升级奖励
    public static function upgrade($userId){
    	$now = self::getRewardInfoByType(self::FIRSTCHARGE);
    	
        $data['user_id'] = $userId;
        $data['name'] = '升级奖励';
        $data['content'] = array(
        	'money'	   => 10000,
        	'baoxiang' => 1,
        );
        $data['type'] = self::UPGRADE;
        if(!empty($now) && $now['status'] == 1){
        	$userInfo = User_Info::getUserInfoByUserId($userId);
        	if($userInfo['user_level'] > $now['condition']){
        		$data['condition'] = $now['condition'] + 1;//生成下等级奖励
        		return self::_update($data, $now['reward_id']);
        	}
        }else{
        	$data['condition'] = 1;
        	return self::_insert($data); 
        }
        
    }
    
    //积分奖励
    public static function integral($userId){
    	$now = self::getRewardInfoByType(self::INTEGRAL);
    	$integral = Intergral::getTodayIntegral($userId);
    	
    	$data['user_id'] = $userId;
        $data['name'] = '积分奖励';
        $data['type'] = self::UPGRADE;
        $data['content'] = array(
        	'ingot'	   => 100,
        );
        
        if(empty($now)){//如果没有记录
        	if($integral >= 25){//并且大于25积分
        		$data['condition'] = 25;
        		return self::_insert($data);//新增一条记录
        	}
        }else{
        	if($now['create_time'] != date('Y-m-d')){//是不是今天的记录
        		if($integral >= 25){//并且满足新增条件
        			$data['condition'] = 25;
        			return self::_update($data, $now['reward_id']);//记录更新成今天
        		}
        	}
    		if($now['status'] == 1 && $now['create_time'] == date('Y-m-d')){//如果记录是今天的并且已领完,判断是否可以生成下一次
	    		if($now['condition'] == 25 && $integral >= 50){
	    			$data['condition'] = 50;
	    		}elseif($now['condition'] == 50 && $integral >= 100){
	    			$data['condition'] = 100;
	    		}elseif($now['condition'] == 100 && $integral >= 150){
	    			$data['condition'] = 150;
	    		}
	    		return self::_update($data, $now['reward_id']);
    		}
    	}
    	return false;//能走到这里说明没有可生成的新奖励
    }

    
	/** @desc 新增奖励 */
    private static function _insert($data){
        $data['create_time'] = date('Y-m-d');
        return MySql::insert(self::TABLE_NAME, $data);
    }

    /** @desc 结束奖励 */
    private static function _finish($rewardId)
    {   
        $sql = "UPDATE user_reward SET `status` = 1 WHERE reward_id = '$rewardId'";
        $res = MySql::query($sql);
        return $res;
    }
    
    /** @desc 更新奖励内容 */
    private static function _update($data, $rewardId){
    	$data['create_time'] = date('Y-m-d');
    	$data['status'] = 0;
        $res = MySql::update(self::TABLE_NAME, $data, array('reward_id' => $rewardId));
        return $res;
    }
    
    /** @desc 领取奖励 */
    public static function getReward($rewardId){
    	$res = '领取成功';
    	
    	$rewardInfo = self::getRewardInfoById($rewardId);
    	$content = json_decode($rewardInfo['content'], true);
    	$type = $rewardInfo['type'];
    	$userId = $rewardInfo['user_id'];
    	
    	self::_finish($rewardId);//改变状态为已领取
    	
    	if(!empty($content)){//奖励内容发放
    		foreach ($content as $key=>$value){
    			switch ($key){
    				case 'money'://金币
    					User_Info::addMoney($userId, $value);
    				case 'ingot'://元宝
    					User_Info::addIngot($userId, $value);
    				case 'exp'://经验
    					User_Info::addExperience($userId, $value);
    				case 3601://双倍符咒
    					User_Property::addAmulet($userId, 3601, $value);
					case 3602://PK符咒
    					User_Property::addAmulet($userId, 3602, $value);
					case 3603://属性增强符咒
    					User_Property::addAmulet($userId, 3603, $value);
    				case 3606://挂机符咒
    					User_Property::addAmulet($userId, 3606, $value);
    				case 'baoxiang'://宝箱
    					$res = Intergral::intergralLucky($userId);
    			}
    		}
    	}
    	
    	if(!empty($type)){//调用接口,累积奖励的那种,以后还要加上充值奖励和成就/爵位这类的累积奖励
			switch ($type){
				case self::UPGRADE://等级奖励
					self::upgrade($userId);
				case self::INTEGRAL://积分奖励 
					self::integral($userId);
			}
		}
		
		return $res;
    }
}
