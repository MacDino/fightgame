<?php
class RobotFight{
    const TABLE_NAME = 'robot_fight';

    public static function create($params) {
        if($params['user_id'] <= 0)            return FALSE;
        if($params['map_id'] <= 0)             return FALSE;
        $data = array(
            'user_id'   => $params['user_id'],
            'lucky'     => $params['lucky'],
            'map_id'    => $params['map_id'],
            'start_time'=> time(),
            'status'    => 0,
        );
        $existInfo = self::getInfoByUserId($params['user_id']);
        if(is_array($existInfo) && count($existInfo)) {
            $where = array(
                'user_id' => $params['user_id'],
            );
            return MySql::update(self::TABLE_NAME, $data, $where);
        }else {
            return MySql::insert(self::TABLE_NAME, $data, TRUE);
        }
    }

    public static function getInfoByUserId($userId) {
        if($userId <= 0)            return FALSE;
        $where = array(
            'user_id' => $userId
        );
        return MySql::selectOne(self::TABLE_NAME, $where);
    }

    public static function updateStatus($userId) {
        $info = self::getInfoByUserId($userId);
        if(is_array($info) && count($info)) {
            $where = array(
                'user_id' => $userId,
            );
            $data = array(
                'status'    => 1,
            );
            return MySql::update(self::TABLE_NAME, $data, $where);
        }
        return FALSE;
    }

    public static function getResult($info, $time, $dropThingsRate) {
        $dropThingsRate = $dropThingsRate * 100 >= 0 && $dropThingsRate * 100 <=100 ? $dropThingsRate : 1;
        $awardInfos     = self::getAwardPerMinite();
        $awardInfo      = $awardInfos[$info['map_id']];
        $lucky          = intval($info['lucky']) > 0 ? intval($info['lucky']) : 0;
        $return['money']      = intval($awardInfo['money'] * $time * (1 +  $lucky*0.02) * $dropThingsRate);
        $return['experience'] = intval($awardInfo['experience'] * $time * $dropThingsRate);
        $return['experience'] = $return['experience'] > 1 ? $return['experience'] : 1;

        User_Info::addExperience($info['user_id'], $return['experience']);
        User_Info::addMoney($info['user_id'], $return['money']);

        $levelUp = User_Info::isLevel($info['user_id']);
        if($levelUp) {
            $return['level_up'] = $levelUp;
        }
        $return['equipment'] = self::getEquipment($info, $time, $dropThingsRate);
        return $return;
    }

    public static function getAwardPerMinite() {
        return array(
            1 => array(
                'experience' => '306.825015',
                'money'      => '85.995',
            ),
            2 => array(
                'experience' => '525.74354',
                'money'      => '103.5533333',
            ),
            3 => array(
                'experience' => '744.662065',
                'money'      => '133.3616667',
            ),
            4 => array(
                'experience' => '963.58059',
                'money'      => '175.42',
            ),
            5 => array(
                'experience' => '1182.499115',
                'money'      => '229.7283333',
            ),
            6 => array(
                'experience' => '11401.41764',
                'money'      => '296.2866667',
            ),
            7 => array(
                'experience' => '1620.336165',
                'money'      => '375.095',
            ),
            8 => array(
                'experience' => '1839.25469',
                'money'      => '466.1533333',
            ),
            9 => array(
                'experience' => '2058.173215',
                'money'      => '569.4616667',
            ),
            10 => array(
                'experience' => '2277.09174',
                'money'      => '685.02',
            ),
            11 => array(
                'experience' => '2496.010265',
                'money'      => '812.8283333',
            ),
            12 => array(
                'experience' => '2714.92879',
                'money'      => '952.8866667',
            ),
            13 => array(
                'experience' => '2933.847315',
                'money'      => '1105.195',
            ),
            14 => array(
                'experience' => '3152.76584',
                'money'      => '1269.753333',
            ),
            15 => array(
                'experience' => '3371.684365',
                'money'      => '1446.561667',
            ),
            16 => array(
                'experience' => '3590.60289',
                'money'      => '1635.62',
            ),
            17 => array(
                'experience' => '3809.521415',
                'money'      => '1836.928333',
            ),
            18 => array(
                'experience' => '4028.43994',
                'money'      => '2050.486667',
            ),
            19 => array(
                'experience' => '4247.358465',
                'money'      => '2276.295',
            ),
            20 => array(
                'experience' => '4466.27699',
                'money'      => '2514.353333',
            ),
        );
    }

    public static function getEquipmentPerMinite() {
        return array(
            Equip::EQUIP_COLOUR_GRAY  => '0.040833333',
            Equip::EQUIP_COLOUR_WHITE => '0.040833333',
            Equip::EQUIP_COLOUR_GREEN => '0.026133333',
            Equip::EQUIP_COLOUR_BLUE  => '0.022866667',
            Equip::EQUIP_COLOUR_PURPLE=> '0.0196',
            Equip::EQUIP_COLOUR_ORANGE=> '0.003266667',
        );
    }

    public static function getEquipment($info, $time, $dropThingsRate) {
        $dropThingsRate = $dropThingsRate * 100 >= 0 && $dropThingsRate * 100 <=100 ? $dropThingsRate : 1;
        $equipmentNums = self::getEquipmentPerMinite();
        $userInfo = User_Info::getUserInfoByUserId($info['user_id']);
        foreach ($equipmentNums as $color => $num) {
            $equipmentNums[$color] = intval(($num * $time) * (rand(80, 120)/100) * $dropThingsRate);
            $getEquipSetting = Fight_Setting::isEquipMentCan($info['user_id']);
            if($equipmentNums[$color] >= 1 && $getEquipSetting[$color]) {
                for($i = 1; $i <= $equipmentNums[$color]; $i++) {
                    $equipment = array(
                        'color'     => $color,
                        'equipment' => rand(Equip::EQUIP_TYPE_ARMS, Equip::EQUIP_TYPE_SHOES),
                        'level'     => Monster::getMonsterEquipmentLevel($info['map_id']),
                    );
                    $equipmentNum = Equip_Info::getEquipNum($info['user_id']);
                    $equipmentSurplus = $userInfo['pack_num'] - intval($equipmentNum);
                    $equipmentSurplus = $equipmentSurplus > 0 ? $equipmentSurplus : 0;
                    $equipment['get'] = 0;
                    if($equipmentSurplus > 0) {
                        $get = Equip::createEquip($equipment['color'], $info['user_id'], $equipment['level'], $equipment['equipment']);
                        $equipment['get'] = 1;
                    }
                    $return[] = $equipment;
                }
            }
        }
        return $return;
    }
}