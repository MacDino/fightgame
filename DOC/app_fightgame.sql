/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50150
Source Host           : localhost:3306
Source Database       : app_fightgame

Target Server Type    : MYSQL
Target Server Version : 50150
File Encoding         : 65001

Date: 2013-09-23 17:16:49
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
-- Table structure for `integral_info`
-- ----------------------------
DROP TABLE IF EXISTS `integral_info`;
CREATE TABLE `integral_info` (
  `user_id` int(11) NOT NULL,
  `before` int(11) DEFAULT NULL COMMENT '变化前',
  `num` int(11) DEFAULT NULL COMMENT '数量',
  `after` int(11) DEFAULT NULL COMMENT '变化后',
  `type` tinyint(1) DEFAULT '0' COMMENT '积分增减(1增加,2减少,3不变)',
  `action` tinyint(1) DEFAULT NULL COMMENT '动作(1战斗奖励,2积分抽奖)',
  `time` int(11) DEFAULT NULL COMMENT '时间戳',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of integral_info

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
) ENGINE=MyISAM AUTO_INCREMENT=311 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of equip_attributes
-- ----------------------------
INSERT INTO `equip_attributes` VALUES ('1', '3901', '3705', '1106', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('2', '3901', '3705', '1107', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('3', '3901', '3706', '1106', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('4', '3901', '3706', '1107', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('5', '3901', '3707', '1106', '0', '9', '20', '34');
INSERT INTO `equip_attributes` VALUES ('6', '3901', '3707', '1107', '0', '9', '15', '26');
INSERT INTO `equip_attributes` VALUES ('7', '3901', '3705', '1106', '10', '19', '40', '68');
INSERT INTO `equip_attributes` VALUES ('8', '3901', '3705', '1107', '10', '19', '28', '48');
INSERT INTO `equip_attributes` VALUES ('9', '3901', '3706', '1106', '10', '19', '45', '58');
INSERT INTO `equip_attributes` VALUES ('10', '3901', '3706', '1107', '10', '19', '40', '52');
INSERT INTO `equip_attributes` VALUES ('11', '3901', '3707', '1106', '10', '19', '47', '60');
INSERT INTO `equip_attributes` VALUES ('12', '3901', '3707', '1107', '10', '19', '42', '54');
INSERT INTO `equip_attributes` VALUES ('13', '3901', '3705', '1106', '20', '29', '64', '109');
INSERT INTO `equip_attributes` VALUES ('14', '3901', '3705', '1107', '20', '29', '48', '82');
INSERT INTO `equip_attributes` VALUES ('15', '3901', '3706', '1106', '20', '29', '80', '104');
INSERT INTO `equip_attributes` VALUES ('16', '3901', '3706', '1107', '20', '29', '70', '91');
INSERT INTO `equip_attributes` VALUES ('17', '3901', '3707', '1106', '20', '29', '84', '109');
INSERT INTO `equip_attributes` VALUES ('18', '3901', '3707', '1107', '20', '29', '73', '95');
INSERT INTO `equip_attributes` VALUES ('19', '3901', '3705', '1106', '30', '39', '88', '105');
INSERT INTO `equip_attributes` VALUES ('20', '3901', '3705', '1107', '30', '39', '68', '116');
INSERT INTO `equip_attributes` VALUES ('21', '3901', '3706', '1106', '30', '39', '115', '149');
INSERT INTO `equip_attributes` VALUES ('22', '3901', '3706', '1107', '30', '39', '100', '130');
INSERT INTO `equip_attributes` VALUES ('23', '3901', '3706', '1106', '30', '39', '115', '149');
INSERT INTO `equip_attributes` VALUES ('24', '3901', '3706', '1107', '30', '39', '100', '130');
INSERT INTO `equip_attributes` VALUES ('25', '3901', '3705', '1106', '40', '49', '112', '190');
INSERT INTO `equip_attributes` VALUES ('26', '3901', '3705', '1107', '40', '49', '88', '150');
INSERT INTO `equip_attributes` VALUES ('27', '3901', '3706', '1106', '40', '49', '150', '195');
INSERT INTO `equip_attributes` VALUES ('28', '3901', '3706', '1107', '40', '49', '130', '169');
INSERT INTO `equip_attributes` VALUES ('29', '3901', '3707', '1106', '40', '49', '157', '204');
INSERT INTO `equip_attributes` VALUES ('30', '3901', '3707', '1107', '40', '49', '136', '177');
INSERT INTO `equip_attributes` VALUES ('31', '3901', '3705', '1106', '50', '59', '136', '231');
INSERT INTO `equip_attributes` VALUES ('32', '3901', '3705', '1107', '50', '59', '108', '184');
INSERT INTO `equip_attributes` VALUES ('33', '3901', '3706', '1106', '50', '59', '185', '240');
INSERT INTO `equip_attributes` VALUES ('34', '3901', '3706', '1107', '50', '59', '160', '208');
INSERT INTO `equip_attributes` VALUES ('35', '3901', '3707', '1106', '50', '59', '194', '252');
INSERT INTO `equip_attributes` VALUES ('36', '3901', '3707', '1107', '50', '59', '168', '218');
INSERT INTO `equip_attributes` VALUES ('37', '3901', '3705', '1106', '60', '69', '160', '272');
INSERT INTO `equip_attributes` VALUES ('38', '3901', '3705', '1107', '60', '69', '128', '218');
INSERT INTO `equip_attributes` VALUES ('39', '3901', '3706', '1106', '60', '69', '220', '286');
INSERT INTO `equip_attributes` VALUES ('40', '3901', '3706', '1107', '60', '69', '190', '247');
INSERT INTO `equip_attributes` VALUES ('41', '3901', '3707', '1106', '60', '69', '231', '300');
INSERT INTO `equip_attributes` VALUES ('42', '3901', '3707', '1107', '60', '69', '199', '259');
INSERT INTO `equip_attributes` VALUES ('43', '3901', '3705', '1106', '70', '79', '184', '313');
INSERT INTO `equip_attributes` VALUES ('44', '3901', '3705', '1107', '70', '79', '148', '252');
INSERT INTO `equip_attributes` VALUES ('45', '3901', '3706', '1106', '70', '79', '255', '331');
INSERT INTO `equip_attributes` VALUES ('46', '3901', '3706', '1107', '70', '79', '220', '286');
INSERT INTO `equip_attributes` VALUES ('47', '3901', '3707', '1106', '70', '79', '267', '347');
INSERT INTO `equip_attributes` VALUES ('48', '3901', '3707', '1107', '70', '79', '231', '300');
INSERT INTO `equip_attributes` VALUES ('49', '3901', '3705', '1106', '80', '89', '208', '354');
INSERT INTO `equip_attributes` VALUES ('50', '3901', '3705', '1107', '80', '89', '168', '286');
INSERT INTO `equip_attributes` VALUES ('51', '3901', '3706', '1106', '80', '89', '290', '377');
INSERT INTO `equip_attributes` VALUES ('52', '3901', '3706', '1107', '80', '89', '250', '325');
INSERT INTO `equip_attributes` VALUES ('53', '3901', '3707', '1106', '80', '89', '304', '395');
INSERT INTO `equip_attributes` VALUES ('54', '3901', '3707', '1107', '80', '89', '262', '341');
INSERT INTO `equip_attributes` VALUES ('55', '3901', '3706', '1106', '90', '99', '325', '422');
INSERT INTO `equip_attributes` VALUES ('56', '3901', '3706', '1107', '90', '99', '280', '364');
INSERT INTO `equip_attributes` VALUES ('57', '3901', '3707', '1106', '90', '99', '341', '443');
INSERT INTO `equip_attributes` VALUES ('58', '3901', '3707', '1107', '90', '99', '294', '382');
INSERT INTO `equip_attributes` VALUES ('59', '3901', '3706', '1106', '100', '109', '360', '468');
INSERT INTO `equip_attributes` VALUES ('60', '3901', '3706', '1107', '100', '109', '310', '403');
INSERT INTO `equip_attributes` VALUES ('61', '3901', '3707', '1106', '100', '109', '378', '491');
INSERT INTO `equip_attributes` VALUES ('62', '3901', '3707', '1107', '100', '109', '325', '423');
INSERT INTO `equip_attributes` VALUES ('63', '3902', '3705', '1112', '0', '9', '2', '5');
INSERT INTO `equip_attributes` VALUES ('64', '3902', '3705', '1108', '0', '9', '0', '0');
INSERT INTO `equip_attributes` VALUES ('65', '3902', '3706', '1112', '0', '9', '2', '5');
INSERT INTO `equip_attributes` VALUES ('66', '3902', '3706', '1108', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('67', '3902', '3707', '1112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('68', '3902', '3707', '1108', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('69', '3902', '3705', '1112', '10', '19', '6', '14');
INSERT INTO `equip_attributes` VALUES ('70', '3902', '3705', '1108', '10', '19', '10', '15');
INSERT INTO `equip_attributes` VALUES ('71', '3902', '3706', '1112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('72', '3902', '3706', '1108', '10', '19', '15', '19');
INSERT INTO `equip_attributes` VALUES ('73', '3902', '3707', '1112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('74', '3902', '3707', '1108', '10', '19', '15', '20');
INSERT INTO `equip_attributes` VALUES ('75', '3902', '3705', '1112', '20', '29', '10', '17');
INSERT INTO `equip_attributes` VALUES ('76', '3902', '3705', '1108', '20', '29', '20', '29');
INSERT INTO `equip_attributes` VALUES ('77', '3902', '3706', '1112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('78', '3902', '3706', '1108', '20', '29', '25', '32');
INSERT INTO `equip_attributes` VALUES ('79', '3902', '3707', '1112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('80', '3902', '3707', '1108', '20', '29', '26', '34');
INSERT INTO `equip_attributes` VALUES ('81', '3902', '3705', '1112', '30', '39', '88', '105');
INSERT INTO `equip_attributes` VALUES ('82', '3902', '3705', '1108', '30', '39', '68', '116');
INSERT INTO `equip_attributes` VALUES ('83', '3902', '3706', '1112', '30', '39', '115', '149');
INSERT INTO `equip_attributes` VALUES ('84', '3902', '3706', '1108', '30', '39', '100', '130');
INSERT INTO `equip_attributes` VALUES ('85', '3902', '3707', '1112', '30', '39', '120', '156');
INSERT INTO `equip_attributes` VALUES ('86', '3902', '3707', '1108', '30', '39', '105', '136');
INSERT INTO `equip_attributes` VALUES ('87', '3902', '3705', '1112', '40', '49', '112', '190');
INSERT INTO `equip_attributes` VALUES ('88', '3902', '3705', '1108', '40', '49', '88', '150');
INSERT INTO `equip_attributes` VALUES ('89', '3902', '3706', '1112', '40', '49', '150', '195');
INSERT INTO `equip_attributes` VALUES ('90', '3902', '3706', '1108', '40', '49', '130', '169');
INSERT INTO `equip_attributes` VALUES ('91', '3902', '3707', '1112', '40', '49', '157', '204');
INSERT INTO `equip_attributes` VALUES ('92', '3902', '3707', '1108', '40', '49', '136', '177');
INSERT INTO `equip_attributes` VALUES ('93', '3902', '3705', '1112', '50', '59', '136', '231');
INSERT INTO `equip_attributes` VALUES ('94', '3902', '3705', '1108', '50', '59', '108', '184');
INSERT INTO `equip_attributes` VALUES ('95', '3902', '3706', '1112', '50', '59', '185', '240');
INSERT INTO `equip_attributes` VALUES ('96', '3902', '3706', '1108', '50', '59', '160', '208');
INSERT INTO `equip_attributes` VALUES ('97', '3902', '3707', '1112', '50', '59', '194', '252');
INSERT INTO `equip_attributes` VALUES ('98', '3902', '3707', '1108', '50', '59', '168', '218');
INSERT INTO `equip_attributes` VALUES ('99', '3902', '3705', '1112', '60', '69', '160', '272');
INSERT INTO `equip_attributes` VALUES ('100', '3902', '3705', '1108', '60', '69', '128', '218');
INSERT INTO `equip_attributes` VALUES ('101', '3902', '3706', '1112', '60', '69', '220', '286');
INSERT INTO `equip_attributes` VALUES ('102', '3902', '3706', '1108', '60', '69', '190', '247');
INSERT INTO `equip_attributes` VALUES ('103', '3902', '3707', '1112', '60', '69', '231', '300');
INSERT INTO `equip_attributes` VALUES ('104', '3902', '3707', '1108', '60', '69', '199', '259');
INSERT INTO `equip_attributes` VALUES ('105', '3902', '3705', '1112', '70', '79', '184', '313');
INSERT INTO `equip_attributes` VALUES ('106', '3902', '3705', '1108', '70', '79', '148', '252');
INSERT INTO `equip_attributes` VALUES ('107', '3902', '3706', '1112', '70', '79', '255', '331');
INSERT INTO `equip_attributes` VALUES ('108', '3902', '3706', '1108', '70', '79', '220', '286');
INSERT INTO `equip_attributes` VALUES ('109', '3902', '3707', '1112', '70', '79', '267', '347');
INSERT INTO `equip_attributes` VALUES ('110', '3902', '3707', '1108', '70', '79', '231', '300');
INSERT INTO `equip_attributes` VALUES ('111', '3902', '3705', '1112', '80', '89', '208', '354');
INSERT INTO `equip_attributes` VALUES ('112', '3902', '3705', '1108', '80', '89', '168', '286');
INSERT INTO `equip_attributes` VALUES ('113', '3902', '3706', '1112', '80', '89', '290', '377');
INSERT INTO `equip_attributes` VALUES ('114', '3902', '3706', '1108', '80', '89', '250', '325');
INSERT INTO `equip_attributes` VALUES ('115', '3902', '3707', '1112', '80', '89', '304', '395');
INSERT INTO `equip_attributes` VALUES ('116', '3902', '3707', '1108', '80', '89', '262', '341');
INSERT INTO `equip_attributes` VALUES ('117', '3902', '3706', '1112', '90', '99', '325', '422');
INSERT INTO `equip_attributes` VALUES ('118', '3902', '3706', '1108', '90', '99', '280', '364');
INSERT INTO `equip_attributes` VALUES ('119', '3902', '3707', '1112', '90', '99', '341', '443');
INSERT INTO `equip_attributes` VALUES ('120', '3902', '3707', '1108', '90', '99', '294', '382');
INSERT INTO `equip_attributes` VALUES ('121', '3902', '3706', '1112', '100', '109', '360', '468');
INSERT INTO `equip_attributes` VALUES ('122', '3902', '3706', '1108', '100', '109', '310', '403');
INSERT INTO `equip_attributes` VALUES ('123', '3902', '3707', '1112', '100', '109', '378', '491');
INSERT INTO `equip_attributes` VALUES ('124', '3902', '3707', '1108', '100', '109', '325', '423');
INSERT INTO `equip_attributes` VALUES ('125', '3903', '3705', '1110', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('126', '3903', '3706', '1110', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('127', '3903', '3707', '1110', '0', '9', '5', '8');
INSERT INTO `equip_attributes` VALUES ('128', '3903', '3705', '1110', '10', '19', '12', '20');
INSERT INTO `equip_attributes` VALUES ('129', '3903', '3706', '1110', '10', '19', '17', '22');
INSERT INTO `equip_attributes` VALUES ('130', '3903', '3707', '1110', '10', '19', '17', '23');
INSERT INTO `equip_attributes` VALUES ('131', '3903', '3705', '1110', '20', '29', '19', '32');
INSERT INTO `equip_attributes` VALUES ('132', '3903', '3706', '1110', '20', '29', '29', '37');
INSERT INTO `equip_attributes` VALUES ('133', '3903', '3707', '1110', '20', '29', '30', '38');
INSERT INTO `equip_attributes` VALUES ('134', '3903', '3705', '1110', '30', '39', '27', '45');
INSERT INTO `equip_attributes` VALUES ('135', '3903', '3706', '1110', '30', '39', '41', '53');
INSERT INTO `equip_attributes` VALUES ('136', '3903', '3707', '1110', '30', '39', '43', '55');
INSERT INTO `equip_attributes` VALUES ('137', '3903', '3705', '1110', '40', '49', '34', '57');
INSERT INTO `equip_attributes` VALUES ('138', '3903', '3706', '1110', '40', '49', '53', '68');
INSERT INTO `equip_attributes` VALUES ('139', '3903', '3707', '1110', '40', '49', '55', '71');
INSERT INTO `equip_attributes` VALUES ('140', '3903', '3705', '1110', '50', '59', '45', '76');
INSERT INTO `equip_attributes` VALUES ('141', '3903', '3706', '1110', '50', '59', '65', '84');
INSERT INTO `equip_attributes` VALUES ('142', '3903', '3707', '1110', '50', '59', '68', '88');
INSERT INTO `equip_attributes` VALUES ('143', '3903', '3705', '1110', '60', '69', '56', '95');
INSERT INTO `equip_attributes` VALUES ('144', '3903', '3706', '1110', '60', '69', '77', '100');
INSERT INTO `equip_attributes` VALUES ('145', '3903', '3707', '1110', '60', '69', '80', '105');
INSERT INTO `equip_attributes` VALUES ('146', '3903', '3705', '1110', '70', '79', '65', '110');
INSERT INTO `equip_attributes` VALUES ('147', '3903', '3706', '1110', '70', '79', '89', '115');
INSERT INTO `equip_attributes` VALUES ('148', '3903', '3707', '1110', '70', '79', '93', '120');
INSERT INTO `equip_attributes` VALUES ('149', '3903', '3705', '1110', '80', '89', '77', '130');
INSERT INTO `equip_attributes` VALUES ('150', '3903', '3706', '1110', '80', '89', '101', '131');
INSERT INTO `equip_attributes` VALUES ('151', '3903', '3707', '1110', '80', '89', '106', '137');
INSERT INTO `equip_attributes` VALUES ('152', '3903', '3706', '1110', '90', '99', '113', '146');
INSERT INTO `equip_attributes` VALUES ('153', '3903', '3707', '1110', '90', '99', '118', '153');
INSERT INTO `equip_attributes` VALUES ('154', '3903', '3706', '1110', '100', '109', '125', '162');
INSERT INTO `equip_attributes` VALUES ('155', '3903', '3707', '1110', '100', '109', '131', '170');
INSERT INTO `equip_attributes` VALUES ('156', '3904', '3705', '1112', '0', '9', '8', '14');
INSERT INTO `equip_attributes` VALUES ('157', '3904', '3706', '1112', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('158', '3904', '3707', '1112', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('159', '3904', '3705', '1112', '10', '19', '20', '34');
INSERT INTO `equip_attributes` VALUES ('160', '3904', '3706', '1112', '10', '19', '25', '32');
INSERT INTO `equip_attributes` VALUES ('161', '3904', '3707', '1112', '10', '19', '26', '33');
INSERT INTO `equip_attributes` VALUES ('162', '3904', '3705', '1112', '20', '29', '29', '49');
INSERT INTO `equip_attributes` VALUES ('163', '3904', '3706', '1112', '20', '29', '40', '52');
INSERT INTO `equip_attributes` VALUES ('164', '3904', '3707', '1112', '20', '29', '42', '54');
INSERT INTO `equip_attributes` VALUES ('165', '3904', '3705', '1112', '30', '39', '40', '68');
INSERT INTO `equip_attributes` VALUES ('166', '3904', '3706', '1112', '30', '39', '55', '71');
INSERT INTO `equip_attributes` VALUES ('167', '3904', '3707', '1112', '30', '39', '57', '74');
INSERT INTO `equip_attributes` VALUES ('168', '3904', '3705', '1112', '40', '49', '56', '95');
INSERT INTO `equip_attributes` VALUES ('169', '3904', '3706', '1112', '40', '49', '70', '91');
INSERT INTO `equip_attributes` VALUES ('170', '3904', '3707', '1112', '40', '49', '73', '95');
INSERT INTO `equip_attributes` VALUES ('171', '3904', '3705', '1112', '50', '59', '64', '109');
INSERT INTO `equip_attributes` VALUES ('172', '3904', '3706', '1112', '50', '59', '85', '110');
INSERT INTO `equip_attributes` VALUES ('173', '3904', '3707', '1112', '50', '59', '89', '115');
INSERT INTO `equip_attributes` VALUES ('174', '3904', '3705', '1112', '60', '69', '80', '136');
INSERT INTO `equip_attributes` VALUES ('175', '3904', '3706', '1112', '60', '69', '100', '130');
INSERT INTO `equip_attributes` VALUES ('176', '3904', '3707', '1112', '60', '69', '105', '136');
INSERT INTO `equip_attributes` VALUES ('177', '3904', '3705', '1112', '70', '79', '88', '150');
INSERT INTO `equip_attributes` VALUES ('178', '3904', '3706', '1112', '70', '79', '115', '149');
INSERT INTO `equip_attributes` VALUES ('179', '3904', '3707', '1112', '70', '79', '120', '156');
INSERT INTO `equip_attributes` VALUES ('180', '3904', '3705', '1112', '80', '89', '100', '170');
INSERT INTO `equip_attributes` VALUES ('181', '3904', '3706', '1112', '80', '89', '130', '169');
INSERT INTO `equip_attributes` VALUES ('182', '3904', '3707', '1112', '80', '89', '136', '177');
INSERT INTO `equip_attributes` VALUES ('183', '3904', '3706', '1112', '90', '99', '145', '188');
INSERT INTO `equip_attributes` VALUES ('184', '3904', '3707', '1112', '90', '99', '152', '197');
INSERT INTO `equip_attributes` VALUES ('185', '3904', '3706', '1112', '100', '109', '160', '208');
INSERT INTO `equip_attributes` VALUES ('186', '3904', '3707', '1112', '100', '109', '168', '218');
INSERT INTO `equip_attributes` VALUES ('187', '3905', '3705', '1112', '0', '9', '4', '6');
INSERT INTO `equip_attributes` VALUES ('188', '3905', '3705', '1109', '0', '9', '0', '0');
INSERT INTO `equip_attributes` VALUES ('189', '3905', '3706', '1112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('190', '3905', '3706', '1109', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('191', '3905', '3707', '1112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('192', '3905', '3707', '1109', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('193', '3905', '3705', '1112', '10', '19', '8', '13');
INSERT INTO `equip_attributes` VALUES ('194', '3905', '3705', '1109', '10', '19', '20', '34');
INSERT INTO `equip_attributes` VALUES ('195', '3905', '3706', '1112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('196', '3905', '3706', '1109', '10', '19', '30', '39');
INSERT INTO `equip_attributes` VALUES ('197', '3905', '3707', '1112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('198', '3905', '3707', '1109', '10', '19', '31', '40');
INSERT INTO `equip_attributes` VALUES ('199', '3905', '3705', '1112', '20', '29', '10', '17');
INSERT INTO `equip_attributes` VALUES ('200', '3905', '3705', '1109', '20', '29', '40', '68');
INSERT INTO `equip_attributes` VALUES ('201', '3905', '3706', '1112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('202', '3905', '3706', '1109', '20', '29', '50', '65');
INSERT INTO `equip_attributes` VALUES ('203', '3905', '3707', '1112', '20', '29', '15', '20');
INSERT INTO `equip_attributes` VALUES ('204', '3905', '3707', '1109', '20', '29', '52', '68');
INSERT INTO `equip_attributes` VALUES ('205', '3905', '3705', '1112', '30', '39', '14', '23');
INSERT INTO `equip_attributes` VALUES ('206', '3905', '3705', '1109', '30', '39', '60', '102');
INSERT INTO `equip_attributes` VALUES ('207', '3905', '3706', '1112', '30', '39', '20', '26');
INSERT INTO `equip_attributes` VALUES ('208', '3905', '3706', '1109', '30', '39', '70', '91');
INSERT INTO `equip_attributes` VALUES ('209', '3905', '3707', '1112', '30', '39', '21', '27');
INSERT INTO `equip_attributes` VALUES ('210', '3905', '3707', '1109', '30', '39', '73', '95');
INSERT INTO `equip_attributes` VALUES ('211', '3905', '3705', '1112', '40', '49', '18', '30');
INSERT INTO `equip_attributes` VALUES ('212', '3905', '3705', '1109', '40', '49', '80', '136');
INSERT INTO `equip_attributes` VALUES ('213', '3905', '3706', '1112', '40', '49', '25', '32');
INSERT INTO `equip_attributes` VALUES ('214', '3905', '3706', '1109', '40', '49', '90', '117');
INSERT INTO `equip_attributes` VALUES ('215', '3905', '3707', '1112', '40', '49', '26', '34');
INSERT INTO `equip_attributes` VALUES ('216', '3905', '3707', '1109', '40', '49', '94', '122');
INSERT INTO `equip_attributes` VALUES ('217', '3905', '3705', '1112', '50', '59', '22', '37');
INSERT INTO `equip_attributes` VALUES ('218', '3905', '3705', '1109', '50', '59', '100', '170');
INSERT INTO `equip_attributes` VALUES ('219', '3905', '3706', '1112', '50', '59', '30', '39');
INSERT INTO `equip_attributes` VALUES ('220', '3905', '3706', '1109', '50', '59', '110', '143');
INSERT INTO `equip_attributes` VALUES ('221', '3905', '3707', '1112', '50', '59', '31', '40');
INSERT INTO `equip_attributes` VALUES ('222', '3905', '3707', '1109', '50', '59', '115', '150');
INSERT INTO `equip_attributes` VALUES ('223', '3905', '3705', '1112', '60', '69', '26', '44');
INSERT INTO `equip_attributes` VALUES ('224', '3905', '3705', '1109', '60', '69', '120', '204');
INSERT INTO `equip_attributes` VALUES ('225', '3905', '3706', '1112', '60', '69', '35', '45');
INSERT INTO `equip_attributes` VALUES ('226', '3905', '3706', '1109', '60', '69', '130', '169');
INSERT INTO `equip_attributes` VALUES ('227', '3905', '3707', '1112', '60', '69', '36', '47');
INSERT INTO `equip_attributes` VALUES ('228', '3905', '3707', '1109', '60', '69', '136', '177');
INSERT INTO `equip_attributes` VALUES ('229', '3905', '3705', '1112', '70', '79', '30', '51');
INSERT INTO `equip_attributes` VALUES ('230', '3905', '3705', '1109', '70', '79', '140', '238');
INSERT INTO `equip_attributes` VALUES ('231', '3905', '3706', '1112', '70', '79', '40', '52');
INSERT INTO `equip_attributes` VALUES ('232', '3905', '3706', '1109', '70', '79', '150', '195');
INSERT INTO `equip_attributes` VALUES ('233', '3905', '3707', '1112', '70', '79', '42', '54');
INSERT INTO `equip_attributes` VALUES ('234', '3905', '3707', '1109', '70', '79', '157', '204');
INSERT INTO `equip_attributes` VALUES ('235', '3905', '3705', '1112', '80', '89', '34', '57');
INSERT INTO `equip_attributes` VALUES ('236', '3905', '3705', '1109', '80', '89', '160', '272');
INSERT INTO `equip_attributes` VALUES ('237', '3905', '3706', '1112', '80', '89', '45', '58');
INSERT INTO `equip_attributes` VALUES ('238', '3905', '3706', '1109', '80', '89', '170', '221');
INSERT INTO `equip_attributes` VALUES ('239', '3905', '3707', '1112', '80', '89', '47', '61');
INSERT INTO `equip_attributes` VALUES ('240', '3905', '3707', '1109', '80', '89', '178', '232');
INSERT INTO `equip_attributes` VALUES ('241', '3905', '3706', '1112', '90', '99', '50', '65');
INSERT INTO `equip_attributes` VALUES ('242', '3905', '3706', '1109', '90', '99', '190', '247');
INSERT INTO `equip_attributes` VALUES ('243', '3905', '3707', '1112', '90', '99', '52', '68');
INSERT INTO `equip_attributes` VALUES ('244', '3905', '3707', '1109', '90', '99', '199', '259');
INSERT INTO `equip_attributes` VALUES ('245', '3905', '3706', '1112', '100', '109', '55', '71');
INSERT INTO `equip_attributes` VALUES ('246', '3905', '3706', '1109', '100', '109', '210', '273');
INSERT INTO `equip_attributes` VALUES ('247', '3905', '3707', '1112', '100', '109', '57', '75');
INSERT INTO `equip_attributes` VALUES ('248', '3905', '3707', '1109', '100', '109', '220', '286');
INSERT INTO `equip_attributes` VALUES ('249', '3906', '3705', '1112', '0', '9', '3', '5');
INSERT INTO `equip_attributes` VALUES ('250', '3906', '3705', '1105', '0', '9', '5', '7');
INSERT INTO `equip_attributes` VALUES ('251', '3906', '3706', '1112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('252', '3906', '3706', '1105', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('253', '3906', '3707', '1112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('254', '3906', '3707', '1105', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('255', '3906', '3705', '1112', '10', '19', '6', '10');
INSERT INTO `equip_attributes` VALUES ('256', '3906', '3705', '1105', '10', '19', '9', '12');
INSERT INTO `equip_attributes` VALUES ('257', '3906', '3706', '1112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('258', '3906', '3706', '1105', '10', '19', '8', '10');
INSERT INTO `equip_attributes` VALUES ('259', '3906', '3707', '1112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('260', '3906', '3707', '1105', '10', '19', '8', '10');
INSERT INTO `equip_attributes` VALUES ('261', '3906', '3705', '1112', '20', '29', '10', '17');
INSERT INTO `equip_attributes` VALUES ('262', '3906', '3705', '1105', '20', '29', '13', '17');
INSERT INTO `equip_attributes` VALUES ('263', '3906', '3706', '1112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('264', '3906', '3706', '1105', '20', '29', '11', '14');
INSERT INTO `equip_attributes` VALUES ('265', '3906', '3707', '1112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('266', '3906', '3707', '1105', '20', '29', '11', '14');
INSERT INTO `equip_attributes` VALUES ('267', '3906', '3705', '1112', '30', '39', '14', '24');
INSERT INTO `equip_attributes` VALUES ('268', '3906', '3705', '1105', '30', '39', '17', '22');
INSERT INTO `equip_attributes` VALUES ('269', '3906', '3706', '1112', '30', '39', '20', '26');
INSERT INTO `equip_attributes` VALUES ('270', '3906', '3706', '1105', '30', '39', '14', '18');
INSERT INTO `equip_attributes` VALUES ('271', '3906', '3707', '1112', '30', '39', '21', '27');
INSERT INTO `equip_attributes` VALUES ('272', '3906', '3707', '1105', '30', '39', '14', '18');
INSERT INTO `equip_attributes` VALUES ('273', '3906', '3705', '1112', '40', '49', '18', '31');
INSERT INTO `equip_attributes` VALUES ('274', '3906', '3705', '1105', '40', '49', '21', '27');
INSERT INTO `equip_attributes` VALUES ('275', '3906', '3706', '1112', '40', '49', '25', '32');
INSERT INTO `equip_attributes` VALUES ('276', '3906', '3706', '1105', '40', '49', '17', '22');
INSERT INTO `equip_attributes` VALUES ('277', '3906', '3707', '1112', '40', '49', '26', '33');
INSERT INTO `equip_attributes` VALUES ('278', '3906', '3707', '1105', '40', '49', '17', '22');
INSERT INTO `equip_attributes` VALUES ('279', '3906', '3705', '1112', '50', '59', '21', '36');
INSERT INTO `equip_attributes` VALUES ('280', '3906', '3705', '1105', '50', '59', '25', '33');
INSERT INTO `equip_attributes` VALUES ('281', '3906', '3706', '1112', '50', '59', '30', '39');
INSERT INTO `equip_attributes` VALUES ('282', '3906', '3706', '1105', '50', '59', '20', '26');
INSERT INTO `equip_attributes` VALUES ('283', '3906', '3707', '1112', '50', '59', '31', '40');
INSERT INTO `equip_attributes` VALUES ('284', '3906', '3707', '1105', '50', '59', '21', '27');
INSERT INTO `equip_attributes` VALUES ('285', '3906', '3705', '1112', '60', '69', '24', '41');
INSERT INTO `equip_attributes` VALUES ('286', '3906', '3705', '1105', '60', '69', '27', '35');
INSERT INTO `equip_attributes` VALUES ('287', '3906', '3706', '1112', '60', '69', '35', '45');
INSERT INTO `equip_attributes` VALUES ('288', '3906', '3706', '1105', '60', '69', '23', '29');
INSERT INTO `equip_attributes` VALUES ('289', '3906', '3707', '1112', '60', '69', '36', '47');
INSERT INTO `equip_attributes` VALUES ('290', '3906', '3707', '1105', '60', '69', '24', '31');
INSERT INTO `equip_attributes` VALUES ('291', '3906', '3705', '1112', '70', '79', '27', '46');
INSERT INTO `equip_attributes` VALUES ('292', '3906', '3705', '1105', '70', '79', '29', '38');
INSERT INTO `equip_attributes` VALUES ('293', '3906', '3706', '1112', '70', '79', '40', '52');
INSERT INTO `equip_attributes` VALUES ('294', '3906', '3706', '1105', '70', '79', '26', '33');
INSERT INTO `equip_attributes` VALUES ('295', '3906', '3707', '1112', '70', '79', '42', '54');
INSERT INTO `equip_attributes` VALUES ('296', '3906', '3707', '1105', '70', '79', '27', '35');
INSERT INTO `equip_attributes` VALUES ('297', '3906', '3705', '1112', '80', '89', '29', '49');
INSERT INTO `equip_attributes` VALUES ('298', '3906', '3705', '1105', '80', '89', '31', '40');
INSERT INTO `equip_attributes` VALUES ('299', '3906', '3706', '1112', '80', '89', '45', '58');
INSERT INTO `equip_attributes` VALUES ('300', '3906', '3706', '1105', '80', '89', '29', '37');
INSERT INTO `equip_attributes` VALUES ('301', '3906', '3707', '1112', '80', '89', '47', '60');
INSERT INTO `equip_attributes` VALUES ('302', '3906', '3707', '1105', '80', '89', '30', '39');
INSERT INTO `equip_attributes` VALUES ('303', '3906', '3706', '1112', '90', '99', '50', '65');
INSERT INTO `equip_attributes` VALUES ('304', '3906', '3706', '1105', '90', '99', '332', '41');
INSERT INTO `equip_attributes` VALUES ('305', '3906', '3707', '1112', '90', '99', '52', '58');
INSERT INTO `equip_attributes` VALUES ('306', '3906', '3707', '1105', '90', '99', '33', '42');
INSERT INTO `equip_attributes` VALUES ('307', '3906', '3706', '1112', '100', '109', '55', '71');
INSERT INTO `equip_attributes` VALUES ('308', '3906', '3706', '1105', '100', '109', '35', '45');
INSERT INTO `equip_attributes` VALUES ('309', '3906', '3707', '1112', '100', '109', '57', '74');
INSERT INTO `equip_attributes` VALUES ('310', '3906', '3707', '1105', '100', '109', '36', '46');


-- ----------------------------
-- Table structure for `equip_price`
-- ----------------------------
DROP TABLE IF EXISTS `equip_price`;
CREATE TABLE `equip_price` (
  `equip_colour` int(11) NOT NULL COMMENT '装备颜色',
  `equip_level` int(11) NOT NULL COMMENT '装备等级',
  `equip_price` int(11) NOT NULL COMMENT '装备价格',
  PRIMARY KEY (`equip_colour`,`equip_level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of equip_price
-- ----------------------------
INSERT INTO `equip_price` VALUES ('1', '1', '250');

-- ----------------------------
-- Table structure for `fight_last_result`
-- ----------------------------
DROP TABLE IF EXISTS `fight_last_result`;
CREATE TABLE `fight_last_result` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `map_id` int(11) NOT NULL COMMENT '地图的id',
  `fight_start_time` int(11) NOT NULL COMMENT '战斗接口请求时间',
  `use_time` int(11) NOT NULL COMMENT '预计战斗耗时时间',
  `last_fight_result` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '最后一次战斗结果',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fight_last_result
-- ----------------------------
INSERT INTO `fight_last_result` VALUES ('2', '27', '1', '1379919788', '0', 0x7B227061727469636970616E74223A7B2275736572223A7B226E616D65223A22753930643175366263357536376162222C226C6576656C223A31322C22626C6F6F64223A323633332C226D61676963223A323933347D2C22706574223A7B226E616D65223A2275363739377535623530222C226C6576656C223A31322C22626C6F6F64223A323633337D2C226D6F6E73746572223A5B7B22707265666978223A22753930633175393566377537363834222C22737566666978223A22424F5353222C226E616D65223A2275363734657534663166222C226C6576656C223A31322C22626C6F6F64223A323633337D2C7B22707265666978223A22753531663675363037367537363834222C22737566666978223A2275393631667539353766222C226E616D65223A22753930646475363635337535316566222C226C6576656C223A31322C22626C6F6F64223A323633337D5D7D2C2266696768745F70726F636564757265223A5B7B22737472696E67223A223C7265643E757365723C2F7265643E7C75356266397C3C623E6D6F6E737465725B305D3C2F623E7C7534663766753735323875346538367C3C7265643E753931636475353166623C2F7265643E7C2C7C7539303230753632313075346538367C483A323730307C75373062397C75346632347535626233222C2261747461636B6572223A2275736572222C2261747461636B65725F737461747573223A302C2261747461636B65725F626C6F6F64223A3230302C2261747461636B65725F6D61676963223A3135302C22746172676574223A226D6F6E737465725B305D222C227461726765745F737461747573223A302C227461726765745F626C6F6F64223A3230302C227461726765745F6D61676963223A3230307D2C7B22737472696E67223A223C623E6D6F6E737465725B305D3C2F623E7C75356266392F3C7265643E7065743C2F7265643E7C7534663766753735323875346538367C75363636657539303161753635336275353166627C2C7C7539303230753632313075346538367C483A3835307C75373062397C75346632347535626233222C2261747461636B6572223A226D6F6E737465725B305D222C2261747461636B65725F737461747573223A302C2261747461636B65725F626C6F6F64223A3230302C2261747461636B65725F6D61676963223A3135302C22746172676574223A22706574222C227461726765745F737461747573223A302C227461726765745F626C6F6F64223A3230302C227461726765745F6D61676963223A3230307D2C7B22737472696E67223A223C7265643E61747461636B65723C2F7265643E7C75356266392F3C623E6D6F6E737465725B315D3C2F623E7C7534663766753735323875346538367C3C7265643E753866646575353166623C2F7265643E7C0A7C753762326375346530307536623231753635336275353166627C7539303230753632313075346538367C483A313230307C75373062397C753466323475356262332F0A2F753762326375346538637536623231753635336275353166627C7539303230753632313075346538367C483A313130307C75373062397C753466323475356262337C0A7C753762326375346530397536623231753635336275353166627C7539303230753632313075346538367C483A323230307C75373062397C75346632347535626233222C2261747461636B6572223A22706574222C2261747461636B65725F737461747573223A302C2261747461636B65725F626C6F6F64223A3230302C2261747461636B65725F6D61676963223A3135302C22746172676574223A226D6F6E737465725B315D222C227461726765745F737461747573223A302C227461726765745F626C6F6F64223A3230302C227461726765745F6D61676963223A3230307D5D2C22726573756C74223A7B22657870657269656E6365223A34312C226D6F6E6579223A312C2265717569706D656E74223A6E756C6C7D7D, '2013-09-23 07:03:08');

-- ----------------------------
-- Table structure for `friend_info`
-- ----------------------------
DROP TABLE IF EXISTS `friend_info`;
CREATE TABLE `friend_info` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `channel` enum('sina','weixin','lbs','game') DEFAULT 'game' COMMENT '添加来源',
  `is_pass` tinyint(1) DEFAULT '0' COMMENT '0未通过1通过',
  PRIMARY KEY (`user_id`,`friend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of friend_info
-- ----------------------------
INSERT INTO `friend_info` VALUES ('27', '1', 'game', '1');
INSERT INTO `friend_info` VALUES ('27', '2', 'game', '1');
INSERT INTO `friend_info` VALUES ('27', '3', 'game', '2');
INSERT INTO `friend_info` VALUES ('3', '27', 'game', '2');

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
  `experience` int(11) NOT NULL COMMENT '本级所需经验',
  `need_experience` bigint(13) NOT NULL COMMENT '所需经验数',
  PRIMARY KEY (`level`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of level_info
-- ----------------------------
INSERT INTO `level_info` VALUES ('95', '275338436', '5380510421');
INSERT INTO `level_info` VALUES ('93', '252920548', '4841220927');
INSERT INTO `level_info` VALUES ('94', '263951058', '5105171986');
INSERT INTO `level_info` VALUES ('96', '287090294', '5667600715');
INSERT INTO `level_info` VALUES ('99', '324610098', '6603143451');
INSERT INTO `level_info` VALUES ('100', '337897627', '6941041077');
INSERT INTO `level_info` VALUES ('1', '800', '800');
INSERT INTO `level_info` VALUES ('2', '820', '1620');
INSERT INTO `level_info` VALUES ('3', '988', '2608');
INSERT INTO `level_info` VALUES ('4', '1524', '4132');
INSERT INTO `level_info` VALUES ('5', '2730', '6862');
INSERT INTO `level_info` VALUES ('6', '4989', '11850');
INSERT INTO `level_info` VALUES ('7', '8761', '20611');
INSERT INTO `level_info` VALUES ('8', '14590', '35202');
INSERT INTO `level_info` VALUES ('9', '23099', '58301');
INSERT INTO `level_info` VALUES ('10', '34991', '93291');
INSERT INTO `level_info` VALUES ('11', '51049', '144340');
INSERT INTO `level_info` VALUES ('12', '72138', '216478');
INSERT INTO `level_info` VALUES ('13', '99202', '315680');
INSERT INTO `level_info` VALUES ('14', '133265', '448946');
INSERT INTO `level_info` VALUES ('15', '175433', '624379');
INSERT INTO `level_info` VALUES ('16', '226892', '851271');
INSERT INTO `level_info` VALUES ('17', '288906', '1140177');
INSERT INTO `level_info` VALUES ('18', '362822', '1502999');
INSERT INTO `level_info` VALUES ('19', '450067', '1953066');
INSERT INTO `level_info` VALUES ('20', '552147', '2505213');
INSERT INTO `level_info` VALUES ('21', '670650', '3175863');
INSERT INTO `level_info` VALUES ('22', '807243', '3983105');
INSERT INTO `level_info` VALUES ('23', '963673', '4946779');
INSERT INTO `level_info` VALUES ('24', '1141771', '6088549');
INSERT INTO `level_info` VALUES ('25', '1343443', '7431992');
INSERT INTO `level_info` VALUES ('26', '1570679', '9002671');
INSERT INTO `level_info` VALUES ('27', '1825549', '10828220');
INSERT INTO `level_info` VALUES ('28', '2110201', '12938421');
INSERT INTO `level_info` VALUES ('29', '2426867', '15365288');
INSERT INTO `level_info` VALUES ('30', '2777856', '18143145');
INSERT INTO `level_info` VALUES ('31', '3165560', '21308704');
INSERT INTO `level_info` VALUES ('32', '3592449', '24901153');
INSERT INTO `level_info` VALUES ('33', '4061075', '28962228');
INSERT INTO `level_info` VALUES ('34', '4574069', '33536297');
INSERT INTO `level_info` VALUES ('35', '5134145', '38670442');
INSERT INTO `level_info` VALUES ('36', '5744094', '44414536');
INSERT INTO `level_info` VALUES ('37', '6406790', '50821325');
INSERT INTO `level_info` VALUES ('38', '7125185', '57946511');
INSERT INTO `level_info` VALUES ('39', '7902314', '65848824');
INSERT INTO `level_info` VALUES ('40', '8741290', '74590114');
INSERT INTO `level_info` VALUES ('41', '9645308', '84235422');
INSERT INTO `level_info` VALUES ('42', '10617642', '94853065');
INSERT INTO `level_info` VALUES ('43', '11661648', '106514713');
INSERT INTO `level_info` VALUES ('44', '12780761', '119295473');
INSERT INTO `level_info` VALUES ('45', '13978496', '133273970');
INSERT INTO `level_info` VALUES ('46', '15258450', '148532420');
INSERT INTO `level_info` VALUES ('47', '16624300', '165156720');
INSERT INTO `level_info` VALUES ('48', '18079802', '183236521');
INSERT INTO `level_info` VALUES ('49', '19628793', '202865314');
INSERT INTO `level_info` VALUES ('50', '21275191', '224140505');
INSERT INTO `level_info` VALUES ('51', '23022994', '247163499');
INSERT INTO `level_info` VALUES ('52', '24876280', '272039778');
INSERT INTO `level_info` VALUES ('53', '26839207', '298878985');
INSERT INTO `level_info` VALUES ('54', '28916016', '327795001');
INSERT INTO `level_info` VALUES ('55', '31111024', '358906026');
INSERT INTO `level_info` VALUES ('56', '33428633', '392334659');
INSERT INTO `level_info` VALUES ('57', '35873321', '428207980');
INSERT INTO `level_info` VALUES ('58', '38449650', '466657630');
INSERT INTO `level_info` VALUES ('59', '41162259', '507819889');
INSERT INTO `level_info` VALUES ('60', '44015871', '551835760');
INSERT INTO `level_info` VALUES ('61', '47015287', '598851047');
INSERT INTO `level_info` VALUES ('62', '50165388', '649016435');
INSERT INTO `level_info` VALUES ('63', '53471137', '702487572');
INSERT INTO `level_info` VALUES ('64', '56937576', '759425148');
INSERT INTO `level_info` VALUES ('65', '60569828', '819994976');
INSERT INTO `level_info` VALUES ('66', '64373097', '884368073');
INSERT INTO `level_info` VALUES ('67', '68352666', '952720739');
INSERT INTO `level_info` VALUES ('68', '72513899', '1025234638');
INSERT INTO `level_info` VALUES ('69', '76862241', '1102096879');
INSERT INTO `level_info` VALUES ('70', '81403215', '1183500094');
INSERT INTO `level_info` VALUES ('71', '86142428', '1269642523');
INSERT INTO `level_info` VALUES ('72', '91085565', '1360728088');
INSERT INTO `level_info` VALUES ('73', '96238391', '1456966479');
INSERT INTO `level_info` VALUES ('74', '101606753', '1558573231');
INSERT INTO `level_info` VALUES ('75', '107196576', '1665769808');
INSERT INTO `level_info` VALUES ('76', '113013869', '1778783677');
INSERT INTO `level_info` VALUES ('77', '119064718', '1897848394');
INSERT INTO `level_info` VALUES ('78', '125355290', '2023203684');
INSERT INTO `level_info` VALUES ('79', '131891834', '2155095518');
INSERT INTO `level_info` VALUES ('80', '138680678', '2293776195');
INSERT INTO `level_info` VALUES ('81', '145728230', '2439504425');
INSERT INTO `level_info` VALUES ('82', '153040979', '2592545405');
INSERT INTO `level_info` VALUES ('83', '160625496', '2753170901');
INSERT INTO `level_info` VALUES ('84', '168488429', '2921659330');
INSERT INTO `level_info` VALUES ('85', '176636509', '3098295838');
INSERT INTO `level_info` VALUES ('86', '185076545', '3283372384');
INSERT INTO `level_info` VALUES ('87', '193815430', '3477187813');
INSERT INTO `level_info` VALUES ('88', '202860133', '3680047946');
INSERT INTO `level_info` VALUES ('89', '212217707', '3892265653');
INSERT INTO `level_info` VALUES ('90', '221895283', '4114160936');
INSERT INTO `level_info` VALUES ('91', '231900073', '4346061009');
INSERT INTO `level_info` VALUES ('92', '242239370', '4588300379');
INSERT INTO `level_info` VALUES ('97', '299214327', '5966815042');
INSERT INTO `level_info` VALUES ('98', '311718310', '6278533352');


-- ----------------------------
-- Table structure for `level_skill_spend`
-- ----------------------------
DROP TABLE IF EXISTS `level_skill_spend`;
CREATE TABLE `level_skill_spend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_level` tinyint(4) NOT NULL COMMENT '技能等级',
  `money` int(11) NOT NULL COMMENT '对应等级消耗的铜钱',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of level_skill_spend
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
INSERT INTO `map_list` VALUES ('1', '花果山', '1', '0', '5');
INSERT INTO `map_list` VALUES ('2', '长寿郊外', '3', '6', '10');
INSERT INTO `map_list` VALUES ('3', '七十二洞', '2', '11', '15');
INSERT INTO `map_list` VALUES ('4', '东海龙宫', '3', '16', '20');
INSERT INTO `map_list` VALUES ('5', '天宫马厩', '2', '21', '25');
INSERT INTO `map_list` VALUES ('6', '天宫', '2', '26', '30');
INSERT INTO `map_list` VALUES ('7', '地府', '3', '31', '35');
INSERT INTO `map_list` VALUES ('8', '五行山', '2', '36', '40');
INSERT INTO `map_list` VALUES ('9', '黑风洞', '3', '41', '45');
INSERT INTO `map_list` VALUES ('10', '云栈洞', '2', '46', '50');
INSERT INTO `map_list` VALUES ('11', '流沙河', '1', '51', '60');
INSERT INTO `map_list` VALUES ('12', '五庄观', '1', '61', '65');
INSERT INTO `map_list` VALUES ('13', '火云洞', '3', '66', '70');
INSERT INTO `map_list` VALUES ('14', '白骨洞', '3', '71', '75');
INSERT INTO `map_list` VALUES ('15', '莲花洞', '2', '76', '80');
INSERT INTO `map_list` VALUES ('16', '乌鸡国', '1', '81', '85');
INSERT INTO `map_list` VALUES ('17', '黄金塔', '3', '86', '90');
INSERT INTO `map_list` VALUES ('18', '平顶山', '2', '91', '95');
INSERT INTO `map_list` VALUES ('19', '琵琶洞', '2', '96', '100');

-- ----------------------------
-- Table structure for `map_monster`
-- ----------------------------
DROP TABLE IF EXISTS `map_monster`;
CREATE TABLE `map_monster` (
  `monster_id` int(11) NOT NULL AUTO_INCREMENT,
  `monster_name` varchar(200) NOT NULL,
  `map_id` int(11) DEFAULT NULL,
  `race_id` int(11) NOT NULL COMMENT '种族id',
  PRIMARY KEY (`monster_id`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of map_monster
-- ----------------------------
INSERT INTO `map_monster` VALUES ('1', '狼', '1', '1');
INSERT INTO `map_monster` VALUES ('2', '猴', '1', '1');
INSERT INTO `map_monster` VALUES ('3', '虎', '1', '1');
INSERT INTO `map_monster` VALUES ('4', '豹', '1', '1');
INSERT INTO `map_monster` VALUES ('5', '鹿', '1', '1');
INSERT INTO `map_monster` VALUES ('6', '小妖', '2', '3');
INSERT INTO `map_monster` VALUES ('7', '狼精', '2', '3');
INSERT INTO `map_monster` VALUES ('8', '妖道', '2', '3');
INSERT INTO `map_monster` VALUES ('9', '恶兄长', '2', '3');
INSERT INTO `map_monster` VALUES ('10', '懒师弟', '2', '3');
INSERT INTO `map_monster` VALUES ('11', '山牛', '3', '2');
INSERT INTO `map_monster` VALUES ('12', '神獒', '3', '2');
INSERT INTO `map_monster` VALUES ('13', '羚羊', '3', '2');
INSERT INTO `map_monster` VALUES ('14', '狻猊', '3', '2');
INSERT INTO `map_monster` VALUES ('15', '青兕', '3', '2');
INSERT INTO `map_monster` VALUES ('16', '虾兵', '4', '3');
INSERT INTO `map_monster` VALUES ('17', '蟹将', '4', '3');
INSERT INTO `map_monster` VALUES ('18', '夜叉', '4', '3');
INSERT INTO `map_monster` VALUES ('19', '龟丞相', '4', '3');
INSERT INTO `map_monster` VALUES ('20', '鳖帅', '4', '3');
INSERT INTO `map_monster` VALUES ('21', '天兵', '5', '2');
INSERT INTO `map_monster` VALUES ('22', '天将', '5', '2');
INSERT INTO `map_monster` VALUES ('23', '仙女', '5', '2');
INSERT INTO `map_monster` VALUES ('24', '善财童子', '5', '2');
INSERT INTO `map_monster` VALUES ('25', '巨灵神', '5', '2');
INSERT INTO `map_monster` VALUES ('26', '天兵', '6', '2');
INSERT INTO `map_monster` VALUES ('27', '天将', '6', '2');
INSERT INTO `map_monster` VALUES ('28', '仙女', '6', '2');
INSERT INTO `map_monster` VALUES ('29', '善财童子', '6', '2');
INSERT INTO `map_monster` VALUES ('30', '巨灵神', '6', '2');
INSERT INTO `map_monster` VALUES ('31', '牛头', '7', '3');
INSERT INTO `map_monster` VALUES ('32', '马面', '7', '3');
INSERT INTO `map_monster` VALUES ('33', '女鬼', '7', '3');
INSERT INTO `map_monster` VALUES ('34', '黑无常', '7', '3');
INSERT INTO `map_monster` VALUES ('35', '白无常', '7', '3');
INSERT INTO `map_monster` VALUES ('36', '道童', '8', '2');
INSERT INTO `map_monster` VALUES ('37', '丹炉', '8', '2');
INSERT INTO `map_monster` VALUES ('38', '火神', '8', '2');
INSERT INTO `map_monster` VALUES ('39', '机关怪', '8', '2');
INSERT INTO `map_monster` VALUES ('40', '石头人', '8', '2');
INSERT INTO `map_monster` VALUES ('41', '白熊精', '9', '3');
INSERT INTO `map_monster` VALUES ('42', '黑熊精', '9', '3');
INSERT INTO `map_monster` VALUES ('43', '九头蛇', '9', '3');
INSERT INTO `map_monster` VALUES ('44', '六尾狐', '9', '3');
INSERT INTO `map_monster` VALUES ('45', '狐妖', '9', '3');
INSERT INTO `map_monster` VALUES ('46', '猪妖', '10', '2');
INSERT INTO `map_monster` VALUES ('47', '骨角精', '10', '2');
INSERT INTO `map_monster` VALUES ('48', '炎魔怪', '11', '1');
INSERT INTO `map_monster` VALUES ('49', '猪刚烈', '11', '1');
INSERT INTO `map_monster` VALUES ('50', '岩怪', '11', '1');
INSERT INTO `map_monster` VALUES ('51', '五庄道姑', '12', '1');
INSERT INTO `map_monster` VALUES ('52', '明月', '12', '1');
INSERT INTO `map_monster` VALUES ('53', '清风', '12', '1');
INSERT INTO `map_monster` VALUES ('54', '土地', '12', '1');
INSERT INTO `map_monster` VALUES ('55', '五庄使者', '12', '1');
INSERT INTO `map_monster` VALUES ('56', '狮头兽', '13', '3');
INSERT INTO `map_monster` VALUES ('57', '烈火虎', '13', '3');
INSERT INTO `map_monster` VALUES ('58', '不死鸟', '13', '3');
INSERT INTO `map_monster` VALUES ('59', '火蟾蜍', '13', '3');
INSERT INTO `map_monster` VALUES ('60', '赤烛魔', '13', '3');
INSERT INTO `map_monster` VALUES ('61', '僵尸', '14', '3');
INSERT INTO `map_monster` VALUES ('62', '劈头僵尸', '14', '3');
INSERT INTO `map_monster` VALUES ('63', '碎骨骷髅', '14', '3');
INSERT INTO `map_monster` VALUES ('64', '破骨僵尸', '14', '3');
INSERT INTO `map_monster` VALUES ('65', '白骨斧手', '14', '3');
INSERT INTO `map_monster` VALUES ('66', '狐阿七', '15', '2');
INSERT INTO `map_monster` VALUES ('67', '狐阿大', '15', '2');
INSERT INTO `map_monster` VALUES ('68', '棕熊精', '15', '2');
INSERT INTO `map_monster` VALUES ('69', '莲花精', '15', '2');
INSERT INTO `map_monster` VALUES ('70', '白鹿精', '15', '2');
INSERT INTO `map_monster` VALUES ('71', '狼头小妖', '16', '1');
INSERT INTO `map_monster` VALUES ('72', '竹妖', '16', '1');
INSERT INTO `map_monster` VALUES ('73', '面具魔', '16', '1');
INSERT INTO `map_monster` VALUES ('74', '雪鹰', '16', '1');
INSERT INTO `map_monster` VALUES ('75', '猫少女', '16', '1');
INSERT INTO `map_monster` VALUES ('76', '狼男', '17', '1');
INSERT INTO `map_monster` VALUES ('77', '狼女', '17', '1');
INSERT INTO `map_monster` VALUES ('78', '狼婆', '17', '1');
INSERT INTO `map_monster` VALUES ('79', '狼公', '17', '1');
INSERT INTO `map_monster` VALUES ('80', '冰狼', '17', '1');
INSERT INTO `map_monster` VALUES ('81', '精细鬼', '18', '2');
INSERT INTO `map_monster` VALUES ('82', '伶俐虫', '18', '2');
INSERT INTO `map_monster` VALUES ('83', '巴山虎', '18', '2');
INSERT INTO `map_monster` VALUES ('84', '倚海龙', '18', '2');
INSERT INTO `map_monster` VALUES ('85', '花裙黑狐', '18', '2');
INSERT INTO `map_monster` VALUES ('86', '傲剑天狼', '19', '2');
INSERT INTO `map_monster` VALUES ('87', '琵琶夫人', '19', '2');
INSERT INTO `map_monster` VALUES ('88', '上古蜈蚣', '19', '2');
INSERT INTO `map_monster` VALUES ('89', '蛇女帝', '19', '2');
INSERT INTO `map_monster` VALUES ('90', '蜂女王', '19', '2');
INSERT INTO `map_monster` VALUES ('91', '你', null, '0');

-- ----------------------------
-- Table structure for `map_skill`
-- ----------------------------
DROP TABLE IF EXISTS `map_skill`;
CREATE TABLE `map_skill` (
  `map_skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `skill_type` varchar(64) NOT NULL COMMENT '技能类型：attack,defence,passive',
  `config_type` varchar(64) NOT NULL COMMENT '配置类型:all, boss_must_have, suffix_must_have, boss_min_count, suffix_min_count',
  PRIMARY KEY (`map_skill_id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `map_skill` VALUES ('21', '6', '1205', 'attack', 'all'), ('1', '1', '1201', 'attack', 'all'), ('2', '1', '1202', 'attack', 'all'), ('3', '1', '1203', 'attack', 'all'), ('4', '1', '1204', 'attack', 'all'), ('5', '1', '1205', 'attack', 'all'), ('6', '1', '1206', 'attack', 'all'), ('7', '2', '1201', 'attack', 'all'), ('8', '2', '1202', 'attack', 'all'), ('9', '2', '1203', 'attack', 'all'), ('10', '3', '1205', 'attack', 'all'), ('11', '3', '1204', 'attack', 'all'), ('12', '3', '1206', 'attack', 'all'), ('13', '4', '1201', 'attack', 'all'), ('14', '4', '1202', 'attack', 'all'), ('15', '4', '1203', 'attack', 'all'), ('16', '5', '1204', 'attack', 'all'), ('17', '5', '1205', 'attack', 'all'), ('18', '5', '1206', 'attack', 'all'), ('19', '6', '1204', 'attack', 'all'), ('22', '6', '1206', 'attack', 'all'), ('23', '7', '1201', 'attack', 'all'), ('24', '7', '1202', 'attack', 'all'), ('25', '7', '1203', 'attack', 'all'), ('26', '8', '1204', 'attack', 'all'), ('27', '8', '1205', 'attack', 'all'), ('28', '8', '1206', 'attack', 'all'), ('29', '9', '1201', 'attack', 'all'), ('30', '9', '1202', 'attack', 'all'), ('31', '9', '1203', 'attack', 'all'), ('32', '10', '1204', 'attack', 'all'), ('33', '10', '1205', 'attack', 'all'), ('34', '10', '1206', 'attack', 'all'), ('35', '11', '1201', 'attack', 'all'), ('36', '11', '1202', 'attack', 'all'), ('37', '11', '1203', 'attack', 'all'), ('38', '11', '1204', 'attack', 'all'), ('39', '11', '1205', 'attack', 'all'), ('40', '11', '1206', 'attack', 'all'), ('41', '12', '1201', 'attack', 'all'), ('42', '12', '1202', 'attack', 'all'), ('43', '12', '1203', 'attack', 'all'), ('44', '12', '1204', 'attack', 'all'), ('45', '12', '1205', 'attack', 'all'), ('46', '12', '1206', 'attack', 'all'), ('47', '13', '1201', 'attack', 'all'), ('48', '13', '1202', 'attack', 'all'), ('49', '13', '1203', 'attack', 'all'), ('50', '13', '1204', 'attack', 'all'), ('51', '13', '1205', 'attack', 'all'), ('52', '13', '1206', 'attack', 'all'), ('53', '14', '1201', 'attack', 'all'), ('54', '14', '1202', 'attack', 'all'), ('55', '14', '1203', 'attack', 'all'), ('56', '14', '1204', 'attack', 'all'), ('57', '14', '1205', 'attack', 'all'), ('58', '14', '1206', 'attack', 'all'), ('59', '15', '1201', 'attack', 'all'), ('60', '15', '1202', 'attack', 'all'), ('61', '15', '1203', 'attack', 'all'), ('62', '15', '1204', 'attack', 'all'), ('63', '15', '1205', 'attack', 'all'), ('64', '15', '1206', 'attack', 'all'), ('65', '16', '1201', 'attack', 'all'), ('66', '16', '1202', 'attack', 'all'), ('67', '16', '1203', 'attack', 'all'), ('68', '16', '1204', 'attack', 'all'), ('69', '16', '1205', 'attack', 'all'), ('70', '16', '1206', 'attack', 'all'), ('71', '17', '1201', 'attack', 'all'), ('72', '17', '1202', 'attack', 'all'), ('73', '17', '1203', 'attack', 'all'), ('74', '17', '1204', 'attack', 'all'), ('75', '17', '1205', 'attack', 'all'), ('76', '17', '1206', 'attack', 'all'), ('77', '18', '1201', 'attack', 'all'), ('78', '18', '1202', 'attack', 'all'), ('79', '18', '1203', 'attack', 'all'), ('80', '18', '1204', 'attack', 'all'), ('81', '18', '1205', 'attack', 'all'), ('82', '18', '1206', 'attack', 'all'), ('83', '19', '1201', 'attack', 'all'), ('84', '19', '1202', 'attack', 'all'), ('85', '19', '1203', 'attack', 'all'), ('86', '19', '1204', 'attack', 'all'), ('87', '19', '1205', 'attack', 'all'), ('88', '19', '1206', 'attack', 'all'), ('89', '1', '1212', 'defense', 'all'), ('90', '1', '1213', 'defense', 'all'), ('91', '1', '1214', 'defense', 'all'), ('92', '1', '1207', 'passive', 'all'), ('93', '1', '1208', 'passive', 'all'), ('94', '1', '1209', 'passive', 'all'), ('95', '1', '1210', 'passive', 'all'), ('96', '2', '1212', 'defense', 'all'), ('97', '2', '1213', 'defense', 'all'), ('98', '2', '1214', 'defense', 'all'), ('99', '2', '1207', 'passive', 'all'), ('100', '2', '1208', 'passive', 'all'), ('101', '2', '1209', 'passive', 'all'), ('102', '2', '1210', 'passive', 'all'), ('103', '3', '1212', 'defense', 'all'), ('104', '3', '1213', 'defense', 'all'), ('105', '3', '1214', 'defense', 'all'), ('106', '3', '1207', 'passive', 'all'), ('107', '3', '1208', 'passive', 'all'), ('108', '3', '1209', 'passive', 'all'), ('109', '3', '1210', 'passive', 'all'), ('110', '4', '1212', 'defense', 'all'), ('111', '4', '1213', 'defense', 'all'), ('112', '4', '1214', 'defense', 'all'), ('113', '4', '1207', 'passive', 'all'), ('114', '4', '1208', 'passive', 'all'), ('115', '4', '1209', 'passive', 'all'), ('116', '4', '1210', 'passive', 'all'), ('117', '5', '1212', 'defense', 'all'), ('118', '5', '1213', 'defense', 'all'), ('119', '5', '1214', 'defense', 'all'), ('120', '5', '1207', 'passive', 'all'), ('121', '5', '1208', 'passive', 'all'), ('122', '5', '1209', 'passive', 'all'), ('123', '5', '1210', 'passive', 'all'), ('124', '6', '1212', 'defense', 'all'), ('125', '6', '1213', 'defense', 'all'), ('126', '6', '1214', 'defense', 'all'), ('127', '6', '1207', 'passive', 'all'), ('128', '6', '1208', 'passive', 'all'), ('129', '6', '1209', 'passive', 'all'), ('130', '6', '1210', 'passive', 'all'), ('131', '7', '1212', 'defense', 'all'), ('132', '7', '1213', 'defense', 'all'), ('133', '7', '1214', 'defense', 'all'), ('134', '7', '1207', 'passive', 'all'), ('135', '7', '1208', 'passive', 'all'), ('136', '7', '1209', 'passive', 'all'), ('137', '7', '1210', 'passive', 'all'), ('138', '8', '1212', 'defense', 'all'), ('139', '8', '1213', 'defense', 'all'), ('140', '8', '1214', 'defense', 'all'), ('141', '8', '1207', 'passive', 'all'), ('142', '8', '1208', 'passive', 'all'), ('143', '8', '1209', 'passive', 'all'), ('144', '8', '1210', 'passive', 'all'), ('145', '9', '1212', 'defense', 'all'), ('146', '9', '1213', 'defense', 'all'), ('147', '9', '1214', 'defense', 'all'), ('148', '9', '1207', 'passive', 'all'), ('149', '9', '1208', 'passive', 'all'), ('150', '9', '1209', 'passive', 'all'), ('151', '9', '1210', 'passive', 'all'), ('152', '10', '1212', 'defense', 'all'), ('153', '10', '1213', 'defense', 'all'), ('154', '10', '1214', 'defense', 'all'), ('155', '10', '1207', 'passive', 'all'), ('156', '10', '1208', 'passive', 'all'), ('157', '10', '1209', 'passive', 'all'), ('158', '10', '1210', 'passive', 'all'), ('159', '11', '1212', 'defense', 'all'), ('160', '11', '1213', 'defense', 'all'), ('161', '11', '1214', 'defense', 'all'), ('162', '11', '1207', 'passive', 'all'), ('163', '11', '1208', 'passive', 'all'), ('164', '11', '1209', 'passive', 'all'), ('165', '11', '1210', 'passive', 'all'), ('166', '12', '1212', 'defense', 'all'), ('167', '12', '1213', 'defense', 'all'), ('168', '12', '1214', 'defense', 'all'), ('169', '12', '1207', 'passive', 'all'), ('170', '12', '1208', 'passive', 'all'), ('171', '12', '1209', 'passive', 'all'), ('172', '12', '1210', 'passive', 'all'), ('173', '13', '1212', 'defense', 'all'), ('174', '13', '1213', 'defense', 'all'), ('175', '13', '1214', 'defense', 'all'), ('176', '13', '1207', 'passive', 'all'), ('177', '13', '1208', 'passive', 'all'), ('178', '13', '1209', 'passive', 'all'), ('179', '13', '1210', 'passive', 'all'), ('180', '14', '1212', 'defense', 'all'), ('181', '14', '1213', 'defense', 'all'), ('182', '14', '1214', 'defense', 'all'), ('183', '14', '1207', 'passive', 'all'), ('184', '14', '1208', 'passive', 'all'), ('185', '14', '1209', 'passive', 'all'), ('186', '14', '1210', 'passive', 'all'), ('187', '15', '1212', 'defense', 'all'), ('188', '15', '1213', 'defense', 'all'), ('189', '15', '1214', 'defense', 'all'), ('190', '15', '1207', 'passive', 'all'), ('191', '15', '1208', 'passive', 'all'), ('192', '15', '1209', 'passive', 'all'), ('193', '15', '1210', 'passive', 'all'), ('194', '16', '1212', 'defense', 'all'), ('195', '16', '1213', 'defense', 'all'), ('196', '16', '1214', 'defense', 'all'), ('197', '16', '1207', 'passive', 'all'), ('198', '16', '1208', 'passive', 'all'), ('199', '16', '1209', 'passive', 'all'), ('200', '16', '1210', 'passive', 'all'), ('201', '17', '1212', 'defense', 'all'), ('202', '17', '1213', 'defense', 'all'), ('203', '17', '1214', 'defense', 'all'), ('204', '17', '1207', 'passive', 'all'), ('205', '17', '1208', 'passive', 'all'), ('206', '17', '1209', 'passive', 'all'), ('207', '17', '1210', 'passive', 'all'), ('208', '18', '1212', 'defense', 'all'), ('209', '18', '1213', 'defense', 'all'), ('210', '18', '1214', 'defense', 'all'), ('211', '18', '1207', 'passive', 'all'), ('212', '18', '1208', 'passive', 'all'), ('213', '18', '1209', 'passive', 'all'), ('214', '18', '1210', 'passive', 'all'), ('215', '19', '1212', 'defense', 'all'), ('216', '19', '1213', 'defense', 'all'), ('217', '19', '1214', 'defense', 'all'), ('218', '19', '1207', 'passive', 'all'), ('219', '19', '1208', 'passive', 'all'), ('220', '19', '1209', 'passive', 'all'), ('221', '19', '1210', 'passive', 'all');

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
INSERT INTO `property_info` VALUES ('27', '1', '0', null);
INSERT INTO `property_info` VALUES ('27', '2', '0', null);
INSERT INTO `property_info` VALUES ('27', '3', '0', null);
INSERT INTO `property_info` VALUES ('28', '1', '0', null);
INSERT INTO `property_info` VALUES ('28', '2', '0', null);
INSERT INTO `property_info` VALUES ('28', '3', '0', null);
INSERT INTO `property_info` VALUES ('29', '1', '0', null);
INSERT INTO `property_info` VALUES ('29', '2', '0', null);
INSERT INTO `property_info` VALUES ('29', '3', '0', null);
INSERT INTO `property_info` VALUES ('30', '1', '0', null);
INSERT INTO `property_info` VALUES ('30', '2', '0', null);
INSERT INTO `property_info` VALUES ('30', '3', '0', null);
INSERT INTO `property_info` VALUES ('31', '1', '0', null);
INSERT INTO `property_info` VALUES ('31', '2', '0', null);
INSERT INTO `property_info` VALUES ('31', '3', '0', null);
INSERT INTO `property_info` VALUES ('32', '1', '0', null);
INSERT INTO `property_info` VALUES ('32', '2', '0', null);
INSERT INTO `property_info` VALUES ('32', '3', '0', null);
INSERT INTO `property_info` VALUES ('33', '1', '0', null);
INSERT INTO `property_info` VALUES ('33', '2', '0', null);
INSERT INTO `property_info` VALUES ('33', '3', '0', null);
INSERT INTO `property_info` VALUES ('34', '1', '0', null);
INSERT INTO `property_info` VALUES ('34', '2', '0', null);
INSERT INTO `property_info` VALUES ('34', '3', '0', null);
INSERT INTO `property_info` VALUES ('35', '1', '0', null);
INSERT INTO `property_info` VALUES ('35', '2', '0', null);
INSERT INTO `property_info` VALUES ('35', '3', '0', null);
INSERT INTO `property_info` VALUES ('36', '1', '0', null);
INSERT INTO `property_info` VALUES ('36', '2', '0', null);
INSERT INTO `property_info` VALUES ('36', '3', '0', null);
INSERT INTO `property_info` VALUES ('37', '1', '0', null);
INSERT INTO `property_info` VALUES ('37', '2', '0', null);
INSERT INTO `property_info` VALUES ('37', '3', '0', null);
INSERT INTO `property_info` VALUES ('38', '1', '0', null);
INSERT INTO `property_info` VALUES ('38', '2', '0', null);
INSERT INTO `property_info` VALUES ('38', '3', '0', null);
INSERT INTO `property_info` VALUES ('39', '1', '0', null);
INSERT INTO `property_info` VALUES ('39', '2', '0', null);
INSERT INTO `property_info` VALUES ('39', '3', '0', null);

-- ----------------------------
-- Table structure for `user_bind`
-- ----------------------------
DROP TABLE IF EXISTS `user_bind`;
CREATE TABLE `user_bind` (
  `master_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '账户ID',
  `bind_type` varchar(4) NOT NULL COMMENT '绑定类型',
  `bind_value` varchar(500) NOT NULL COMMENT '绑定值',
  PRIMARY KEY (`matser_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='用户绑定表';

-- ----------------------------
-- Records of user_bind
-- ----------------------------
INSERT INTO `user_bind` VALUES ('26', 'mac', 'EC:6C:9F:0E:A4:36');

-- ----------------------------
-- Table structure for `user_equip`
-- ----------------------------
DROP TABLE IF EXISTS `user_equip`;
CREATE TABLE `user_equip` (
  `user_equip_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户装备ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `equip_colour` int(11) NOT NULL COMMENT '装备品质ID',
  `equip_type` int(11) NOT NULL COMMENT '装备名称ID',
  `equip_quality` tinyint(4) NOT NULL COMMENT '装备品质ID',
  `equip_level` int(11) NOT NULL COMMENT '装备等级',
  `forge_level` int(11) NOT NULL COMMENT '锻造等级',
  `is_used` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否被使用',
  `race_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '种族ID',
  `attribute_list` text NOT NULL COMMENT '扩展属性',
  `attribute_base_list` text NOT NULL COMMENT '基本属性信息',
  PRIMARY KEY (`user_equip_id`)
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=utf8 COMMENT='用户装备列表';

-- ----------------------------
-- Records of user_equip
-- ----------------------------
INSERT INTO `user_equip` VALUES ('121', '27', '3', '4', '1', '4', '0', '0', '{\"202\":1,\"211\":1}', '{\"112\":10}');
INSERT INTO `user_equip` VALUES ('122', '27', '2', '6', '2', '1', '0', '0', '{\"112\":5,\"105\":7}', '{\"112\":5,\"105\":7}');
INSERT INTO `user_equip` VALUES ('123', '27', '1', '3', '1', '0', '0', '0', 'null', '{\"110\":6}');
INSERT INTO `user_equip` VALUES ('124', '27', '3', '1', '1', '5', '0', '0', '{\"1106\":1.404,\"1212\":1}', '{\"106\":11,\"107\":12}');
INSERT INTO `user_equip` VALUES ('125', '27', '1', '4', '1', '3', '0', '0', 'null', '{\"112\":8}');
INSERT INTO `user_equip` VALUES ('126', '27', '1', '1', '1', '3', '0', '0', 'null', '{\"106\":12,\"107\":11}');
INSERT INTO `user_equip` VALUES ('127', '27', '2', '6', '1', '5', '0', '0', 'null', '{\"112\":3,\"105\":5}');
INSERT INTO `user_equip` VALUES ('128', '27', '3', '1', '1', '3', '0', '0', '{\"1108\":6.4,\"1210\":1}', '{\"106\":11,\"107\":10}');
INSERT INTO `user_equip` VALUES ('129', '27', '1', '4', '2', '4', '0', '0', 'null', '{\"112\":10}');
INSERT INTO `user_equip` VALUES ('130', '27', '1', '1', '2', '0', '0', '0', 'null', '{\"106\":12,\"107\":11}');
INSERT INTO `user_equip` VALUES ('131', '27', '1', '6', '1', '4', '0', '0', 'null', '{\"112\":3,\"105\":6}');
INSERT INTO `user_equip` VALUES ('132', '27', '3', '1', '1', '3', '0', '0', '{\"1110\":0.768,\"1205\":1}', '{\"106\":13,\"107\":12}');
INSERT INTO `user_equip` VALUES ('133', '27', '1', '1', '1', '1', '0', '0', 'null', '{\"106\":11,\"107\":12}');
INSERT INTO `user_equip` VALUES ('134', '27', '1', '3', '1', '5', '0', '0', 'null', '{\"110\":5}');
INSERT INTO `user_equip` VALUES ('135', '27', '5', '5', '1', '0', '0', '0', '{\"1113\":0.4,\"1201\":1,\"1210\":1,\"1213\":1}', '{\"112\":5,\"109\":12}');
INSERT INTO `user_equip` VALUES ('136', '27', '1', '5', '1', '13', '0', '0', 'null', '{\"112\":11,\"109\":28}');
INSERT INTO `user_equip` VALUES ('137', '27', '2', '2', '1', '5', '0', '0', 'null', '{\"112\":3,\"108\":0}');
INSERT INTO `user_equip` VALUES ('138', '27', '4', '1', '2', '0', '0', '0', '{\"1107\":4.07,\"1113\":0.7,\"1109\":15}', '{\"106\":10,\"107\":12}');
INSERT INTO `user_equip` VALUES ('139', '27', '1', '4', '1', '0', '0', '0', 'null', '{\"112\":8}');
INSERT INTO `user_equip` VALUES ('140', '27', '1', '4', '2', '0', '0', '0', 'null', '{\"112\":13}');
INSERT INTO `user_equip` VALUES ('141', '27', '2', '4', '1', '1', '0', '0', 'null', '{\"112\":11}');
INSERT INTO `user_equip` VALUES ('142', '27', '1', '6', '1', '4', '0', '0', 'null', '{\"112\":4,\"105\":7}');
INSERT INTO `user_equip` VALUES ('143', '27', '1', '3', '2', '4', '0', '0', 'null', '{\"110\":5}');
INSERT INTO `user_equip` VALUES ('144', '27', '1', '4', '2', '5', '0', '0', 'null', '{\"112\":9}');
INSERT INTO `user_equip` VALUES ('145', '27', '1', '5', '1', '2', '0', '0', 'null', '{\"112\":6,\"109\":0}');
INSERT INTO `user_equip` VALUES ('146', '27', '1', '3', '1', '4', '0', '0', 'null', '{\"110\":5}');
INSERT INTO `user_equip` VALUES ('147', '27', '1', '4', '1', '1', '0', '0', 'null', '{\"112\":11}');
INSERT INTO `user_equip` VALUES ('148', '27', '3', '6', '2', '5', '0', '0', '{\"1109\":16,\"1102\":1}', '{\"112\":4,\"105\":7}');
INSERT INTO `user_equip` VALUES ('149', '27', '2', '6', '4', '0', '0', '0', 'null', '{\"112\":5,\"105\":7}');
INSERT INTO `user_equip` VALUES ('150', '27', '3', '6', '1', '2', '0', '0', '{\"1111\":0.14,\"1205\":1}', '{\"112\":3,\"105\":7}');

-- ----------------------------
-- Table structure for `user_info`
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `race_id` int(11) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `user_level` int(11) NOT NULL DEFAULT '0' COMMENT '等级',
  `experience` int(11) NOT NULL DEFAULT '0' COMMENT '经验',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '金钱,以分为单位',
  `reserve` int(11) NOT NULL DEFAULT '0' COMMENT '储备金',
  `ingot` int(11) NOT NULL DEFAULT '0' COMMENT '元宝数量',
  `skil_point` int(11) NOT NULL DEFAULT '0' COMMENT '技能点',
  `points` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `pack_num` int(11) NOT NULL DEFAULT '0' COMMENT '背包数量',
  `pk_num` int(11) NOT NULL DEFAULT '0' COMMENT 'PK次数',
  `friend_num` int(11) NOT NULL DEFAULT '0' COMMENT '好友数量',
  `pet_num` int(11) NOT NULL DEFAULT '0' COMMENT '人宠数量',
  `matser_id` int(11) NOT NULL COMMENT '帐号ID',
  `area_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分区',
  `reputation` int(11) NOT NULL COMMENT '声望',
  `integral` int(11) DEFAULT NULL COMMENT '积分',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='用户信息';

-- ----------------------------
-- Records of user_info
-- ----------------------------
INSERT INTO `user_info` VALUES ('27', '郝晓凯', '1', '0', '33111', '5526', '0', '0', '40', '0', '20', '10', '26', '1', '0');
INSERT INTO `user_info` VALUES ('1', '反对诉讼费', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0');
INSERT INTO `user_info` VALUES ('2', 'dsfw', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0');
INSERT INTO `user_info` VALUES ('3', 'sedf', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0');
INSERT INTO `user_info` VALUES ('28', '赵飞燕', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '26', '1', '0');

-- ----------------------------
-- Table structure for `user_lbs`
-- ----------------------------
DROP TABLE IF EXISTS `user_lbs`;
CREATE TABLE `user_lbs` (
  `user_id` int(11) NOT NULL,
  `longitude` char(12) NOT NULL COMMENT '经度',
  `latitude` char(12) NOT NULL COMMENT '维度',
  `last_login_time` int(11) DEFAULT NULL COMMENT '上次登陆时间',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_lbs
-- ----------------------------
INSERT INTO `user_lbs` VALUES ('1', '116.417382', '39.941460', null);
INSERT INTO `user_lbs` VALUES ('2', '116.417381', '139.941461', null);
INSERT INTO `user_lbs` VALUES ('3', '136.417383', '39.941463', null);
INSERT INTO `user_lbs` VALUES ('27', '116.417380', '39.941462', null);

-- ----------------------------
-- Table structure for `user_pet`
-- ----------------------------
DROP TABLE IF EXISTS `user_pet`;
CREATE TABLE `user_pet` (
  `user_id` int(11) NOT NULL COMMENT '角色ID',
  `pet_id` int(11) DEFAULT NULL COMMENT '人宠ID',
  `validity_time` int(11) DEFAULT NULL COMMENT '有效期',
  `is_use` enum('2','1') DEFAULT '1' COMMENT '是否驱使(1没有2正在)',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_pet
-- ----------------------------

-- ----------------------------
-- Table structure for `user_skill`
-- ----------------------------
DROP TABLE IF EXISTS `user_skill`;
CREATE TABLE `user_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `skill_level` int(11) NOT NULL,
  `skill_type` enum('4','3','2','1') NOT NULL DEFAULT '1' COMMENT '技能类别 1物理2法术3防御4被动',
  `is_use` enum('1','2') DEFAULT '1' COMMENT '是否被使用 1未被使用 2使用中',
  `skill_location` int(11) DEFAULT NULL COMMENT '技能位置',
  `odds_set` tinyint(3) DEFAULT NULL COMMENT '使用频率',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_skill
-- ----------------------------
INSERT INTO `user_skill` VALUES ('1', '27', '1201', '23', '1', '2', '0');
INSERT INTO `user_skill` VALUES ('2', '27', '1202', '45', '1', '2', null);
INSERT INTO `user_skill` VALUES ('3', '27', '1203', '13', '1', '2', null);
INSERT INTO `user_skill` VALUES ('4', '27', '1204', '1', '1', '2', null);
INSERT INTO `user_skill` VALUES ('5', '27', '1205', '2', '1', '2', null);
INSERT INTO `user_skill` VALUES ('6', '27', '1206', '3', '1', '2', null);
INSERT INTO `user_skill` VALUES ('7', '27', '1212', '3', '1', '2', null);
INSERT INTO `user_skill` VALUES ('8', '27', '1213', '0', '1', '2', null);

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

DROP TABLE IF EXISTS `map_skill_conf_must`;
CREATE TABLE `map_skill_conf_must` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT '类型',
  `type_id` int(11) NOT NULL,
  `skill_ids` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `map_skill_conf_must`
-- ----------------------------
INSERT INTO `map_skill_conf_must` VALUES ('1', '1', 'suffix', '1', '{\"attack\":[1201,1202],\"defense\":[1212],\"passive\":[1207]}');

DROP TABLE IF EXISTS `map_skill_conf_num`;
CREATE TABLE `map_skill_conf_num` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NOT NULL,
  `can_have_num` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `map_id` (`map_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `map_skill_conf_num`
-- ----------------------------
INSERT INTO `map_skill_conf_num` VALUES ('1', '1', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('2', '2', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('3', '3', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('4', '4', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('5', '5', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('6', '6', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('7', '7', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('8', '8', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('9', '9', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('10', '10', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('11', '11', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('12', '12', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('13', '13', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('14', '14', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('15', '15', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('16', '16', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('17', '17', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('18', '18', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}'), ('19', '19', '{\"attack\":{\"suffix\":{\"1\":2,\"2\":2,\"3\":3,\"4\":3,\"5\":4,\"6\":4,\"7\":5,\"8\":5}},\"defense\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":3}},\"passive\":{\"suffix\":{\"1\":0,\"2\":0,\"3\":1,\"4\":1,\"5\":2,\"6\":2,\"7\":3,\"8\":4}}}');

DROP TABLE IF EXISTS `user_pk_times`;
CREATE TABLE `user_pk_times` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `times` int(11) NOT NULL,
  `update_time` datetime NOT NULL COMMENT 'PK的时间',
  `type` varchar(10) NOT NULL COMMENT '挑战还是征服:challenge|conquer',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `fight_setting`;
CREATE TABLE `fight_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `gray` tinyint(1) NOT NULL DEFAULT '0',
  `white` tinyint(1) NOT NULL DEFAULT '0',
  `green` tinyint(1) NOT NULL DEFAULT '0',
  `blue` tinyint(1) NOT NULL DEFAULT '0',
  `purple` tinyint(1) NOT NULL DEFAULT '0',
  `orange` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_reward` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `name` varchar(100) NOT NULL,
        `desc` varchar(300) DEFAULT NULL,
        `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '类型  1：登录奖励 2：升级奖励 3：首充奖励',
        `status` int(11) NOT NULL COMMENT '状态 1：进行中 2：已完成',
        `create_time` datetime NOT NULL COMMENT '记录创建时间',
        PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_happy_month_log`;
CREATE TABLE `user_happy_month_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` varchar(500) NOT NULL DEFAULT '',
  `ctime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_pk_challenge_res`;
CREATE TABLE `user_pk_challenge_res` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`fight_num` int(11) NOT NULL,
	`win_num` int(11) NOT NULL COMMENT '战胜总场次',
	`win_continue_num` int(11) NOT NULL COMMENT '连胜场数',
	`update_time` datetime NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=`InnoDB` AUTO_INCREMENT=1 DEFAULT CHARACTER SET utf8;
-- MySQL dump 10.13  Distrib 5.1.60, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: app_fightgame
-- ------------------------------------------------------
-- Server version	5.1.60-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `iap_product`
--

DROP TABLE IF EXISTS `iap_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iap_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `iap_product_id` varchar(100) NOT NULL,
  `static_code` int(6) DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `ingot` int(6) NOT NULL,
  `price` decimal(5,2) DEFAULT NULL,
  `present_type` tinyint(3) NOT NULL,
  `present_num` int(6) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `iap_product_id` (`iap_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iap_product`
--

LOCK TABLES `iap_product` WRITE;
/*!40000 ALTER TABLE `iap_product` DISABLE KEYS */;
INSERT INTO `iap_product` VALUES (1,'com.fightgame.baoyue',6101,'战斗宝',300,'30.00',1,0,1),(2,'com.fightgame.6yuan',6102,'6元包套餐',60,'6.00',2,0,1),('3','com.fightgame.12yuan',6103,'12元包',125,'12.00',2,5,1),(4,'com.fightgame.30yuan',6104,'30元包套餐',330,'30.00',2,30,1),(5,'com.fightgame.80yuan',6105,'78元包套餐',900,'78.00',2,120,1),(6,'com.fightgame.158yuan',6106,'158元包套餐',1900,'158.00',2,320,1),(7,'com.fightgame.318yuan',6107,'318元包套餐',3795,'318.00',2,795,1),(8,'com.fightgame.648yuan',6108,'648元包套餐',8424,'648.00',2,1944,1);
/*!40000 ALTER TABLE `iap_product` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

-- MySQL dump 10.13  Distrib 5.1.60, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: app_fightgame
-- ------------------------------------------------------
-- Server version	5.1.60-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `iap_purchase_log`
--

DROP TABLE IF EXISTS `iap_purchase_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iap_purchase_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_receipt` varchar(300) NOT NULL,
  `verify_status` tinyint(3) NOT NULL DEFAULT '-1',
  `ctime` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iap_purchase_log`
--

LOCK TABLES `iap_purchase_log` WRITE;
/*!40000 ALTER TABLE `iap_purchase_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `iap_purchase_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-27 19:00:17

-- MySQL dump 10.13  Distrib 5.1.60, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: app_fightgame
-- ------------------------------------------------------
-- Server version	5.1.60-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `props`
--

DROP TABLE IF EXISTS `props`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `props` (
  `props_id` int(11) NOT NULL AUTO_INCREMENT,
  `props_cate_id` int(11) NOT NULL,
  `static_code` int(6) DEFAULT NULL,
  `props_name` varchar(100) NOT NULL,
  `price_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '价格类型  1：固定价格  2：动态价格',
  `price` int(11) NOT NULL COMMENT '花费的元宝数',
  PRIMARY KEY (`props_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `props`
--

LOCK TABLES `props` WRITE;
/*!40000 ALTER TABLE `props` DISABLE KEYS */;
INSERT INTO `props` VALUES (1,1,6301,'双倍咒符',1,20),(2,1,6302,'PK咒符',1,10),(3,1,6303,'属性增强咒符',1,20),(4,1,6304,'人宠增强咒符',1,10),(5,1,6305,'背包咒符',1,10),(6,1,6306,'挂机咒符',1,50),(7,1,6307,'好友上限咒符',1,100),(8,2,6308,'锻造成功咒符',1,100),(9,2,6309,'装备成长咒符',2,0),(10,3,6310,'30级普通宝箱',1,300),(11,3,6311,'30级精品宝箱',1,2400),(12,3,6312,'40级普通宝箱',1,400),(13,3,6313,'40级精品宝箱',1,3200),(14,3,6314,'50级普通宝箱',1,500),(15,3,6315,'50级精品宝箱',1,4000),(16,3,6316,'60级普通宝箱',1,600),(17,3,6317,'60级精品宝箱',1,4800),(18,3,6318,'70级普通宝箱',1,700),(19,3,6319,'70级精品宝箱',1,5600),(20,3,6320,'80级普通宝箱',1,800),(21,3,6321,'80级精品宝箱',1,6400),(22,3,6322,'90级普通宝箱',1,900),(23,3,6323,'90级精品宝箱',1,7200),(24,3,6324,'100级普通宝箱',1,1000),(25,3,6325,'100级精品宝箱',1,8000);
/*!40000 ALTER TABLE `props` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-27 19:00:45

-- MySQL dump 10.13  Distrib 5.1.60, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: app_fightgame
-- ------------------------------------------------------
-- Server version	5.1.60-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `props_cate`
--

DROP TABLE IF EXISTS `props_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `props_cate` (
  `props_cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `static_code` int(6) DEFAULT NULL,
  `cate_name` varchar(30) NOT NULL,
  PRIMARY KEY (`props_cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `props_cate`
--

LOCK TABLES `props_cate` WRITE;
/*!40000 ALTER TABLE `props_cate` DISABLE KEYS */;
INSERT INTO `props_cate` VALUES (1,6201,'辅助类'),(2,6202,'锻造类'),(3,6203,'上古遗迹');
/*!40000 ALTER TABLE `props_cate` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-27 19:05:05
DROP TABLE IF EXISTS `copies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `copies` (
  `copies_id` int(11) NOT NULL AUTO_INCREMENT,
  `copies_name` varchar(50) NOT NULL COMMENT '副本名称',
  `level_limit` int(5) NOT NULL COMMENT '级别限制',
  `static_code` int(6) DEFAULT NULL COMMENT '静态资源编码',
  `monster_num` int(6) NOT NULL COMMENT '怪物数量',
  PRIMARY KEY (`copies_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `copies`
--

LOCK TABLES `copies` WRITE;
/*!40000 ALTER TABLE `copies` DISABLE KEYS */;
INSERT INTO `copies` VALUES (1,'玲珑宝塔',10,7100,100);
/*!40000 ALTER TABLE `copies` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `copies_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `copies_level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(300) NOT NULL,
  `copies_id` int(11) NOT NULL COMMENT '副本id',
  `monster_level` int(2) NOT NULL COMMENT '怪物等级',
  `monster_level_type` tinyint(3) NOT NULL COMMENT '怪物等级类型  1：小于  2：大于',
  `monster_suffix` int(6) DEFAULT NULL COMMENT '怪物后缀',
  `monster_skill` varchar(300) NOT NULL COMMENT '怪物技能',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `copies_level`
--

LOCK TABLES `copies_level` WRITE;
/*!40000 ALTER TABLE `copies_level` DISABLE KEYS */;
INSERT INTO `copies_level` VALUES (1,'第一层',1,4,1,3208,'1201,1202,1203,1204,1205,1206'),(2,'第二层',1,3,1,3205,'1204,1205,1206'),(3,'第三层',1,2,1,3204,'1201,1202,1203'),(4,'第四层',1,1,1,3206,'1204,1205,1206,1212,1214'),(5,'第五层',1,0,2,3207,'1201,1202,1203,1212,1214'),(6,'第六层',1,1,3,3203,'1203,1204,1205,1212,1213,1214'),(7,'第七层',1,2,3,3202,'1201,1202,1203');
/*!40000 ALTER TABLE `copies_level` ENABLE KEYS */;
UNLOCK TABLES;
