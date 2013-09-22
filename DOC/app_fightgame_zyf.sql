/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50150
Source Host           : localhost:3306
Source Database       : app_fightgame

Target Server Type    : MYSQL
Target Server Version : 50150
File Encoding         : 65001

Date: 2013-09-16 17:32:08
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
) ENGINE=MyISAM AUTO_INCREMENT=311 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of equip_attributes
-- ----------------------------
INSERT INTO `equip_attributes` VALUES ('1', '1', 'general', '106', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('2', '1', 'general', '107', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('3', '1', 'high', '106', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('4', '1', 'high', '107', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('5', '1', 'vh', '106', '0', '9', '20', '34');
INSERT INTO `equip_attributes` VALUES ('6', '1', 'vh', '107', '0', '9', '15', '26');
INSERT INTO `equip_attributes` VALUES ('7', '1', 'general', '106', '10', '19', '40', '68');
INSERT INTO `equip_attributes` VALUES ('8', '1', 'general', '107', '10', '19', '28', '48');
INSERT INTO `equip_attributes` VALUES ('9', '1', 'high', '106', '10', '19', '45', '58');
INSERT INTO `equip_attributes` VALUES ('10', '1', 'high', '107', '10', '19', '40', '52');
INSERT INTO `equip_attributes` VALUES ('11', '1', 'vh', '106', '10', '19', '47', '60');
INSERT INTO `equip_attributes` VALUES ('12', '1', 'vh', '107', '10', '19', '42', '54');
INSERT INTO `equip_attributes` VALUES ('13', '1', 'general', '106', '20', '29', '64', '109');
INSERT INTO `equip_attributes` VALUES ('14', '1', 'general', '107', '20', '29', '48', '82');
INSERT INTO `equip_attributes` VALUES ('15', '1', 'high', '106', '20', '29', '80', '104');
INSERT INTO `equip_attributes` VALUES ('16', '1', 'high', '107', '20', '29', '70', '91');
INSERT INTO `equip_attributes` VALUES ('17', '1', 'vh', '106', '20', '29', '84', '109');
INSERT INTO `equip_attributes` VALUES ('18', '1', 'vh', '107', '20', '29', '73', '95');
INSERT INTO `equip_attributes` VALUES ('19', '1', 'general', '106', '30', '39', '88', '105');
INSERT INTO `equip_attributes` VALUES ('20', '1', 'general', '107', '30', '39', '68', '116');
INSERT INTO `equip_attributes` VALUES ('21', '1', 'high', '106', '30', '39', '115', '149');
INSERT INTO `equip_attributes` VALUES ('22', '1', 'high', '107', '30', '39', '100', '130');
INSERT INTO `equip_attributes` VALUES ('23', '1', 'high', '106', '30', '39', '115', '149');
INSERT INTO `equip_attributes` VALUES ('24', '1', 'high', '107', '30', '39', '100', '130');
INSERT INTO `equip_attributes` VALUES ('25', '1', 'general', '106', '40', '49', '112', '190');
INSERT INTO `equip_attributes` VALUES ('26', '1', 'general', '107', '40', '49', '88', '150');
INSERT INTO `equip_attributes` VALUES ('27', '1', 'high', '106', '40', '49', '150', '195');
INSERT INTO `equip_attributes` VALUES ('28', '1', 'high', '107', '40', '49', '130', '169');
INSERT INTO `equip_attributes` VALUES ('29', '1', 'vh', '106', '40', '49', '157', '204');
INSERT INTO `equip_attributes` VALUES ('30', '1', 'vh', '107', '40', '49', '136', '177');
INSERT INTO `equip_attributes` VALUES ('31', '1', 'general', '106', '50', '59', '136', '231');
INSERT INTO `equip_attributes` VALUES ('32', '1', 'general', '107', '50', '59', '108', '184');
INSERT INTO `equip_attributes` VALUES ('33', '1', 'high', '106', '50', '59', '185', '240');
INSERT INTO `equip_attributes` VALUES ('34', '1', 'high', '107', '50', '59', '160', '208');
INSERT INTO `equip_attributes` VALUES ('35', '1', 'vh', '106', '50', '59', '194', '252');
INSERT INTO `equip_attributes` VALUES ('36', '1', 'vh', '107', '50', '59', '168', '218');
INSERT INTO `equip_attributes` VALUES ('37', '1', 'general', '106', '60', '69', '160', '272');
INSERT INTO `equip_attributes` VALUES ('38', '1', 'general', '107', '60', '69', '128', '218');
INSERT INTO `equip_attributes` VALUES ('39', '1', 'high', '106', '60', '69', '220', '286');
INSERT INTO `equip_attributes` VALUES ('40', '1', 'high', '107', '60', '69', '190', '247');
INSERT INTO `equip_attributes` VALUES ('41', '1', 'vh', '106', '60', '69', '231', '300');
INSERT INTO `equip_attributes` VALUES ('42', '1', 'vh', '107', '60', '69', '199', '259');
INSERT INTO `equip_attributes` VALUES ('43', '1', 'general', '106', '70', '79', '184', '313');
INSERT INTO `equip_attributes` VALUES ('44', '1', 'general', '107', '70', '79', '148', '252');
INSERT INTO `equip_attributes` VALUES ('45', '1', 'high', '106', '70', '79', '255', '331');
INSERT INTO `equip_attributes` VALUES ('46', '1', 'high', '107', '70', '79', '220', '286');
INSERT INTO `equip_attributes` VALUES ('47', '1', 'vh', '106', '70', '79', '267', '347');
INSERT INTO `equip_attributes` VALUES ('48', '1', 'vh', '107', '70', '79', '231', '300');
INSERT INTO `equip_attributes` VALUES ('49', '1', 'general', '106', '80', '89', '208', '354');
INSERT INTO `equip_attributes` VALUES ('50', '1', 'general', '107', '80', '89', '168', '286');
INSERT INTO `equip_attributes` VALUES ('51', '1', 'high', '106', '80', '89', '290', '377');
INSERT INTO `equip_attributes` VALUES ('52', '1', 'high', '107', '80', '89', '250', '325');
INSERT INTO `equip_attributes` VALUES ('53', '1', 'vh', '106', '80', '89', '304', '395');
INSERT INTO `equip_attributes` VALUES ('54', '1', 'vh', '107', '80', '89', '262', '341');
INSERT INTO `equip_attributes` VALUES ('55', '1', 'high', '106', '90', '99', '325', '422');
INSERT INTO `equip_attributes` VALUES ('56', '1', 'high', '107', '90', '99', '280', '364');
INSERT INTO `equip_attributes` VALUES ('57', '1', 'vh', '106', '90', '99', '341', '443');
INSERT INTO `equip_attributes` VALUES ('58', '1', 'vh', '107', '90', '99', '294', '382');
INSERT INTO `equip_attributes` VALUES ('59', '1', 'high', '106', '100', '109', '360', '468');
INSERT INTO `equip_attributes` VALUES ('60', '1', 'high', '107', '100', '109', '310', '403');
INSERT INTO `equip_attributes` VALUES ('61', '1', 'vh', '106', '100', '109', '378', '491');
INSERT INTO `equip_attributes` VALUES ('62', '1', 'vh', '107', '100', '109', '325', '423');
INSERT INTO `equip_attributes` VALUES ('63', '2', 'general', '112', '0', '9', '2', '5');
INSERT INTO `equip_attributes` VALUES ('64', '2', 'general', '108', '0', '9', '0', '0');
INSERT INTO `equip_attributes` VALUES ('65', '2', 'high', '112', '0', '9', '2', '5');
INSERT INTO `equip_attributes` VALUES ('66', '2', 'high', '108', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('67', '2', 'vh', '112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('68', '2', 'vh', '108', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('69', '2', 'general', '112', '10', '19', '6', '14');
INSERT INTO `equip_attributes` VALUES ('70', '2', 'general', '108', '10', '19', '10', '15');
INSERT INTO `equip_attributes` VALUES ('71', '2', 'high', '112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('72', '2', 'high', '108', '10', '19', '15', '19');
INSERT INTO `equip_attributes` VALUES ('73', '2', 'vh', '112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('74', '2', 'vh', '108', '10', '19', '15', '20');
INSERT INTO `equip_attributes` VALUES ('75', '2', 'general', '112', '20', '29', '10', '17');
INSERT INTO `equip_attributes` VALUES ('76', '2', 'general', '108', '20', '29', '20', '29');
INSERT INTO `equip_attributes` VALUES ('77', '2', 'high', '112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('78', '2', 'high', '108', '20', '29', '25', '32');
INSERT INTO `equip_attributes` VALUES ('79', '2', 'vh', '112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('80', '2', 'vh', '108', '20', '29', '26', '34');
INSERT INTO `equip_attributes` VALUES ('81', '2', 'general', '112', '30', '39', '88', '105');
INSERT INTO `equip_attributes` VALUES ('82', '2', 'general', '108', '30', '39', '68', '116');
INSERT INTO `equip_attributes` VALUES ('83', '2', 'high', '112', '30', '39', '115', '149');
INSERT INTO `equip_attributes` VALUES ('84', '2', 'high', '108', '30', '39', '100', '130');
INSERT INTO `equip_attributes` VALUES ('85', '2', 'vh', '112', '30', '39', '120', '156');
INSERT INTO `equip_attributes` VALUES ('86', '2', 'vh', '108', '30', '39', '105', '136');
INSERT INTO `equip_attributes` VALUES ('87', '2', 'general', '112', '40', '49', '112', '190');
INSERT INTO `equip_attributes` VALUES ('88', '2', 'general', '108', '40', '49', '88', '150');
INSERT INTO `equip_attributes` VALUES ('89', '2', 'high', '112', '40', '49', '150', '195');
INSERT INTO `equip_attributes` VALUES ('90', '2', 'high', '108', '40', '49', '130', '169');
INSERT INTO `equip_attributes` VALUES ('91', '2', 'vh', '112', '40', '49', '157', '204');
INSERT INTO `equip_attributes` VALUES ('92', '2', 'vh', '108', '40', '49', '136', '177');
INSERT INTO `equip_attributes` VALUES ('93', '2', 'general', '112', '50', '59', '136', '231');
INSERT INTO `equip_attributes` VALUES ('94', '2', 'general', '108', '50', '59', '108', '184');
INSERT INTO `equip_attributes` VALUES ('95', '2', 'high', '112', '50', '59', '185', '240');
INSERT INTO `equip_attributes` VALUES ('96', '2', 'high', '108', '50', '59', '160', '208');
INSERT INTO `equip_attributes` VALUES ('97', '2', 'vh', '112', '50', '59', '194', '252');
INSERT INTO `equip_attributes` VALUES ('98', '2', 'vh', '108', '50', '59', '168', '218');
INSERT INTO `equip_attributes` VALUES ('99', '2', 'general', '112', '60', '69', '160', '272');
INSERT INTO `equip_attributes` VALUES ('100', '2', 'general', '108', '60', '69', '128', '218');
INSERT INTO `equip_attributes` VALUES ('101', '2', 'high', '112', '60', '69', '220', '286');
INSERT INTO `equip_attributes` VALUES ('102', '2', 'high', '108', '60', '69', '190', '247');
INSERT INTO `equip_attributes` VALUES ('103', '2', 'vh', '112', '60', '69', '231', '300');
INSERT INTO `equip_attributes` VALUES ('104', '2', 'vh', '108', '60', '69', '199', '259');
INSERT INTO `equip_attributes` VALUES ('105', '2', 'general', '112', '70', '79', '184', '313');
INSERT INTO `equip_attributes` VALUES ('106', '2', 'general', '108', '70', '79', '148', '252');
INSERT INTO `equip_attributes` VALUES ('107', '2', 'high', '112', '70', '79', '255', '331');
INSERT INTO `equip_attributes` VALUES ('108', '2', 'high', '108', '70', '79', '220', '286');
INSERT INTO `equip_attributes` VALUES ('109', '2', 'vh', '112', '70', '79', '267', '347');
INSERT INTO `equip_attributes` VALUES ('110', '2', 'vh', '108', '70', '79', '231', '300');
INSERT INTO `equip_attributes` VALUES ('111', '2', 'general', '112', '80', '89', '208', '354');
INSERT INTO `equip_attributes` VALUES ('112', '2', 'general', '108', '80', '89', '168', '286');
INSERT INTO `equip_attributes` VALUES ('113', '2', 'high', '112', '80', '89', '290', '377');
INSERT INTO `equip_attributes` VALUES ('114', '2', 'high', '108', '80', '89', '250', '325');
INSERT INTO `equip_attributes` VALUES ('115', '2', 'vh', '112', '80', '89', '304', '395');
INSERT INTO `equip_attributes` VALUES ('116', '2', 'vh', '108', '80', '89', '262', '341');
INSERT INTO `equip_attributes` VALUES ('117', '2', 'high', '112', '90', '99', '325', '422');
INSERT INTO `equip_attributes` VALUES ('118', '2', 'high', '108', '90', '99', '280', '364');
INSERT INTO `equip_attributes` VALUES ('119', '2', 'vh', '112', '90', '99', '341', '443');
INSERT INTO `equip_attributes` VALUES ('120', '2', 'vh', '108', '90', '99', '294', '382');
INSERT INTO `equip_attributes` VALUES ('121', '2', 'high', '112', '100', '109', '360', '468');
INSERT INTO `equip_attributes` VALUES ('122', '2', 'high', '108', '100', '109', '310', '403');
INSERT INTO `equip_attributes` VALUES ('123', '2', 'vh', '112', '100', '109', '378', '491');
INSERT INTO `equip_attributes` VALUES ('124', '2', 'vh', '108', '100', '109', '325', '423');
INSERT INTO `equip_attributes` VALUES ('125', '3', 'general', '110', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('126', '3', 'high', '110', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('127', '3', 'vh', '110', '0', '9', '5', '8');
INSERT INTO `equip_attributes` VALUES ('128', '3', 'general', '110', '10', '19', '12', '20');
INSERT INTO `equip_attributes` VALUES ('129', '3', 'high', '110', '10', '19', '17', '22');
INSERT INTO `equip_attributes` VALUES ('130', '3', 'vh', '110', '10', '19', '17', '23');
INSERT INTO `equip_attributes` VALUES ('131', '3', 'general', '110', '20', '29', '19', '32');
INSERT INTO `equip_attributes` VALUES ('132', '3', 'high', '110', '20', '29', '29', '37');
INSERT INTO `equip_attributes` VALUES ('133', '3', 'vh', '110', '20', '29', '30', '38');
INSERT INTO `equip_attributes` VALUES ('134', '3', 'general', '110', '30', '39', '27', '45');
INSERT INTO `equip_attributes` VALUES ('135', '3', 'high', '110', '30', '39', '41', '53');
INSERT INTO `equip_attributes` VALUES ('136', '3', 'vh', '110', '30', '39', '43', '55');
INSERT INTO `equip_attributes` VALUES ('137', '3', 'general', '110', '40', '49', '34', '57');
INSERT INTO `equip_attributes` VALUES ('138', '3', 'high', '110', '40', '49', '53', '68');
INSERT INTO `equip_attributes` VALUES ('139', '3', 'vh', '110', '40', '49', '55', '71');
INSERT INTO `equip_attributes` VALUES ('140', '3', 'general', '110', '50', '59', '45', '76');
INSERT INTO `equip_attributes` VALUES ('141', '3', 'high', '110', '50', '59', '65', '84');
INSERT INTO `equip_attributes` VALUES ('142', '3', 'vh', '110', '50', '59', '68', '88');
INSERT INTO `equip_attributes` VALUES ('143', '3', 'general', '110', '60', '69', '56', '95');
INSERT INTO `equip_attributes` VALUES ('144', '3', 'high', '110', '60', '69', '77', '100');
INSERT INTO `equip_attributes` VALUES ('145', '3', 'vh', '110', '60', '69', '80', '105');
INSERT INTO `equip_attributes` VALUES ('146', '3', 'general', '110', '70', '79', '65', '110');
INSERT INTO `equip_attributes` VALUES ('147', '3', 'high', '110', '70', '79', '89', '115');
INSERT INTO `equip_attributes` VALUES ('148', '3', 'vh', '110', '70', '79', '93', '120');
INSERT INTO `equip_attributes` VALUES ('149', '3', 'general', '110', '80', '89', '77', '130');
INSERT INTO `equip_attributes` VALUES ('150', '3', 'high', '110', '80', '89', '101', '131');
INSERT INTO `equip_attributes` VALUES ('151', '3', 'vh', '110', '80', '89', '106', '137');
INSERT INTO `equip_attributes` VALUES ('152', '3', 'high', '110', '90', '99', '113', '146');
INSERT INTO `equip_attributes` VALUES ('153', '3', 'vh', '110', '90', '99', '118', '153');
INSERT INTO `equip_attributes` VALUES ('154', '3', 'high', '110', '100', '109', '125', '162');
INSERT INTO `equip_attributes` VALUES ('155', '3', 'vh', '110', '100', '109', '131', '170');
INSERT INTO `equip_attributes` VALUES ('156', '4', 'general', '112', '0', '9', '8', '14');
INSERT INTO `equip_attributes` VALUES ('157', '4', 'high', '112', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('158', '4', 'vh', '112', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('159', '4', 'general', '112', '10', '19', '20', '34');
INSERT INTO `equip_attributes` VALUES ('160', '4', 'high', '112', '10', '19', '25', '32');
INSERT INTO `equip_attributes` VALUES ('161', '4', 'vh', '112', '10', '19', '26', '33');
INSERT INTO `equip_attributes` VALUES ('162', '4', 'general', '112', '20', '29', '29', '49');
INSERT INTO `equip_attributes` VALUES ('163', '4', 'high', '112', '20', '29', '40', '52');
INSERT INTO `equip_attributes` VALUES ('164', '4', 'vh', '112', '20', '29', '42', '54');
INSERT INTO `equip_attributes` VALUES ('165', '4', 'general', '112', '30', '39', '40', '68');
INSERT INTO `equip_attributes` VALUES ('166', '4', 'high', '112', '30', '39', '55', '71');
INSERT INTO `equip_attributes` VALUES ('167', '4', 'vh', '112', '30', '39', '57', '74');
INSERT INTO `equip_attributes` VALUES ('168', '4', 'general', '112', '40', '49', '56', '95');
INSERT INTO `equip_attributes` VALUES ('169', '4', 'high', '112', '40', '49', '70', '91');
INSERT INTO `equip_attributes` VALUES ('170', '4', 'vh', '112', '40', '49', '73', '95');
INSERT INTO `equip_attributes` VALUES ('171', '4', 'general', '112', '50', '59', '64', '109');
INSERT INTO `equip_attributes` VALUES ('172', '4', 'high', '112', '50', '59', '85', '110');
INSERT INTO `equip_attributes` VALUES ('173', '4', 'vh', '112', '50', '59', '89', '115');
INSERT INTO `equip_attributes` VALUES ('174', '4', 'general', '112', '60', '69', '80', '136');
INSERT INTO `equip_attributes` VALUES ('175', '4', 'high', '112', '60', '69', '100', '130');
INSERT INTO `equip_attributes` VALUES ('176', '4', 'vh', '112', '60', '69', '105', '136');
INSERT INTO `equip_attributes` VALUES ('177', '4', 'general', '112', '70', '79', '88', '150');
INSERT INTO `equip_attributes` VALUES ('178', '4', 'high', '112', '70', '79', '115', '149');
INSERT INTO `equip_attributes` VALUES ('179', '4', 'vh', '112', '70', '79', '120', '156');
INSERT INTO `equip_attributes` VALUES ('180', '4', 'general', '112', '80', '89', '100', '170');
INSERT INTO `equip_attributes` VALUES ('181', '4', 'high', '112', '80', '89', '130', '169');
INSERT INTO `equip_attributes` VALUES ('182', '4', 'vh', '112', '80', '89', '136', '177');
INSERT INTO `equip_attributes` VALUES ('183', '4', 'high', '112', '90', '99', '145', '188');
INSERT INTO `equip_attributes` VALUES ('184', '4', 'vh', '112', '90', '99', '152', '197');
INSERT INTO `equip_attributes` VALUES ('185', '4', 'high', '112', '100', '109', '160', '208');
INSERT INTO `equip_attributes` VALUES ('186', '4', 'vh', '112', '100', '109', '168', '218');
INSERT INTO `equip_attributes` VALUES ('187', '5', 'general', '112', '0', '9', '4', '6');
INSERT INTO `equip_attributes` VALUES ('188', '5', 'general', '109', '0', '9', '0', '0');
INSERT INTO `equip_attributes` VALUES ('189', '5', 'high', '112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('190', '5', 'high', '109', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('191', '5', 'vh', '112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('192', '5', 'vh', '109', '0', '9', '10', '13');
INSERT INTO `equip_attributes` VALUES ('193', '5', 'general', '112', '10', '19', '8', '13');
INSERT INTO `equip_attributes` VALUES ('194', '5', 'general', '109', '10', '19', '20', '34');
INSERT INTO `equip_attributes` VALUES ('195', '5', 'high', '112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('196', '5', 'high', '109', '10', '19', '30', '39');
INSERT INTO `equip_attributes` VALUES ('197', '5', 'vh', '112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('198', '5', 'vh', '109', '10', '19', '31', '40');
INSERT INTO `equip_attributes` VALUES ('199', '5', 'general', '112', '20', '29', '10', '17');
INSERT INTO `equip_attributes` VALUES ('200', '5', 'general', '109', '20', '29', '40', '68');
INSERT INTO `equip_attributes` VALUES ('201', '5', 'high', '112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('202', '5', 'high', '109', '20', '29', '50', '65');
INSERT INTO `equip_attributes` VALUES ('203', '5', 'vh', '112', '20', '29', '15', '20');
INSERT INTO `equip_attributes` VALUES ('204', '5', 'vh', '109', '20', '29', '52', '68');
INSERT INTO `equip_attributes` VALUES ('205', '5', 'general', '112', '30', '39', '14', '23');
INSERT INTO `equip_attributes` VALUES ('206', '5', 'general', '109', '30', '39', '60', '102');
INSERT INTO `equip_attributes` VALUES ('207', '5', 'high', '112', '30', '39', '20', '26');
INSERT INTO `equip_attributes` VALUES ('208', '5', 'high', '109', '30', '39', '70', '91');
INSERT INTO `equip_attributes` VALUES ('209', '5', 'vh', '112', '30', '39', '21', '27');
INSERT INTO `equip_attributes` VALUES ('210', '5', 'vh', '109', '30', '39', '73', '95');
INSERT INTO `equip_attributes` VALUES ('211', '5', 'general', '112', '40', '49', '18', '30');
INSERT INTO `equip_attributes` VALUES ('212', '5', 'general', '109', '40', '49', '80', '136');
INSERT INTO `equip_attributes` VALUES ('213', '5', 'high', '112', '40', '49', '25', '32');
INSERT INTO `equip_attributes` VALUES ('214', '5', 'high', '109', '40', '49', '90', '117');
INSERT INTO `equip_attributes` VALUES ('215', '5', 'vh', '112', '40', '49', '26', '34');
INSERT INTO `equip_attributes` VALUES ('216', '5', 'vh', '109', '40', '49', '94', '122');
INSERT INTO `equip_attributes` VALUES ('217', '5', 'general', '112', '50', '59', '22', '37');
INSERT INTO `equip_attributes` VALUES ('218', '5', 'general', '109', '50', '59', '100', '170');
INSERT INTO `equip_attributes` VALUES ('219', '5', 'high', '112', '50', '59', '30', '39');
INSERT INTO `equip_attributes` VALUES ('220', '5', 'high', '109', '50', '59', '110', '143');
INSERT INTO `equip_attributes` VALUES ('221', '5', 'vh', '112', '50', '59', '31', '40');
INSERT INTO `equip_attributes` VALUES ('222', '5', 'vh', '109', '50', '59', '115', '150');
INSERT INTO `equip_attributes` VALUES ('223', '5', 'general', '112', '60', '69', '26', '44');
INSERT INTO `equip_attributes` VALUES ('224', '5', 'general', '109', '60', '69', '120', '204');
INSERT INTO `equip_attributes` VALUES ('225', '5', 'high', '112', '60', '69', '35', '45');
INSERT INTO `equip_attributes` VALUES ('226', '5', 'high', '109', '60', '69', '130', '169');
INSERT INTO `equip_attributes` VALUES ('227', '5', 'vh', '112', '60', '69', '36', '47');
INSERT INTO `equip_attributes` VALUES ('228', '5', 'vh', '109', '60', '69', '136', '177');
INSERT INTO `equip_attributes` VALUES ('229', '5', 'general', '112', '70', '79', '30', '51');
INSERT INTO `equip_attributes` VALUES ('230', '5', 'general', '109', '70', '79', '140', '238');
INSERT INTO `equip_attributes` VALUES ('231', '5', 'high', '112', '70', '79', '40', '52');
INSERT INTO `equip_attributes` VALUES ('232', '5', 'high', '109', '70', '79', '150', '195');
INSERT INTO `equip_attributes` VALUES ('233', '5', 'vh', '112', '70', '79', '42', '54');
INSERT INTO `equip_attributes` VALUES ('234', '5', 'vh', '109', '70', '79', '157', '204');
INSERT INTO `equip_attributes` VALUES ('235', '5', 'general', '112', '80', '89', '34', '57');
INSERT INTO `equip_attributes` VALUES ('236', '5', 'general', '109', '80', '89', '160', '272');
INSERT INTO `equip_attributes` VALUES ('237', '5', 'high', '112', '80', '89', '45', '58');
INSERT INTO `equip_attributes` VALUES ('238', '5', 'high', '109', '80', '89', '170', '221');
INSERT INTO `equip_attributes` VALUES ('239', '5', 'vh', '112', '80', '89', '47', '61');
INSERT INTO `equip_attributes` VALUES ('240', '5', 'vh', '109', '80', '89', '178', '232');
INSERT INTO `equip_attributes` VALUES ('241', '5', 'high', '112', '90', '99', '50', '65');
INSERT INTO `equip_attributes` VALUES ('242', '5', 'high', '109', '90', '99', '190', '247');
INSERT INTO `equip_attributes` VALUES ('243', '5', 'vh', '112', '90', '99', '52', '68');
INSERT INTO `equip_attributes` VALUES ('244', '5', 'vh', '109', '90', '99', '199', '259');
INSERT INTO `equip_attributes` VALUES ('245', '5', 'high', '112', '100', '109', '55', '71');
INSERT INTO `equip_attributes` VALUES ('246', '5', 'high', '109', '100', '109', '210', '273');
INSERT INTO `equip_attributes` VALUES ('247', '5', 'vh', '112', '100', '109', '57', '75');
INSERT INTO `equip_attributes` VALUES ('248', '5', 'vh', '109', '100', '109', '220', '286');
INSERT INTO `equip_attributes` VALUES ('249', '6', 'general', '112', '0', '9', '3', '5');
INSERT INTO `equip_attributes` VALUES ('250', '6', 'general', '105', '0', '9', '5', '7');
INSERT INTO `equip_attributes` VALUES ('251', '6', 'high', '112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('252', '6', 'high', '105', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('253', '6', 'vh', '112', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('254', '6', 'vh', '105', '0', '9', '5', '6');
INSERT INTO `equip_attributes` VALUES ('255', '6', 'general', '112', '10', '19', '6', '10');
INSERT INTO `equip_attributes` VALUES ('256', '6', 'general', '105', '10', '19', '9', '12');
INSERT INTO `equip_attributes` VALUES ('257', '6', 'high', '112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('258', '6', 'high', '105', '10', '19', '8', '10');
INSERT INTO `equip_attributes` VALUES ('259', '6', 'vh', '112', '10', '19', '10', '13');
INSERT INTO `equip_attributes` VALUES ('260', '6', 'vh', '105', '10', '19', '8', '10');
INSERT INTO `equip_attributes` VALUES ('261', '6', 'general', '112', '20', '29', '10', '17');
INSERT INTO `equip_attributes` VALUES ('262', '6', 'general', '105', '20', '29', '13', '17');
INSERT INTO `equip_attributes` VALUES ('263', '6', 'high', '112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('264', '6', 'high', '105', '20', '29', '11', '14');
INSERT INTO `equip_attributes` VALUES ('265', '6', 'vh', '112', '20', '29', '15', '19');
INSERT INTO `equip_attributes` VALUES ('266', '6', 'vh', '105', '20', '29', '11', '14');
INSERT INTO `equip_attributes` VALUES ('267', '6', 'general', '112', '30', '39', '14', '24');
INSERT INTO `equip_attributes` VALUES ('268', '6', 'general', '105', '30', '39', '17', '22');
INSERT INTO `equip_attributes` VALUES ('269', '6', 'high', '112', '30', '39', '20', '26');
INSERT INTO `equip_attributes` VALUES ('270', '6', 'high', '105', '30', '39', '14', '18');
INSERT INTO `equip_attributes` VALUES ('271', '6', 'vh', '112', '30', '39', '21', '27');
INSERT INTO `equip_attributes` VALUES ('272', '6', 'vh', '105', '30', '39', '14', '18');
INSERT INTO `equip_attributes` VALUES ('273', '6', 'general', '112', '40', '49', '18', '31');
INSERT INTO `equip_attributes` VALUES ('274', '6', 'general', '105', '40', '49', '21', '27');
INSERT INTO `equip_attributes` VALUES ('275', '6', 'high', '112', '40', '49', '25', '32');
INSERT INTO `equip_attributes` VALUES ('276', '6', 'high', '105', '40', '49', '17', '22');
INSERT INTO `equip_attributes` VALUES ('277', '6', 'vh', '112', '40', '49', '26', '33');
INSERT INTO `equip_attributes` VALUES ('278', '6', 'vh', '105', '40', '49', '17', '22');
INSERT INTO `equip_attributes` VALUES ('279', '6', 'general', '112', '50', '59', '21', '36');
INSERT INTO `equip_attributes` VALUES ('280', '6', 'general', '105', '50', '59', '25', '33');
INSERT INTO `equip_attributes` VALUES ('281', '6', 'high', '112', '50', '59', '30', '39');
INSERT INTO `equip_attributes` VALUES ('282', '6', 'high', '105', '50', '59', '20', '26');
INSERT INTO `equip_attributes` VALUES ('283', '6', 'vh', '112', '50', '59', '31', '40');
INSERT INTO `equip_attributes` VALUES ('284', '6', 'vh', '105', '50', '59', '21', '27');
INSERT INTO `equip_attributes` VALUES ('285', '6', 'general', '112', '60', '69', '24', '41');
INSERT INTO `equip_attributes` VALUES ('286', '6', 'general', '105', '60', '69', '27', '35');
INSERT INTO `equip_attributes` VALUES ('287', '6', 'high', '112', '60', '69', '35', '45');
INSERT INTO `equip_attributes` VALUES ('288', '6', 'high', '105', '60', '69', '23', '29');
INSERT INTO `equip_attributes` VALUES ('289', '6', 'vh', '112', '60', '69', '36', '47');
INSERT INTO `equip_attributes` VALUES ('290', '6', 'vh', '105', '60', '69', '24', '31');
INSERT INTO `equip_attributes` VALUES ('291', '6', 'general', '112', '70', '79', '27', '46');
INSERT INTO `equip_attributes` VALUES ('292', '6', 'general', '105', '70', '79', '29', '38');
INSERT INTO `equip_attributes` VALUES ('293', '6', 'high', '112', '70', '79', '40', '52');
INSERT INTO `equip_attributes` VALUES ('294', '6', 'high', '105', '70', '79', '26', '33');
INSERT INTO `equip_attributes` VALUES ('295', '6', 'vh', '112', '70', '79', '42', '54');
INSERT INTO `equip_attributes` VALUES ('296', '6', 'vh', '105', '70', '79', '27', '35');
INSERT INTO `equip_attributes` VALUES ('297', '6', 'general', '112', '80', '89', '29', '49');
INSERT INTO `equip_attributes` VALUES ('298', '6', 'general', '105', '80', '89', '31', '40');
INSERT INTO `equip_attributes` VALUES ('299', '6', 'high', '112', '80', '89', '45', '58');
INSERT INTO `equip_attributes` VALUES ('300', '6', 'high', '105', '80', '89', '29', '37');
INSERT INTO `equip_attributes` VALUES ('301', '6', 'vh', '112', '80', '89', '47', '60');
INSERT INTO `equip_attributes` VALUES ('302', '6', 'vh', '105', '80', '89', '30', '39');
INSERT INTO `equip_attributes` VALUES ('303', '6', 'high', '112', '90', '99', '50', '65');
INSERT INTO `equip_attributes` VALUES ('304', '6', 'high', '105', '90', '99', '332', '41');
INSERT INTO `equip_attributes` VALUES ('305', '6', 'vh', '112', '90', '99', '52', '58');
INSERT INTO `equip_attributes` VALUES ('306', '6', 'vh', '105', '90', '99', '33', '42');
INSERT INTO `equip_attributes` VALUES ('307', '6', 'high', '112', '100', '109', '55', '71');
INSERT INTO `equip_attributes` VALUES ('308', '6', 'high', '105', '100', '109', '35', '45');
INSERT INTO `equip_attributes` VALUES ('309', '6', 'vh', '112', '100', '109', '57', '74');
INSERT INTO `equip_attributes` VALUES ('310', '6', 'vh', '105', '100', '109', '36', '46');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fight_last_result
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
  `need_experience` int(11) NOT NULL COMMENT '所需经验数',
  PRIMARY KEY (`level`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of level_info
-- ----------------------------

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
) ENGINE=MyISAM AUTO_INCREMENT=1005 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of map_list
-- ----------------------------
INSERT INTO `map_list` VALUES ('1001', '长寿郊外', '0', '0', '0');
INSERT INTO `map_list` VALUES ('1002', '五指山', '0', '0', '0');
INSERT INTO `map_list` VALUES ('1003', '天宫', '0', '0', '0');
INSERT INTO `map_list` VALUES ('1004', '地府', '0', '0', '0');

-- ----------------------------
-- Table structure for `map_monster`
-- ----------------------------
DROP TABLE IF EXISTS `map_monster`;
CREATE TABLE `map_monster` (
  `monster_id` int(11) NOT NULL AUTO_INCREMENT,
  `monster_name` varchar(200) NOT NULL,
  `map_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`monster_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2004 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of map_monster
-- ----------------------------
INSERT INTO `map_monster` VALUES ('2001', '熊', '1001');
INSERT INTO `map_monster` VALUES ('2002', '猪', '1001');
INSERT INTO `map_monster` VALUES ('2003', '鸡', '1001');

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of map_skill
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
  `login_user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '账户ID',
  `bind_type` varchar(4) NOT NULL COMMENT '绑定类型',
  `bind_value` varchar(500) NOT NULL COMMENT '绑定值',
  PRIMARY KEY (`login_user_id`)
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
  `is_used` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否被使用',
  `race_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '种族ID',
  `attribute_list` text NOT NULL COMMENT '扩展属性',
  `attribute_base_list` text NOT NULL COMMENT '基本属性信息',
  PRIMARY KEY (`user_equip_id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COMMENT='用户装备列表';

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
  `race_id` int(11) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `user_level` int(11) NOT NULL DEFAULT '0' COMMENT '等级',
  `experience` int(11) NOT NULL DEFAULT '0' COMMENT '经验',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '金钱,以分为单位',
  `ingot` int(11) NOT NULL DEFAULT '0' COMMENT '元宝数量',
  `skil_point` int(11) NOT NULL DEFAULT '0' COMMENT '技能点',
  `pack_num` int(11) NOT NULL DEFAULT '0' COMMENT '背包数量',
  `pk_num` int(11) NOT NULL DEFAULT '0' COMMENT 'PK次数',
  `friend_num` int(11) NOT NULL DEFAULT '0' COMMENT '好友数量',
  `pet_num` int(11) NOT NULL DEFAULT '0' COMMENT '人宠数量',
  `login_user_id` int(11) NOT NULL COMMENT '帐号ID',
  `area_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分区',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='用户信息';

-- ----------------------------
-- Records of user_info
-- ----------------------------
INSERT INTO `user_info` VALUES ('27', '郝晓凯', '1', '0', '0', '3750', '0', '0', '40', '0', '20', '10', '26', '1');
INSERT INTO `user_info` VALUES ('1', '反对诉讼费', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1');
INSERT INTO `user_info` VALUES ('2', 'dsfw', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1');
INSERT INTO `user_info` VALUES ('3', 'sedf', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1');

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_skill
-- ----------------------------
INSERT INTO `user_skill` VALUES ('1', '27', '1', '23', '1', '1', null);
INSERT INTO `user_skill` VALUES ('2', '27', '2', '45', '1', '', null);
INSERT INTO `user_skill` VALUES ('3', '27', '3', '13', '1', '', null);

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