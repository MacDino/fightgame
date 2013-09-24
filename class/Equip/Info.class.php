<?php
//获取装备信息
class Equip_Info
{	
    CONST TABLE_NAME = 'user_equip';
	
	//获取用户的装备信息
	public static function getEquipListByUserId($userId, $is_used = FALSE){
        if($userId){
        	if(!$is_used){
            	$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
        	}else{
        		$res = MySql::select(self::TABLE_NAME, array('user_id' => $userId, 'is_used' => 1));
        	}
        }else{
            return FALSE;    
        }
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
    public static function priceEquip($userId, $equipId)
    {
    	$sql = "SELECT p.equip_price as price FROM user_equip e, equip_price p 
    					WHERE e.equip_colour = p.equip_colour AND e.equip_level = p.equip_level AND e.user_equip_id = '$equipId'";
//    	echo $sql;exit;
    	$res = MySql::query($sql);
    	var_dump($res);
    	return $res[0]['price'];
    }
    
    //删除(卖出)装备
    public static function delEquip($equipId)
    {
    	$res = MySql::delete(self::TABLE_NAME, array('user_equip_id' => $equipId));
    	return $res;
    }
}
