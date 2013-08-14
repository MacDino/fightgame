<?php 
//角色相关
class User_Info
{
    CONST TABLE_NAME = 'user_info';

    /**
     * 根据UserId获取用户基本信息
     * @param int $userId	用户ID
     * @return array
     */
    public static function getUserInfoByUserId($userId)
    {
        $res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        return $res;
    }
    
    public static function getUserInfoByLevel($friendId, $compare, $level){
    	if(!is_numeric($friendId) || !is_numeric($level))return FALSE;
    	$res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $friendId, 'user_level' => array('opt' => $compare, 'val' => $level)));
    	return $res;
    }

    /**
     * 创建用户基础信息
     * @param int $userId	用户ID
     * @param array $data	种族和用户名,其他值走默认
     * @return bool
     */
    public static function createUserInfo($userId, $data)
    {
        if(!$userId || !$data || !is_array($data))return FALSE;
        
        $info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        if($info)return FALSE;
        
        if(!isset($data['user_name']) || !isset($data['race_id']))return FALSE;
        
        $res = MySql::insert(self::TABLE_NAME, array(
	        'user_id' => $userId, 
	        'user_name' => $data['user_name'], 
	        'race_id' => $data['race_id'], 
	        'user_level' => User::DEFAULT_USER_LEVEL, 
	        'experience' => User::DEFAULT_EXP, 
	        'money' => User::DEFAULT_MONEY, 
	        'ingot' => User::DEFAULT_INGOT, 
	        'pack_num' => User::DEFAULT_PACK_NUM, 
	        'friend_num' => Friend_Info::FRIEND_NUM,//好友上限
        ));
        return $res;
    }
    
    /**
     * 更新用户基础信息,此处应该只能更新用户名,暂时不用这个function,除非是后台调整数据
     *
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public static function updateUserInfo($userId, $data)
    {
        if(!$userId || !$data || !is_array($data))return FALSE;
        $info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        if($info)return FALSE;
        $updateArray = array();
        isset($data['user_name'])?$updateArray['user_name'] = (int)$data['user_name']:'';
        isset($data['user_level'])?$updateArray['user_level'] = (int)$data['user_level']:'';
        isset($data['experience'])?$updateArray['experience'] = (int)$data['experience']:'';
        isset($data['money'])?$updateArray['money'] = (int)$data['money']:'';
        isset($data['ingot'])?$updateArray['ingot'] = (int)$data['ingot']:'';
        isset($data['ingot'])?$updateArray['ingot'] = (int)$data['friend_num']:'';
        isset($data['ingot'])?$updateArray['ingot'] = (int)$data['pack_num']:'';
        isset($data['ingot'])?$updateArray['ingot'] = (int)$data['skil_point']:'';
        $res = MySql::update(self::TABLE_NAME, $updateArray, array('user_id' => $userId));
        return $res;
    }
    
    /**
     * 用户信息单项更新
     *
     * @param int		 $userId	用户ID
     * @param string	 $key		变化的项
     * @param string	 $value		值
     * @param string	 $channel	+or-
     */
    public static function updateSingleInfo($userId, $key, $value, $change){
    	if(!$userId || !$key || !$value || !$change)return FALSE;
    	if($change == 1){
    		$change = '+';
    	}elseif($change == 2){
    		$change = '-';
    	}else{
    		return FALSE;
    	}
    	$sql = "UPDATE " . self::TABLE_NAME . " SET $key = " . "$key $change $value WHERE user_id = $userId";
    	$res = Mysql::query($sql);
    	return $res;
    }
    
    /**
     * 获取用户在战斗时的即时属性
     * 先计算数值,然后就算比率
     * 属性组成
     * 		基本属性
     * 		装备加成
     * @param int $user_id	用户ID
     * @return array
     */
    public static function getUserInfoFightAttribute($userId){
    	//数值型属性
    	$numerical = array(
    		ConfigDefine::USER_ATTRIBUTE_BLOOD			=> '0',
    		ConfigDefine::USER_ATTRIBUTE_DEFENSE		=> '0',
    		ConfigDefine::USER_ATTRIBUTE_DODGE			=> '0',
    		ConfigDefine::USER_ATTRIBUTE_ENDURANCE		=> '0',
    		ConfigDefine::USER_ATTRIBUTE_HIT			=> '0',
    		ConfigDefine::USER_ATTRIBUTE_HURT			=> '0',
    		ConfigDefine::USER_ATTRIBUTE_LUCKY			=> '0',
    		ConfigDefine::USER_ATTRIBUTE_MAGIC			=> '0',
    		ConfigDefine::USER_ATTRIBUTE_MAGIC_POWER	=> '0',
    		ConfigDefine::USER_ATTRIBUTE_PHYSIQUE		=> '0',
    		ConfigDefine::USER_ATTRIBUTE_POWER			=> '0',
    		ConfigDefine::USER_ATTRIBUTE_PSYCHIC		=> '0',
    		ConfigDefine::USER_ATTRIBUTE_QUICK			=> '0',
    		ConfigDefine::USER_ATTRIBUTE_SPEED			=> '0'    	
    	);
    	
    	//根据ID取出所属种族和等级
    	$userInfo = self::getUserInfoByUserId($userId);
    	
    	//根据种族和等级取出基础属性(裸属性),把基础属性的数值加入到$numerical里
    	$userAttribute = User_Attributes::getInfoByRaceAndLevel($userInfo['race_id'], $userInfo['user_level']);
    	//此处为假数据,需要分割字符串,分割成 属性['数值']
    	$explodeAttribute = explode($userAttribute, ',');
    	foreach ($explodeAttribute as $i=>$key)
    	{
    		if(isset($i) && !empty($key) && is_array($numerical))
    		{
    			$numerical[$i] += $key;
    		}
    	}
    	
    	//根据ID取出所有装备
    	//假设为getEquipInfoByUserId
    	/*$equipInfo = Equip_Info::getEquipInfoByUserId($userId, TRUE);
    	
    	//循环装备信息,数值类相加
    	foreach ($equipInfo as $p)
    	{
	    	$equipAttribute = json_decode($p, TRUE);
	    	//基础属性
	    	foreach ($equipAttribute as $m=>$n)
	    	{
	    		if(isset($m) && !empty($n) && is_array($numerical))
	    		{
	    			$numerical[$m] += $n;
	    		}
	    	}
	    	//扩展属性,百分比,判断是百分比数据的,加入$proportion
    	}*/
    	
    	//判断是否有对手,如果有,属性相生还是相克,计算所得值
    	//因为每个用户都会计算属性,所以相克只在一个用户身上体现就OK了
    	/*if(isset($opponent_id))
    	{
    		$opponent_info = self::testUserInfo($opponent_id);
    		if(int($opponent_info['race_id'] - $user_info['race_id']) = 1 || int($opponent_info['race_id'] - $user_info['race_id']) = '-2')
    		{
    			foreach ($proportion as $a=>$b){
    				$proportion[$a] = ceil($b * 0.97);//减少3%
    			}
    		}
    	}*/
    	/*if(isset($opponent_id)){
    		$opponent_info = self::getUserInfoByUserId($opponent_id);
    		if(int($opponent_info['race_id'] - $user_info['race_id']) = 1 || int($opponent_info['race_id'] - $user_info['race_id']) = '-2')
	    	foreach ($numerical as $x=>$y){
	    		if(isset($x)){
	    			$numerical[$x] = ceil($y * 0.97);
	    		}
	    	}
    	}*/
    	//把每项属性数值型部分乘上比例值部分
    	/*foreach ($proportion as $x=>$y)
    	{
    		if(in_array($x, $numerical)){
    			$numerical[$x] = $numerical * $y;
    		}
    	}*/
    	
    	//得出结果,合成字符串,抛出
    	return $numerical;
    }
    
    /**
     * 使用属性增强符咒
     * @param array $data	属性数组
     * @return array 
     */
    public static function strengthenUserAttribute($data){
    	if(!is_array($data))return FALSE;
    	
    	$res = array();
    	foreach ($data as $key => $value){
    		$res[$key] = $value * (1 + USER::ATTEIBUTEENHANCE);
    	}
    	return $res;
    }
    
    /**
     * 种族属性被克
     * @param array $data	属性数组
     * @return array 
     */
    public static function restraintAttribute($data){
    	if(!is_array($data))return FALSE;
    	
    	$res = array();
    	foreach ($data as $key => $value){
    		$res[$key] = $value * (1 - USER::ATTEIBUTEENHANCE);
    	}
    	return $res;
    }
    
    /**
     * 种族属性相生
     * @param array $data	属性数组
     * @return array 
     */
    public static function begetsAttribute($data){
    	if(!is_array($data))return FALSE;
    	
    	$res = array();
    	foreach ($data as $key => $value){
    		$res[$key] = $value * (1 + USER::ATTEIBUTEENHANCE);
    	}
    	return $res;
    }
}
