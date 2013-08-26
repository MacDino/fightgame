/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50150
Source Host           : 127.0.0.1:3306
Source Database       : app_fightgame

Target Server Type    : MYSQL
Target Server Version : 50150
File Encoding         : 65001

Date: 2013-08-26 15:46:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `attribute_enhance`
-- ----------------------------
DROP TABLE IF EXISTS `attribute_enhance`;
CREATE TABLE `attribute_enhance` (
  `user_id` int(11) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '使用时间,时间戳格式',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attribute_enhance
-- ----------------------------

-- ----------------------------
-- Table structure for `auto_fight`
-- ----------------------------
DROP TABLE IF EXISTS `auto_fight`;
CREATE TABLE `auto_fight` (
  `user_id` int(11) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '添加时间,时间戳格式',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auto_fight
-- ----------------------------

-- ----------------------------
-- Table structure for `double_harvest`
-- ----------------------------
DROP TABLE IF EXISTS `double_harvest`;
CREATE TABLE `double_harvest` (
  `user_id` int(11) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '添加时间,时间戳格式',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of double_harvest
-- ----------------------------

-- ----------------------------
-- Table structure for `equip_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `equip_attributes`;
CREATE TABLE `equip_attributes` (
  `equip_attributes_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '装备基本属性ID',
  `equip_id` int(11) NOT NULL COMMENT '装备ID',
  `base_attribute` varchar(200) NOT NULL COMMENT '基本属性',
  `attribute_id` int(11) NOT NULL COMMENT '用户属性，参考ConfigDefine',
  `level_begin` int(11) NOT NULL COMMENT '等级开始',
  `level_end` int(11) NOT NULL COMMENT '等级结束',
  `attributes_begin` int(11) NOT NULL COMMENT '属性点开始',
  `attributes_end` int(11) NOT NULL COMMENT '属性点结束',
  PRIMARY KEY (`equip_attributes_id`)
) ENGINE=MyISAM AUTO_INCREMENT=311 DEFAULT CHARSET=utf8

-- ----------------------------
-- Records of equid_attributes
-- ----------------------------

-- ----------------------------
-- Table structure for `friend_info`
-- ----------------------------
DROP TABLE IF EXISTS `friend_info`;
CREATE TABLE `friend_info` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `channel` enum('sina','weixin','lbs','game') DEFAULT 'game' COMMENT '添加来源',
  `is_pass` enum('2','1') DEFAULT '1' COMMENT '1未通过2通过',
  PRIMARY KEY (`user_id`,`friend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of friend_info
-- ----------------------------

-- ----------------------------
-- Table structure for `level_allow_skill_num`
-- ----------------------------
DROP TABLE IF EXISTS `level_allow_skill_num`;
CREATE TABLE `level_allow_skill_num` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL COMMENT '等级',
  `allow_gj` int(11) NOT NULL COMMENT '允许使用攻击技能数量',
  `allow_fy` int(11) NOT NULL COMMENT '允许使用防御技能数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of level_allow_skill_num
-- ----------------------------

-- ----------------------------
-- Table structure for `level_info`
-- ----------------------------
DROP TABLE IF EXISTS `level_info`;
CREATE TABLE `level_info` (
  `level` int(11) NOT NULL AUTO_INCREMENT COMMENT '等级',
  `need_experience` int(11) NOT NULL COMMENT '所需经验数',
  PRIMARY KEY (`level`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of level_info
-- ----------------------------

-- ----------------------------
-- Table structure for `level_skill_point`
-- ----------------------------
DROP TABLE IF EXISTS `level_skill_point`;
CREATE TABLE `level_skill_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL COMMENT '等级',
  `point_num` int(11) NOT NULL COMMENT '技能点数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of level_skill_point
-- ----------------------------

-- ----------------------------
-- Table structure for `map_list`
-- ----------------------------
DROP TABLE IF EXISTS `map_list`;
CREATE TABLE `map_list` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地图ID',
  `map_name` varchar(200) NOT NULL COMMENT '地图名称',
  `map_race_id` int(11) NOT NULL COMMENT '地图种族ID(race_id)',
  `start_level` int(11) NOT NULL COMMENT '开始等级',
  `end_level` int(11) NOT NULL COMMENT '结束等级',
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of map_list
-- ----------------------------

-- ----------------------------
-- Table structure for `map_monster`
-- ----------------------------
DROP TABLE IF EXISTS `map_monster`;
CREATE TABLE `map_monster` (
  `monster_id` int(11) NOT NULL AUTO_INCREMENT,
  `monster_name` varchar(200) NOT NULL,
  PRIMARY KEY (`monster_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of map_monster
-- ----------------------------

-- ----------------------------
-- Table structure for `property_info`
-- ----------------------------
DROP TABLE IF EXISTS `property_info`;
CREATE TABLE `property_info` (
  `user_id` int(11) NOT NULL,
  `property_id` tinyint(1) NOT NULL COMMENT '道具ID',
  `property_num` int(3) DEFAULT '0' COMMENT '道具数量',
  `last_time` int(11) DEFAULT NULL COMMENT '最后购买时间',
  PRIMARY KEY (`user_id`,`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of property_info
-- ----------------------------

-- ----------------------------
-- Table structure for `user_bind`
-- ----------------------------
DROP TABLE IF EXISTS `user_bind`;
CREATE TABLE `user_bind` (
  `master_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '账户ID',
  `bind_type` varchar(4) NOT NULL COMMENT '绑定类型',
  `bind_value` varchar(500) NOT NULL COMMENT '绑定值',
  PRIMARY KEY (`master_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='用户绑定表';

-- ----------------------------
-- Records of user_bind
-- ----------------------------

-- ----------------------------
-- Table structure for `user_equip`
-- ----------------------------
DROP TABLE IF EXISTS `user_equip`;
CREATE TABLE `user_equip` (
  `user_equip_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户装备ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `equip_colour` int(11) NOT NULL COMMENT '装备品质ID',
  `equip_type` int(11) NOT NULL COMMENT '装备名称ID',
  `equip_level` int(11) NOT NULL COMMENT '装备等级',
  `is_used` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否被使用',
  `race_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '种族ID',
  `attribute_list` text NOT NULL COMMENT '扩展属性',
  `attribute_base_list` text NOT NULL COMMENT '基本属性信息',
  PRIMARY KEY (`user_equip_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='用户装备列表'

-- ----------------------------
-- Records of user_equip
-- ----------------------------

-- ----------------------------
-- Table structure for `user_info`
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `race_id` int(11) NOT NULL COMMENT '角色ID',
  `user_level` int(11) DEFAULT NULL COMMENT '等级',
  `experience` int(11) DEFAULT NULL COMMENT '经验',
  `money` int(11) DEFAULT NULL COMMENT '金钱,以分为单位',
  `ingot` int(11) DEFAULT NULL COMMENT '元宝数量',
  `skil_point` int(11) NOT NULL COMMENT '技能点',
  `pack_num` int(11) DEFAULT NULL COMMENT '背包数量',
  `pk_num` int(11) NOT NULL COMMENT 'PK次数',
  `friend_num` int(11) NOT NULL COMMENT '好友数量',
  `pet_num` int(11) NOT NULL COMMENT '人宠数量',
  `master_id` int(11) NOT NULL COMMENT '帐号ID',
  `area` int(2) DEFAULT '1' COMMENT '分区',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='用户信息';

-- ----------------------------
-- Records of user_info
-- ----------------------------

-- ----------------------------
-- Table structure for `version_list`
-- ----------------------------
DROP TABLE IF EXISTS `version_list`;
CREATE TABLE `version_list` (
  `version_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_key` varchar(200) NOT NULL,
  `version_value` int(11) NOT NULL,
  `parent_version_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  PRIMARY KEY (`version_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of version_list
-- ----------------------------

--
-- Table structure for table `level_skill_money`
--

DROP TABLE IF EXISTS `level_skill_money`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level_skill_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_level` tinyint(4) NOT NULL COMMENT '技能等级',
  `money` int(11) NOT NULL COMMENT '对应等级消耗的铜钱',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_skill`
--

DROP TABLE IF EXISTS `user_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `skill_level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
