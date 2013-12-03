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

    public static function getResult($info, $time) {
        $awardInfos = self::getAwardPerMinite();
        $awardInfo  = $awardInfos[$info['map_id']];
        $lucky      = intval($info['lucky']) > 0 ? intval($info['lucky']) : 0;
        $return['money']      = intval($awardInfo['money'] * $time * (1 +  $lucky*0.02));
        $return['experience'] = intval($awardInfo['experience']*$time);

        User_Info::addExperience($info['user_id'], $return['experience']);
        User_Info::addMoney($info['user_id'], $return['money']);

        $levelUp = User_Info::isLevel($userId);
        if($levelUp) {
            $return['level_up'] = $levelUp;
        }
        $return['equipment'] = self::getEquipment($info, $time);
        return $return;
    }

    public static function getAwardPerMinite() {
        return array(
            1 => array(
                'experience' => '281.560905',
                'money'      => '0.3385395',
            ),
            2 => array(
                'experience' => '482.45358',
                'money'      => '0.407662',
            ),
            3 => array(
                'experience' => '683.346255',
                'money'      => '0.5250095',
            ),
            4 => array(
                'experience' => '884.23893',
                'money'      => '0.690582',
            ),
            5 => array(
                'experience' => '1085.131605',
                'money'      => '0.9043795',
            ),
            6 => array(
                'experience' => '1286.02428',
                'money'      => '1.166402',
            ),
            7 => array(
                'experience' => '1486.916955',
                'money'      => '1.4766495',
            ),
            8 => array(
                'experience' => '1687.80963',
                'money'      => '1.835122',
            ),
            9 => array(
                'experience' => '1888.702305',
                'money'      => '2.2418195',
            ),
            10 => array(
                'experience' => '2089.59498',
                'money'      => '2.696742',
            ),
            11 => array(
                'experience' => '2290.487655',
                'money'      => '3.1998895',
            ),
            12 => array(
                'experience' => '2491.38033',
                'money'      => '3.751262',
            ),
            13 => array(
                'experience' => '2692.273005',
                'money'      => '4.3508595',
            ),
            14 => array(
                'experience' => '2893.16568',
                'money'      => '4.998682',
            ),
            15 => array(
                'experience' => '3094.058355',
                'money'      => '5.6947295',
            ),
            16 => array(
                'experience' => '3294.95103',
                'money'      => '6.439002',
            ),
            17 => array(
                'experience' => '3495.843705',
                'money'      => '7.2314995',
            ),
            18 => array(
                'experience' => '3696.73638',
                'money'      => '8.072222',
            ),
            19 => array(
                'experience' => '3897.629055',
                'money'      => '8.9611695',
            ),
            20 => array(
                'experience' => '4098.52173',
                'money'      => '9.898342',
            ),
        );
    }

    public static function getEquipmentPerMinite() {
        return array(
            Equip::EQUIP_COLOUR_GRAY  => '0.0093',
            Equip::EQUIP_COLOUR_WHITE => '0.0093',
            Equip::EQUIP_COLOUR_GREEN => '0.0045',
            Equip::EQUIP_COLOUR_BLUE  => '0.00432',
            Equip::EQUIP_COLOUR_ORANGE=> '0.00008',
        );
    }

    public static function getEquipment($info, $time) {
        $equipmentNums = self::getEquipmentPerMinite();
        $userInfo = User_Info::getUserInfoByUserId($info['user_id']);
        foreach ($equipmentNums as $color => $num) {
            $equipmentNums[$color] = intval(($num * $time) * (rand(80, 120)/100));
            if($equipmentNums[$color] >= 1) {
                for($i = 1; $i <= $equipmentNums[$color]; $i++) {
                    $equipment = array(
                        'color'     => $color,
                        'equipment' => rand(1, 6),
                        'level'     => Monster::getMonsterEquipmentLevel($info['map_id']),
                    );
                    $equipmentNum = Equip_Info::getEquipNum($info['user_id']);
                    $equipmentSurplus = $userInfo['pack_num'] - intval($equipmentNum);
                    $equipmentSurplus = $equipmentSurplus > 0 ? $equipmentSurplus : 0;
                    $equipment['get'] = 0;
                    if($equipmentSurplus > 0) {
                        $get = Equip::createEquip($equipment['color'], $info['user_id'], $equipment['level']);
                        $equipment['get'] = 1;
                    }
                    $return[] = $equipment;
                }
            }
        }
        return $return;
    }
}