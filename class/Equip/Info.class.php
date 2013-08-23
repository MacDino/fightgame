<?php
//获取装备信息
class Equip_Info
{	
    CONST TABLE_NAME = 'user_equip';

    //获取用户的装备信息
    public static function getEquipListByUserId($userId){
        if($userId){
            $res = MySql::select(self::TABLE_NAME, array('user_id' => $userId));
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

    //装备升级
    public static function upgrade($equipId){
        $res = FALSE;
        $info = self::getEquipInfoById($equipId);
        if($info){
            $hit = PerRand::getRandResultKey(Skill::getQuickAttributeForEquip($info['equip_level']));
            if($hit == 'success'){ //装备等级升一级
                $attributeList = json_decode($info['attribute_base_list'], TRUE);
                $upgradeAttributeList = Equip_Config::upgradeAttributeList();
                //增加属性值
                foreach($attributeList AS $k=>$v){
                    if(isset($upgradeAttributeList[$info['equip_type']][$k])){
                        $attributeList[$k] = $upgradeAttributeList[$info['equip_type']][$k] + $v;
                    }
                }
                $data = array();
                $data['equip_level'] = $info['equip_level'] + 1;
                $data['attribute_base_list'] = json_encode($attributeList);
                $res = MySql::update(self::TABLE_NAME, $data, array('user_equip_id' => $equipId));        
            }elseif($hit == 'no_less_dz' && $info['equip_level'] != 0){ //装备等级掉一级
                $data['equip_level'] = $info['equip_level'] - 1;
                $res = MySql::update(self::TABLE_NAME, $data, array('user_equip_id' => $equipId));        
            }
        }
        return $res;
    }
}
