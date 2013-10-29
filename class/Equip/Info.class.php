<?php
//装备操作 zyf
class Equip_Info
{	
    CONST TABLE_NAME = 'user_equip';
	
	/** @desc 获取用户的装备信息 */
	public static function getEquipListByUserId($userId, $is_used = FALSE){
        if($userId){
        	if(!$is_used){
            	$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId, 'del_status' => 0), array(), array('is_used desc', 'user_equip_id desc'));
        	}else{
        		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId, 'is_used' => 1, 'del_status' => 0), array(), array('is_used desc', 'user_equip_id desc'));
        	}
        }else{
            return FALSE;    
        }
        return $res;
    }
    
    /** @desc 获取背包内装备数量 */
    public static function getEquipNum($userId){
    	if(!$userId)return ;
    	$res = MySql::selectCount(self::TABLE_NAME, array('user_id' => $userId, 'del_status' => 0));
    	return $res;
    }
    
    /** @desc 按照类别获取装备 */
    public static function getEquipInfoByType($equipType, $userId, $is_used = FALSE){
    	$res = MySql::select(self::TABLE_NAME, array('equip_type' => $equipType, 'user_id' => $userId, 'del_status' => 0), array(), array('is_used desc', 'user_equip_id desc'));
    	return $res;
    }
    

    /** @desc 根据装备id返回信息 */
    public static function getEquipInfoById($equipId){
        if($equipId){
            $res = MySql::selectOne(self::TABLE_NAME, array('user_equip_id' => $equipId));
        }else{
            return FALSE;    
        }
        return $res;
    }
    
    public static function forgePrice($level){
    	return 40000 * pow(2, ($level));
    }

    /** @desc 装备打造 */
    public static function forge($equipId){
        $res = FALSE;
        $info = self::getEquipInfoById($equipId);
//print_r($info);
        if($info){
        	
			$sussessOdds = Skill::getQuickAttributeForEquip($info['forge_level']);
            $hit = PerRand::getRandResultKey($sussessOdds);
            
            if($hit == 'success'){ //装备锻造等级升一级
                $attributeList = json_decode($info['attribute_base_list'], TRUE);
                $forgeAttributeList = Equip_Config::forgeAttributeList();
                //增加属性值
                foreach($attributeList AS $k=>$v){
                    if(isset($forgeAttributeList[$info['equip_type']][$k])){
                        $attributeList[$k] = $forgeAttributeList[$info['equip_type']][$k] + $v;
                    }
                }
                $data['forge_level'] = $info['forge_level'] + 1;
                $data['attribute_base_list'] = json_encode($attributeList);
                $res = MySql::update(self::TABLE_NAME, $data, array('user_equip_id' => $equipId));        
            }elseif($hit == 'no_less_dz' && $info['forge_level'] != 0){ //装备锻造等级掉一级
            	$attributeList = json_decode($info['attribute_base_list'], TRUE);
                $forgeAttributeList = Equip_Config::forgeAttributeList();
                //减少属性值
                foreach($attributeList AS $k=>$v){
                    if(isset($forgeAttributeList[$info['equip_type']][$k])){
                        $attributeList[$k] = $forgeAttributeList[$info['equip_type']][$k] - $v;
                    }
                }
                $data['attribute_base_list'] = json_encode($attributeList);
                $data['forge_level'] = $info['forge_level'] - 1;
                $res = MySql::update(self::TABLE_NAME, $data, array('user_equip_id' => $equipId));        
            }
        }
        return $res;
    }
    
    /** @desc 装备升级 */
    public static function upgrade($equipId){
        //装备成长咒符
        $info = self::getEquipInfoById($equipId);
        $use = User_Property::useEquipGrow($info['user_id'], $equipId);
        if($use){
            $data = array();
            $data['equip_level'] = $info['equip_level'] + 10;
            $attributeList = Equip_Create::getEquipAttributeInfo($info['equip_colour'], 
                    $info['equip_quality'], $info['equip_type'], $info['equip_level']);
            $data['attribute_base_list'] = json_encode($attributeList);
            return MySql::update(self::TABLE_NAME, $data, array('user_equip_id' => $equipId));        
        }
        return FALSE;
    }

    /** @desc 装备价格 */
    public static function priceEquip($equipId)
    {
    	$equipInfo = self::getEquipInfoById($equipId);
    	
    	$res = $equipInfo['equip_level'] / 10 * 3 * $equipInfo['equip_level'] * (1 + ($equipInfo['equip_colour'] - 3801)/5) + 7;

    	return $res;
    }
     
    /** @desc 删除(卖出)装备 */
    public static function delEquip($equipId)
    {
    	$res = MySql::update(self::TABLE_NAME, array('del_status' => 1), array('user_equip_id' => $equipId));
    	return $res;
    }
    
    /** @desc 使用装备 */
    public static function useEquip($userId, $equipId){
    	//获取此装备信息,主要是equip_type
    	$equipInfo = self::getEquipInfoById($equipId);
    	//下掉原来同类装备
		$oldRes = MySql::update(self::TABLE_NAME, array('is_used' => 0), array('user_id' => $userId, 'equip_type' => $equipInfo['equip_type'], 'is_used' => 1));
    	//把装备安装上去
    	$res = MySql::update(self::TABLE_NAME, array('is_used' => 1), array('user_equip_id' => $equipId));
    	return $res;
    }
    
    /** @desc 脱下装备 */
    public static function dropEquip($equipId, $userId=FALSE ){
    	$res = MySql::update(self::TABLE_NAME, array('is_used' => 0), array('user_equip_id' => $equipId));
    	return $res;
    }
    
    /** @desc 判断是否为套装 */
    public static function isEmboitement($userId, $race_id){
    	//武器的颜色和种族
    	$equipInfo = self::getEquipListByUserId($userId, true);
    	if(count($equipInfo) < 6)return false;//不到6个自然凑不起来套装
    	foreach ($equipInfo as $i){//不全是橙色装备或者不是本种族装备
    		if($i['equip_colour'] != Equip::EQUIP_COLOUR_ORANGE || $i['race_id'] != $race_id)return false;
    	}
    	
    	return true;
    }
    
    /** @desc 分解装备 */
    public static function resolveEquip($userId, $equipId, $level){
    	$equipInfo = self::getEquipInfoById($equipId);
//    	print_r($equipInfo);
    	if($equipInfo['equip_colour'] == Equip::EQUIP_COLOUR_BLUE){
    		$res = rand(1 , 20);//蓝色5%几率
    	}elseif ($equipInfo['equip_colour'] == Equip::EQUIP_COLOUR_PURPLE){
    		$res = rand(1 , 5);//紫色20%几率
    	}elseif ($equipInfo['equip_colour'] == Equip::EQUIP_COLOUR_ORANGE){
    		$res = rand(1 , 2);//紫色20%几率
    	}else{
    		return false;//蓝色装备以下不能分解
    	}
//    	echo $res;
    	if($res == 1){
    		Pill_Iron::addIron($userId, $level);//增加精铁
//    		self::delEquip($equipId);//删除装备
    		return true;
    	}else{
//    		self::delEquip($equipId);//删除装备
    		return false;
    	}
    }
    
    /** @desc 是否正在使用 */
    public static function verifyEquipIsUsed($equipArray){
    	$equip = '';
    	if(is_array($equipArray)){
    		foreach ($equipArray as $i){
    			$equip .= $i.",";
    		}
    	}else{
    		return false;
    	}
    	
    	$equip = substr($equip,0,-1);
    	$sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE is_used = 1 AND del_status = 0 AND user_equip_id IN ($equip)";
//    	echo $sql;exit;
    	$res = MySql::query($sql);
//    	var_dump($res);
    	return count($res);
    }
    
    /** @desc 可分解装备列表(蓝色以上) */
    public static function getBuleEquipList($userId){
    	$sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE is_used = 0 AND del_status = 0 AND user_id = '$userId' AND equip_level <> 0 AND equip_colour > " . Equip::EQUIP_COLOUR_GREEN ;
//    	echo $sql;
    	$res = MySql::query($sql);
    	return $res;
    }
    
}
