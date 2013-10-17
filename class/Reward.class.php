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
    	$res = MySql::selectOne(self::TABLE_NAME, array('reward_id' => $rewardId));
//    	print_r($res);
    	return $res;
    }
    
    /** @desc 根据类型查 */
    public static function getRewardInfoByType($userId, $type){
    	$res = MySql::selectOne(self::TABLE_NAME, array('type' => $type, 'user_id' => $userId));
//    	print_r($res);
    	return $res;
    }

    /** @desc 登陆奖励 */
    public static function login($userId){
        $now = self::getRewardInfoByType($userId, self::LOGIN);
        
        $data['content'] = json_encode(array(
        	6301 => 2,
        	6306 => 2,
        ));
        $data['status'] = 0;
        
        if(!empty($now)){
    		if($now['create_time'] != date('Y-m-d')){//记录不是今天的
    			self::_update($data, $now['reward_id']); 
    		}
    	}else{
    		$data['user_id'] = $userId;
	        $data['name'] = '登录奖励';
	        $data['type'] = self::LOGIN;
    		self::_insert($data); 
    	}
    }
    
    /** @desc 月卡奖励 */
    public static function monthCard($userId){
    	$now = self::getRewardInfoByType($userId, self::MONTHCARD);
        
        $data['content'] = json_encode(array(
        	6301 => 4,
        	6302 => 5,
        	6303 => 4,
        	6306 => 4,
        	'ingot' => 100,
        ));
        $data['status'] = 0;
        
        if(!empty($now)){
    		if($now['create_time'] != date('Y-m-d')){//记录不是今天的
    			self::_update($data, $now['reward_id']); 
    		}
    	}else{
    		$data['user_id'] = $userId;
	        $data['name'] = '战斗宝分红';
	        $data['type'] = self::MONTHCARD;
    		self::_insert($data); 
    	}
    }

    //首充奖励
    public static function firstCharge($userId, $num){
    	$now = self::getRewardInfoByType($userId, self::FIRSTCHARGE);
    	
    	if(empty($now)){
    		$data['user_id'] = $userId;
	        $data['name'] = '首充奖励';
	        $data['content'] = json_encode(array(
	        	'ingot' => $num,
	        ));
	        $data['type'] = self::FIRSTCHARGE;
	        $data['status'] = 0;
    		self::_insert($data); 
    	}
    }

    //升级奖励
    public static function upgrade($userId){
    	$now = self::getRewardInfoByType($userId, self::UPGRADE);
    	$userInfo = User_Info::getUserInfoByUserId($userId);
        
        $data['status'] = 0;
        
        if(!empty($now) && $now['status'] == 1){
        	if($userInfo['user_level'] > $now['condition']){
        		$data['condition'] = $now['condition'] + 1;//生成下等级奖励
        		$data['content'] = json_encode(array(
		        	'money'	   => ($userInfo['user_level']-1)*500 + 10000,
		        	'box' 	   => 1,
		        ));
        		return self::_update($data, $now['reward_id']);
        	}
        }else{
        	$data['user_id'] = $userId;
        	$data['name'] = '升级奖励';
        	$data['content'] = json_encode(array(
	        	'money'	   => 10000,
	        	'box' 	   => 1,
	        ));
        	$data['condition'] = 1;
        	$data['type'] = self::UPGRADE;
        	return self::_insert($data); 
        }
        
    }
    
    //积分奖励
    public static function integral($userId){
    	$now = self::getRewardInfoByType($userId, self::INTEGRAL);
    	$integral = Integral::getTodayIntegral($userId);
    	
    	$data['status'] = 0;
        
        if(empty($now)){//如果没有记录
        	if($integral >= 25){//并且大于25积分
        		$data['user_id'] = $userId;
		        $data['name'] = '积分奖励';
		        $data['type'] = self::INTEGRAL;
		        $data['content'] = json_encode(array(
		        	'ingot'	   => 100,
		        ));
        		$data['condition'] = 25;
        		return self::_insert($data);//新增一条记录
        	}
        }else{
        	if($now['create_time'] != date('Y-m-d')){//是不是今天的记录
        		if($integral >= 25){//并且满足新增条件
        			$data['content'] = json_encode(array(
			        	'ingot'	   => 100,
			        ));
        			$data['condition'] = 25;
        			return self::_update($data, $now['reward_id']);//记录更新成今天
        		}
        	}
    		if($now['status'] == 1 && $now['create_time'] == date('Y-m-d')){//如果记录是今天的并且已领完,判断是否可以生成下一次
	    		if($now['condition'] == 25 && $integral >= 50){
	    			$data['condition'] = 50;
	    			$data['content'] = json_encode(array(
			        	'exp'	   => 5000*pow(2, intval(($data['condition']/10)-3)),
			        ));
	    		}elseif($now['condition'] == 50 && $integral >= 100){
	    			$data['condition'] = 100;
	    			$data['content'] = json_encode(array(
			        	'money'	   => 5000*pow(2, intval(($data['condition']/10)-3))/2,
			        ));
	    		}elseif($now['condition'] == 100 && $integral >= 150){
	    			$data['content'] = json_encode(array(
			        	'box'	   => 1,
			        ));
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
    
    /** @desc 更新奖励内容 */
    private static function _update($data, $rewardId){
    	$data['create_time'] = date('Y-m-d');
        return MySql::update(self::TABLE_NAME, $data, array('reward_id' => $rewardId));
    }
    
    /** @desc 领取奖励 */
    public static function getReward($rewardId, $contentId){
    	
    	$rewardInfo = self::getRewardInfoById($rewardId);
    	$content = json_decode($rewardInfo['content'], true);
    	
    	$type = $rewardInfo['type'];
    	$userId = $rewardInfo['user_id'];
    	
    	if(is_numeric($contentId)){
    		if(substr($contentId,0,2) == 63){//道具
    			$res = call_user_func(array('Rewardtype', 'pillStone'), $userId ,$content[$contentId], $contentId);
    		}elseif (substr($contentId,0,2) == 36){//内丹
    			$res = call_user_func(array('Rewardtype', 'props'), $userId ,$content[$contentId], $contentId);
    		}
    	}else{
    		$res = call_user_func(array('Rewardtype', $contentId), $userId ,$content[$contentId]);
    	}
    	
		unset($content[$contentId]);//删掉已领取的奖励
    	
    	if(!empty($content)){
    		self::_update(array('content' => json_encode($content)), $rewardId);//去掉已经领取的内容
    	}else{
    		self::_update(array('content' => '', 'status' => 1), $rewardId);//去掉已经领取的内容,并且改变状态为已领取完毕
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
