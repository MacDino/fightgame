<?php
//获取装备信息
class Equip_Info
{	
    CONST TABLE_NAME = 'user_equip';
	
	//获取用户的装备信息
	public static function getEquipListByUserId($userId, $is_used = FALSE){
        if($userId){
        	if(!$is_used){
            	$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId,), array(), array('is_used desc', 'user_equip_id desc'));
        	}else{
        		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId, 'is_used' => 1), array(), array('is_used desc', 'user_equip_id desc'));
        	}
        }else{
            return FALSE;    
        }
        return $res;
    }
    
    //获取背包内装备数量
    public static function getEquipNum($userId){
    	if(!$userId)return ;
    	$res = MySql::selectCount(self::TABLE_NAME, array('user_id' => $userId));
    	return $res;
    }
    
    //按照类别获取装备
    public static function getEquipInfoByType($equipType, $userId, $is_used = FALSE){
    	$res = MySql::select(self::TABLE_NAME, array('equip_type' => $equipType, 'user_id' => $userId), array(), array('is_used desc', 'user_equip_id desc'));
    	return $res;
    }
    

    //根据装备id返回信息
    public static function getEquipInfoById($equipId){
        if($equipId){
            $res = MySql::selectOne(self::TABLE_NAME, array('user_equip_id' => $equipId));
        }else{
            return FALSE;    
        }
        return $res;
    }

    //装备打造
    public static function forge($equipId){
        $res = FALSE;
        $info = self::getEquipInfoById($equipId);
        if($info){
            //使用锻造成功咒符
            $use = User_Property::useEquipForge($info['user_id']);
            if($use){
                $opt = 0.1;    
            }else{
                $opt = 0;    
            }
            $hit = PerRand::getRandResultKey(Skill::getQuickAttributeForEquip($info['forge_level'], $opt));
            if($hit == 'success'){ //装备锻造等级升一级
                $attributeList = json_decode($info['attribute_base_list'], TRUE);
                $forgeAttributeList = Equip_Config::forgeAttributeList();
                //增加属性值
                foreach($attributeList AS $k=>$v){
                    if(isset($forgeAttributeList[$info['equip_type']][$k])){
                        $attributeList[$k] = $forgeAttributeList[$info['equip_type']][$k] + $v;
                    }
                }
                $data = array();
                $data['forge_level'] = $info['forge_level'] + 1;
                $data['attribute_base_list'] = json_encode($attributeList);
                $res = MySql::update(self::TABLE_NAME, $data, array('user_equip_id' => $equipId));        
            }elseif($hit == 'no_less_dz' && $info['forge_level'] != 0){ //装备锻造等级掉一级
                $data['forge_level'] = $info['forge_level'] - 1;
                $res = MySql::update(self::TABLE_NAME, $data, array('user_equip_id' => $equipId));        
            }
        }
        return $res;
    }
    
    //装备升级
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

    //装备价格 add by zhengyifeng 76387051@qq.com  2013.9.13
    public static function priceEquip($equipId)
    {
    	$equipInfo = self::getEquipInfoById($equipId);
    	
    	$res = $equipInfo['equip_level'] / 10 * 3 * $equipInfo['equip_level'] * (1 + ($equipInfo['equip_colour'] - 3801)/5) + 7;

    	return $res;
    }
    
    //删除(卖出)装备
    public static function delEquip($equipId)
    {
    	$res = MySql::delete(self::TABLE_NAME, array('user_equip_id' => $equipId));
    	return $res;
    }
    
    //使用装备
    public static function useEquip($userId, $equipId){
    	//获取此装备信息,主要是equip_type
//    	echo 3333;
    	$equipInfo = self::getEquipInfoById($equipId);
//    	var_dump($equipInfo);
    	//下掉原来同类装备
		$oldRes = MySql::update(self::TABLE_NAME, array('is_used' => 0), array('user_id' => $userId, 'equip_type' => $equipInfo['equip_type'], 'is_used' => 1));
    	//把装备安装上去
    	$res = MySql::update(self::TABLE_NAME, array('is_used' => 1), array('user_equip_id' => $equipId));
    	return $res;
    }
    
    //脱下装备
    public static function dropEquip($equipId, $userId=FALSE ){
    	$res = MySql::update(self::TABLE_NAME, array('is_used' => 0), array('user_equip_id' => $equipId));
    	return $res;
    }
    
    //判断是否为套装
    public static function isEmboitement($userId, $race_id){
    	//武器的颜色和种族
    	$equipInfo = self::getEquipListByUserId($userId, true);
    	
    	if(count($equipInfo) < 6)return false;//不到6个自然凑不起来套装
    	foreach ($equipInfo as $i){//不全是橙色装备或者不是本种族装备
    		if($i['equip_colour'] != Equip::EQUIP_COLOUR_ORANGE || $i['race_id'] != $race_id)return false;
    	}
    	
    	return true;
    }
    
}
