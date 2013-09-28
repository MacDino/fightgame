<?php
/**
 * 0表示此项关闭
 * 1表示此项开启
 * 实际存储中，与上面的值相反
 * @author lishengwei
 */
class Fight_Setting {
    const TABLE_NAME = 'fight_setting';

    public static function create($userId, $params) {
        if($userId <= 0) {
            return FALSE;
        }
        $existInfo  = self::getFightSettingByUserId($userId);
        $data       = array(
            'user_id' => intval($userId),
        );
        $colorsInfo = self::getColorTransToId();
        foreach ($colorsInfo as $colorsKey => $colorsId) {
            if(in_array($colorsId, $params)) {
                $data[$colorsKey] = 1;
            }  else {
                $data[$colorsKey] = 0;
            }
        }
        if(count($data) < 2) {
            return FALSE;
        }
        if(is_array($existInfo) && count($existInfo)) {
            return MySql::update(self::TABLE_NAME, $data, array('user_id' => $userId));
        }
        return MySql::insert(self::TABLE_NAME, $data);
    }

    private static function getFightSettingByUserId($userId) {
        if($userId > 0) {
            $where = array(
                'user_id' => $userId,
            );
            return MySql::selectOne(self::TABLE_NAME, $where);
        }
        return FALSE;
    }

    /**输出给前端使用，没有的话会默认出来一个**/
    public static function getSettingByUserId ($userId) {
        $info = self::getFightSettingByUserId($userId);
        $keys = array('gray','green','blue','white','purple','orange');
        if(is_array($info) && count($info)) {
            $isSetting = TRUE;
        } else {
            $isSetting = FALSE;
        }
        foreach ($keys as $k) {
            $return[$k] = $isSetting ? intval($info[$k]) : 1;
        }
        return $return;
    }

    //何种颜色的装备拾取
    public static function isEquipMentCan($userId) {
        $setting = self::getSettingByUserId($userId);
        $equipmentColor = self::getColorTransToId();
        foreach ($setting as $key => $v) {
            if(array_key_exists($key, $equipmentColor)) {
                $colorId = $equipmentColor[$key];
                $return[$colorId] = $v;
            }
        }
        return $return;
    }

    private static function getColorTransToId() {
        return array(
            'gray'      => Equip::EQUIP_COLOUR_GRAY,
            'green'     => Equip::EQUIP_COLOUR_GREEN,
            'blue'      => Equip::EQUIP_COLOUR_BLUE,
            'white'     => Equip::EQUIP_COLOUR_WHITE,
            'purple'    => Equip::EQUIP_COLOUR_PURPLE,
            'orange'    => Equip::EQUIP_COLOUR_ORANGE
        );
    }
}