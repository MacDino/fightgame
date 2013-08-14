<?php 
 
class User_Info
{

    CONST TABLE_NAME = 'user_info';

    //根据用户ID获取用户基础信息
    public static function getUserInfoByUserId($userId)
    {
        $res = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        return $res;
    }

    //创建用户基础信息
    public static function createUserInfo($userId, $data)
    {
        if(!$userId || !$data || !is_array($data))return FALSE;
        $info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        if($info)return FALSE;
        if(!isset($data['user_name']) || !isset($data['role_id']))return FALSE;
        $res = MySql::insert(self::TABLE_NAME, array('user_id' => $userId, 'user_name' => $data['user_name'], 'role_id' => $data['role_id'], 'user_level' => 0, 'experience' => 0, 'money' => 0, 'ingot' => 0, 'pack_num' => 40));
        return $res;
    }
    
    //更新用户基础信息
    public static function updateUserInfo($userId, $data)
    {
        if(!$userId || !$data || !is_array($data))return FALSE;
        $info = MySql::selectOne(self::TABLE_NAME, array('user_id' => $userId));
        if($info)return FALSE;
        $updateArray = array();
        isset($data['user_level'])?$updateArray['user_level'] = (int)$data['user_level']:'';
        isset($data['experience'])?$updateArray['experience'] = (int)$data['experience']:'';
        isset($data['money'])?$updateArray['money'] = (int)$data['money']:'';
        isset($data['ingot'])?$updateArray['ingot'] = (int)$data['ingot']:'';
        $res = MySql::update(self::TABLE_NAME, $updateArray, array('user_id' => $userId));
        return $res;
    }
    
    public static function testUserInfo($id){
    	
    	$res = MySql::selectOne(self::TABLE_NAME, array('id'=>$id));
    	return $res;
    }
    
    /**
     * 获取用户在战斗时的即时属性
     * 先计算数值,然后就算比率
     * 属性组成
     * 		基本属性
     * 		装备加成
     * 		被动技能		
     * 		种族相克		@opponent_id	对手ID
     * 		
     *
     * @param int $user_id	用户ID
     * @param int $opponent_id	对手ID
     */
    public static function getUserInfoFightAttribute($user_id, $opponent_id=FALSE){
    	//先计算出所有数值
    	//然后再算比例
    	$numerical = array(
    		User_Attributes::USER_ATTRIBUTE_BLOOD,
    		User_Attributes::USER_ATTRIBUTE_DEFENSE,
    		User_Attributes::USER_ATTRIBUTE_DODGE,
    		User_Attributes::USER_ATTRIBUTE_ENDURANCE,
    		User_Attributes::USER_ATTRIBUTE_HIT,
    		User_Attributes::USER_ATTRIBUTE_HURT,
    		User_Attributes::USER_ATTRIBUTE_LUCKY,
    		User_Attributes::USER_ATTRIBUTE_MAGIC,
    		User_Attributes::USER_ATTRIBUTE_MAGIC_POWER,
    		User_Attributes::USER_ATTRIBUTE_PHYSIQUE,
    		User_Attributes::USER_ATTRIBUTE_POWER,
    		User_Attributes::USER_ATTRIBUTE_PSYCHIC,
    		User_Attributes::USER_ATTRIBUTE_QUICK,
    		User_Attributes::USER_ATTRIBUTE_SPEED    	
    	);//数值型属性
    	//$proportion = array();//比例型属性
    	
    	//根本ID取出所属种族和等级
    	//getUserInfoByUserId
    	$user_info = self::testUserInfo($user_id);
    	
    	//根据种族和等级取出基础属性(裸属性),把基础属性的数值加入到$numerical里
    	//getInfoByRaceAndLevel
    	$user_attribute = User_Attributes::getInfoByRaceAndLevel($user_info['race_id'], $user_info['user_level']);
    	//此处为假数据,需要分割字符串,分割成 属性['数值']
    	$explode_attribute = explode($user_attribute, ',');
    	foreach ($explode_attribute as $i=>$key)
    	{
    		if(isset($i) && !empty($key) && is_array($numerical))
    		{
    			$numerical[$i] = $key;
    		}
    	}
    	
    	//根据ID取出所有装备
    	//假设为getEquipInfoByUserId
    	$equip_info = Equip_Info::getEquipInfoByUserId($user_id, TRUE);
    	
    	//循环装备信息,加值类相加,比例类相加,比例类=比例+100%
    	foreach ($equip_info as $o=>$p)
    	{
	    	$equip_attribute = json_decode($p);
	    	//基础属性
	    	foreach ($equip_attribute as $m=>$n)
	    	{
	    		if(isset($m) && !empty($n) && is_array($numerical))
	    		{
	    			$numerical[$m] += $n;
	    		}
	    	}
	    	//扩展属性,百分比,判断是百分比数据的,加入$proportion
	    	
    	}
    	
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
    	if(isset($opponent_id)){
    		$opponent_info = self::getUserInfoByUserId($opponent_id);
    		if(int($opponent_info['race_id'] - $user_info['race_id']) = 1 || int($opponent_info['race_id'] - $user_info['race_id']) = '-2')
	    	foreach ($numerical as $x=>$y){
	    		if(isset($x)){
	    			$numerical[$x] = ceil($y * 0.97);
	    		}
	    	}
    	}
    	
    	//把每项属性数值型部分乘上比例值部分
    	/*foreach ($proportion as $x=>$y)
    	{
    		if(in_array($x, $numerical)){
    			$numerical[$x] = $numerical * $y;
    		}
    	}*/
    	
    	//得出结果,合成字符串,抛出
    	return json_encode($numerical);
    }
}
