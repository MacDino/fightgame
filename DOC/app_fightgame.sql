CREATE DATABASE  IF NOT EXISTS `app_fightgame` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `app_fightgame`;
-- MySQL dump 10.13  Distrib 5.6.11, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: app_fightgame
-- ------------------------------------------------------
-- Server version	5.6.12

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
-- Table structure for table `attribute_enhance`
--

DROP TABLE IF EXISTS `attribute_enhance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attribute_enhance` (
  `user_id` int(11) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '使用时间,时间戳格式',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_enhance`
--

LOCK TABLES `attribute_enhance` WRITE;
/*!40000 ALTER TABLE `attribute_enhance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attribute_enhance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auto_fight`
--

DROP TABLE IF EXISTS `auto_fight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auto_fight` (
  `user_id` int(11) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '添加时间,时间戳格式',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auto_fight`
--

LOCK TABLES `auto_fight` WRITE;
/*!40000 ALTER TABLE `auto_fight` DISABLE KEYS */;
/*!40000 ALTER TABLE `auto_fight` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `double_harvest`
--

DROP TABLE IF EXISTS `double_harvest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `double_harvest` (
  `user_id` int(11) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '添加时间,时间戳格式',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `double_harvest`
--

LOCK TABLES `double_harvest` WRITE;
/*!40000 ALTER TABLE `double_harvest` DISABLE KEYS */;
/*!40000 ALTER TABLE `double_harvest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equip_attributes`
--

DROP TABLE IF EXISTS `equip_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equip_attributes`
--

LOCK TABLES `equip_attributes` WRITE;
/*!40000 ALTER TABLE `equip_attributes` DISABLE KEYS */;
INSERT INTO `equip_attributes` VALUES (1,1,'general',106,0,9,10,13),(2,1,'general',107,0,9,10,13),(3,1,'high',106,0,9,10,13),(4,1,'high',107,0,9,10,13),(5,1,'vh',106,0,9,20,34),(6,1,'vh',107,0,9,15,26),(7,1,'general',106,10,19,40,68),(8,1,'general',107,10,19,28,48),(9,1,'high',106,10,19,45,58),(10,1,'high',107,10,19,40,52),(11,1,'vh',106,10,19,47,60),(12,1,'vh',107,10,19,42,54),(13,1,'general',106,20,29,64,109),(14,1,'general',107,20,29,48,82),(15,1,'high',106,20,29,80,104),(16,1,'high',107,20,29,70,91),(17,1,'vh',106,20,29,84,109),(18,1,'vh',107,20,29,73,95),(19,1,'general',106,30,39,88,105),(20,1,'general',107,30,39,68,116),(21,1,'high',106,30,39,115,149),(22,1,'high',107,30,39,100,130),(23,1,'high',106,30,39,115,149),(24,1,'high',107,30,39,100,130),(25,1,'general',106,40,49,112,190),(26,1,'general',107,40,49,88,150),(27,1,'high',106,40,49,150,195),(28,1,'high',107,40,49,130,169),(29,1,'vh',106,40,49,157,204),(30,1,'vh',107,40,49,136,177),(31,1,'general',106,50,59,136,231),(32,1,'general',107,50,59,108,184),(33,1,'high',106,50,59,185,240),(34,1,'high',107,50,59,160,208),(35,1,'vh',106,50,59,194,252),(36,1,'vh',107,50,59,168,218),(37,1,'general',106,60,69,160,272),(38,1,'general',107,60,69,128,218),(39,1,'high',106,60,69,220,286),(40,1,'high',107,60,69,190,247),(41,1,'vh',106,60,69,231,300),(42,1,'vh',107,60,69,199,259),(43,1,'general',106,70,79,184,313),(44,1,'general',107,70,79,148,252),(45,1,'high',106,70,79,255,331),(46,1,'high',107,70,79,220,286),(47,1,'vh',106,70,79,267,347),(48,1,'vh',107,70,79,231,300),(49,1,'general',106,80,89,208,354),(50,1,'general',107,80,89,168,286),(51,1,'high',106,80,89,290,377),(52,1,'high',107,80,89,250,325),(53,1,'vh',106,80,89,304,395),(54,1,'vh',107,80,89,262,341),(55,1,'high',106,90,99,325,422),(56,1,'high',107,90,99,280,364),(57,1,'vh',106,90,99,341,443),(58,1,'vh',107,90,99,294,382),(59,1,'high',106,100,109,360,468),(60,1,'high',107,100,109,310,403),(61,1,'vh',106,100,109,378,491),(62,1,'vh',107,100,109,325,423),(63,2,'general',112,0,9,2,5),(64,2,'general',108,0,9,0,0),(65,2,'high',112,0,9,2,5),(66,2,'high',108,0,9,5,6),(67,2,'vh',112,0,9,5,6),(68,2,'vh',108,0,9,5,6),(69,2,'general',112,10,19,6,14),(70,2,'general',108,10,19,10,15),(71,2,'high',112,10,19,10,13),(72,2,'high',108,10,19,15,19),(73,2,'vh',112,10,19,10,13),(74,2,'vh',108,10,19,15,20),(75,2,'general',112,20,29,10,17),(76,2,'general',108,20,29,20,29),(77,2,'high',112,20,29,15,19),(78,2,'high',108,20,29,25,32),(79,2,'vh',112,20,29,15,19),(80,2,'vh',108,20,29,26,34),(81,2,'general',112,30,39,88,105),(82,2,'general',108,30,39,68,116),(83,2,'high',112,30,39,115,149),(84,2,'high',108,30,39,100,130),(85,2,'vh',112,30,39,120,156),(86,2,'vh',108,30,39,105,136),(87,2,'general',112,40,49,112,190),(88,2,'general',108,40,49,88,150),(89,2,'high',112,40,49,150,195),(90,2,'high',108,40,49,130,169),(91,2,'vh',112,40,49,157,204),(92,2,'vh',108,40,49,136,177),(93,2,'general',112,50,59,136,231),(94,2,'general',108,50,59,108,184),(95,2,'high',112,50,59,185,240),(96,2,'high',108,50,59,160,208),(97,2,'vh',112,50,59,194,252),(98,2,'vh',108,50,59,168,218),(99,2,'general',112,60,69,160,272),(100,2,'general',108,60,69,128,218),(101,2,'high',112,60,69,220,286),(102,2,'high',108,60,69,190,247),(103,2,'vh',112,60,69,231,300),(104,2,'vh',108,60,69,199,259),(105,2,'general',112,70,79,184,313),(106,2,'general',108,70,79,148,252),(107,2,'high',112,70,79,255,331),(108,2,'high',108,70,79,220,286),(109,2,'vh',112,70,79,267,347),(110,2,'vh',108,70,79,231,300),(111,2,'general',112,80,89,208,354),(112,2,'general',108,80,89,168,286),(113,2,'high',112,80,89,290,377),(114,2,'high',108,80,89,250,325),(115,2,'vh',112,80,89,304,395),(116,2,'vh',108,80,89,262,341),(117,2,'high',112,90,99,325,422),(118,2,'high',108,90,99,280,364),(119,2,'vh',112,90,99,341,443),(120,2,'vh',108,90,99,294,382),(121,2,'high',112,100,109,360,468),(122,2,'high',108,100,109,310,403),(123,2,'vh',112,100,109,378,491),(124,2,'vh',108,100,109,325,423),(125,3,'general',110,0,9,5,6),(126,3,'high',110,0,9,5,6),(127,3,'vh',110,0,9,5,8),(128,3,'general',110,10,19,12,20),(129,3,'high',110,10,19,17,22),(130,3,'vh',110,10,19,17,23),(131,3,'general',110,20,29,19,32),(132,3,'high',110,20,29,29,37),(133,3,'vh',110,20,29,30,38),(134,3,'general',110,30,39,27,45),(135,3,'high',110,30,39,41,53),(136,3,'vh',110,30,39,43,55),(137,3,'general',110,40,49,34,57),(138,3,'high',110,40,49,53,68),(139,3,'vh',110,40,49,55,71),(140,3,'general',110,50,59,45,76),(141,3,'high',110,50,59,65,84),(142,3,'vh',110,50,59,68,88),(143,3,'general',110,60,69,56,95),(144,3,'high',110,60,69,77,100),(145,3,'vh',110,60,69,80,105),(146,3,'general',110,70,79,65,110),(147,3,'high',110,70,79,89,115),(148,3,'vh',110,70,79,93,120),(149,3,'general',110,80,89,77,130),(150,3,'high',110,80,89,101,131),(151,3,'vh',110,80,89,106,137),(152,3,'high',110,90,99,113,146),(153,3,'vh',110,90,99,118,153),(154,3,'high',110,100,109,125,162),(155,3,'vh',110,100,109,131,170),(156,4,'general',112,0,9,8,14),(157,4,'high',112,0,9,10,13),(158,4,'vh',112,0,9,10,13),(159,4,'general',112,10,19,20,34),(160,4,'high',112,10,19,25,32),(161,4,'vh',112,10,19,26,33),(162,4,'general',112,20,29,29,49),(163,4,'high',112,20,29,40,52),(164,4,'vh',112,20,29,42,54),(165,4,'general',112,30,39,40,68),(166,4,'high',112,30,39,55,71),(167,4,'vh',112,30,39,57,74),(168,4,'general',112,40,49,56,95),(169,4,'high',112,40,49,70,91),(170,4,'vh',112,40,49,73,95),(171,4,'general',112,50,59,64,109),(172,4,'high',112,50,59,85,110),(173,4,'vh',112,50,59,89,115),(174,4,'general',112,60,69,80,136),(175,4,'high',112,60,69,100,130),(176,4,'vh',112,60,69,105,136),(177,4,'general',112,70,79,88,150),(178,4,'high',112,70,79,115,149),(179,4,'vh',112,70,79,120,156),(180,4,'general',112,80,89,100,170),(181,4,'high',112,80,89,130,169),(182,4,'vh',112,80,89,136,177),(183,4,'high',112,90,99,145,188),(184,4,'vh',112,90,99,152,197),(185,4,'high',112,100,109,160,208),(186,4,'vh',112,100,109,168,218),(187,5,'general',112,0,9,4,6),(188,5,'general',109,0,9,0,0),(189,5,'high',112,0,9,5,6),(190,5,'high',109,0,9,10,13),(191,5,'vh',112,0,9,5,6),(192,5,'vh',109,0,9,10,13),(193,5,'general',112,10,19,8,13),(194,5,'general',109,10,19,20,34),(195,5,'high',112,10,19,10,13),(196,5,'high',109,10,19,30,39),(197,5,'vh',112,10,19,10,13),(198,5,'vh',109,10,19,31,40),(199,5,'general',112,20,29,10,17),(200,5,'general',109,20,29,40,68),(201,5,'high',112,20,29,15,19),(202,5,'high',109,20,29,50,65),(203,5,'vh',112,20,29,15,20),(204,5,'vh',109,20,29,52,68),(205,5,'general',112,30,39,14,23),(206,5,'general',109,30,39,60,102),(207,5,'high',112,30,39,20,26),(208,5,'high',109,30,39,70,91),(209,5,'vh',112,30,39,21,27),(210,5,'vh',109,30,39,73,95),(211,5,'general',112,40,49,18,30),(212,5,'general',109,40,49,80,136),(213,5,'high',112,40,49,25,32),(214,5,'high',109,40,49,90,117),(215,5,'vh',112,40,49,26,34),(216,5,'vh',109,40,49,94,122),(217,5,'general',112,50,59,22,37),(218,5,'general',109,50,59,100,170),(219,5,'high',112,50,59,30,39),(220,5,'high',109,50,59,110,143),(221,5,'vh',112,50,59,31,40),(222,5,'vh',109,50,59,115,150),(223,5,'general',112,60,69,26,44),(224,5,'general',109,60,69,120,204),(225,5,'high',112,60,69,35,45),(226,5,'high',109,60,69,130,169),(227,5,'vh',112,60,69,36,47),(228,5,'vh',109,60,69,136,177),(229,5,'general',112,70,79,30,51),(230,5,'general',109,70,79,140,238),(231,5,'high',112,70,79,40,52),(232,5,'high',109,70,79,150,195),(233,5,'vh',112,70,79,42,54),(234,5,'vh',109,70,79,157,204),(235,5,'general',112,80,89,34,57),(236,5,'general',109,80,89,160,272),(237,5,'high',112,80,89,45,58),(238,5,'high',109,80,89,170,221),(239,5,'vh',112,80,89,47,61),(240,5,'vh',109,80,89,178,232),(241,5,'high',112,90,99,50,65),(242,5,'high',109,90,99,190,247),(243,5,'vh',112,90,99,52,68),(244,5,'vh',109,90,99,199,259),(245,5,'high',112,100,109,55,71),(246,5,'high',109,100,109,210,273),(247,5,'vh',112,100,109,57,75),(248,5,'vh',109,100,109,220,286),(249,6,'general',112,0,9,3,5),(250,6,'general',105,0,9,5,7),(251,6,'high',112,0,9,5,6),(252,6,'high',105,0,9,5,6),(253,6,'vh',112,0,9,5,6),(254,6,'vh',105,0,9,5,6),(255,6,'general',112,10,19,6,10),(256,6,'general',105,10,19,9,12),(257,6,'high',112,10,19,10,13),(258,6,'high',105,10,19,8,10),(259,6,'vh',112,10,19,10,13),(260,6,'vh',105,10,19,8,10),(261,6,'general',112,20,29,10,17),(262,6,'general',105,20,29,13,17),(263,6,'high',112,20,29,15,19),(264,6,'high',105,20,29,11,14),(265,6,'vh',112,20,29,15,19),(266,6,'vh',105,20,29,11,14),(267,6,'general',112,30,39,14,24),(268,6,'general',105,30,39,17,22),(269,6,'high',112,30,39,20,26),(270,6,'high',105,30,39,14,18),(271,6,'vh',112,30,39,21,27),(272,6,'vh',105,30,39,14,18),(273,6,'general',112,40,49,18,31),(274,6,'general',105,40,49,21,27),(275,6,'high',112,40,49,25,32),(276,6,'high',105,40,49,17,22),(277,6,'vh',112,40,49,26,33),(278,6,'vh',105,40,49,17,22),(279,6,'general',112,50,59,21,36),(280,6,'general',105,50,59,25,33),(281,6,'high',112,50,59,30,39),(282,6,'high',105,50,59,20,26),(283,6,'vh',112,50,59,31,40),(284,6,'vh',105,50,59,21,27),(285,6,'general',112,60,69,24,41),(286,6,'general',105,60,69,27,35),(287,6,'high',112,60,69,35,45),(288,6,'high',105,60,69,23,29),(289,6,'vh',112,60,69,36,47),(290,6,'vh',105,60,69,24,31),(291,6,'general',112,70,79,27,46),(292,6,'general',105,70,79,29,38),(293,6,'high',112,70,79,40,52),(294,6,'high',105,70,79,26,33),(295,6,'vh',112,70,79,42,54),(296,6,'vh',105,70,79,27,35),(297,6,'general',112,80,89,29,49),(298,6,'general',105,80,89,31,40),(299,6,'high',112,80,89,45,58),(300,6,'high',105,80,89,29,37),(301,6,'vh',112,80,89,47,60),(302,6,'vh',105,80,89,30,39),(303,6,'high',112,90,99,50,65),(304,6,'high',105,90,99,332,41),(305,6,'vh',112,90,99,52,58),(306,6,'vh',105,90,99,33,42),(307,6,'high',112,100,109,55,71),(308,6,'high',105,100,109,35,45),(309,6,'vh',112,100,109,57,74),(310,6,'vh',105,100,109,36,46);
/*!40000 ALTER TABLE `equip_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend_info`
--

DROP TABLE IF EXISTS `friend_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend_info` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `channel` enum('sina','weixin','lbs','game') DEFAULT 'game' COMMENT '添加来源',
  `is_pass` enum('2','1') DEFAULT '1' COMMENT '1未通过2通过',
  PRIMARY KEY (`user_id`,`friend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_info`
--

LOCK TABLES `friend_info` WRITE;
/*!40000 ALTER TABLE `friend_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `friend_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `level_allow_skill_num`
--

DROP TABLE IF EXISTS `level_allow_skill_num`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level_allow_skill_num` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL COMMENT '等级',
  `allow_gj` int(11) NOT NULL COMMENT '允许使用攻击技能数量',
  `allow_fy` int(11) NOT NULL COMMENT '允许使用防御技能数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level_allow_skill_num`
--

LOCK TABLES `level_allow_skill_num` WRITE;
/*!40000 ALTER TABLE `level_allow_skill_num` DISABLE KEYS */;
/*!40000 ALTER TABLE `level_allow_skill_num` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `level_info`
--

DROP TABLE IF EXISTS `level_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level_info` (
  `level` int(11) NOT NULL AUTO_INCREMENT COMMENT '等级',
  `need_experience` int(11) NOT NULL COMMENT '所需经验数',
  PRIMARY KEY (`level`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level_info`
--

LOCK TABLES `level_info` WRITE;
/*!40000 ALTER TABLE `level_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `level_info` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level_skill_money`
--

LOCK TABLES `level_skill_money` WRITE;
/*!40000 ALTER TABLE `level_skill_money` DISABLE KEYS */;
/*!40000 ALTER TABLE `level_skill_money` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `level_skill_point`
--

DROP TABLE IF EXISTS `level_skill_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level_skill_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL COMMENT '等级',
  `point_num` int(11) NOT NULL COMMENT '技能点数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level_skill_point`
--

LOCK TABLES `level_skill_point` WRITE;
/*!40000 ALTER TABLE `level_skill_point` DISABLE KEYS */;
/*!40000 ALTER TABLE `level_skill_point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map_list`
--

DROP TABLE IF EXISTS `map_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map_list` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地图ID',
  `map_name` varchar(200) NOT NULL COMMENT '地图名称',
  `map_race_id` int(11) NOT NULL COMMENT '地图种族ID(race_id)',
  `start_level` int(11) NOT NULL COMMENT '开始等级',
  `end_level` int(11) NOT NULL COMMENT '结束等级',
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `map_list` VALUES ('1', '花果山', '1', '0', '5'), ('2', '长寿郊外', '3', '6', '10'), ('3', '七十二洞', '2', '11', '15'), ('4', '东海龙宫', '3', '16', '20'), ('5', '天宫马厩', '2', '21', '25'), ('6', '天宫', '2', '26', '30'), ('7', '地府', '3', '31', '35'), ('8', '五行山', '2', '36', '40'), ('9', '黑风洞', '3', '41', '45'), ('10', '云栈洞', '2', '46', '50'), ('11', '流沙河', '1', '51', '60'), ('12', '五庄观', '1', '61', '65'), ('13', '火云洞', '3', '66', '70'), ('14', '白骨洞', '3', '71', '75'), ('15', '莲花洞', '2', '76', '80'), ('16', '乌鸡国', '1', '81', '85'), ('17', '黄金塔', '3', '86', '90'), ('18', '平顶山', '2', '91', '95'), ('19', '琵琶洞', '2', '96', '100');

--
-- Table structure for table `map_monster`
--

-- ----------------------------
--  Table structure for `map_monster`
-- ----------------------------
DROP TABLE IF EXISTS `map_monster`;
CREATE TABLE `map_monster` (
  `monster_id` int(11) NOT NULL AUTO_INCREMENT,
  `monster_name` varchar(200) NOT NULL,
  `map_id` int(11) DEFAULT NULL,
  `race_id` int(11) NOT NULL COMMENT '种族id',
  PRIMARY KEY (`monster_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `map_monster`
-- ----------------------------
INSERT INTO `map_monster` VALUES ('1', '狼', '1', '1'), ('2', '猴', '1', '1'), ('3', '虎', '1', '1'), ('4', '豹', '1', '1'), ('5', '鹿', '1', '1'), ('6', '小妖', '2', '3'), ('7', '狼精', '2', '3'), ('8', '妖道', '2', '3'), ('9', '恶兄长', '2', '3'), ('10', '懒师弟', '2', '3'), ('11', '山牛', '3', '2'), ('12', '神獒', '3', '2'), ('13', '羚羊', '3', '2'), ('14', '狻猊', '3', '2'), ('15', '青兕', '3', '2'), ('16', '虾兵', '4', '3'), ('17', '蟹将', '4', '3'), ('18', '夜叉', '4', '3'), ('19', '龟丞相', '4', '3'), ('20', '鳖帅', '4', '3'), ('21', '天兵', '5', '2'), ('22', '天将', '5', '2'), ('23', '仙女', '5', '2'), ('24', '善财童子', '5', '2'), ('25', '巨灵神', '5', '2'), ('26', '天兵', '6', '2'), ('27', '天将', '6', '2'), ('28', '仙女', '6', '2'), ('29', '善财童子', '6', '2'), ('30', '巨灵神', '6', '2'), ('31', '牛头', '7', '3'), ('32', '马面', '7', '3'), ('33', '女鬼', '7', '3'), ('34', '黑无常', '7', '3'), ('35', '白无常', '7', '3'), ('36', '道童', '8', '2'), ('37', '丹炉', '8', '2'), ('38', '火神', '8', '2'), ('39', '机关怪', '8', '2'), ('40', '石头人', '8', '2'), ('41', '白熊精', '9', '3'), ('42', '黑熊精', '9', '3'), ('43', '九头蛇', '9', '3'), ('44', '六尾狐', '9', '3'), ('45', '狐妖', '9', '3'), ('46', '猪妖', '10', '2'), ('47', '骨角精', '10', '2'), ('48', '炎魔怪', '11', '1'), ('49', '猪刚烈', '11', '1'), ('50', '岩怪', '11', '1'), ('51', '五庄道姑', '12', '1'), ('52', '明月', '12', '1'), ('53', '清风', '12', '1'), ('54', '土地', '12', '1'), ('55', '五庄使者', '12', '1'), ('56', '狮头兽', '13', '3'), ('57', '烈火虎', '13', '3'), ('58', '不死鸟', '13', '3'), ('59', '火蟾蜍', '13', '3'), ('60', '赤烛魔', '13', '3'), ('61', '僵尸', '14', '3'), ('62', '劈头僵尸', '14', '3'), ('63', '碎骨骷髅', '14', '3'), ('64', '破骨僵尸', '14', '3'), ('65', '白骨斧手', '14', '3'), ('66', '狐阿七', '15', '2'), ('67', '狐阿大', '15', '2'), ('68', '棕熊精', '15', '2'), ('69', '莲花精', '15', '2'), ('70', '白鹿精', '15', '2'), ('71', '狼头小妖', '16', '1'), ('72', '竹妖', '16', '1'), ('73', '面具魔', '16', '1'), ('74', '雪鹰', '16', '1'), ('75', '猫少女', '16', '1'), ('76', '狼男', '17', '1'), ('77', '狼女', '17', '1'), ('78', '狼婆', '17', '1'), ('79', '狼公', '17', '1'), ('80', '冰狼', '17', '1'), ('81', '精细鬼', '18', '2'), ('82', '伶俐虫', '18', '2'), ('83', '巴山虎', '18', '2'), ('84', '倚海龙', '18', '2'), ('85', '花裙黑狐', '18', '2'), ('86', '傲剑天狼', '19', '2'), ('87', '琵琶夫人', '19', '2'), ('88', '上古蜈蚣', '19', '2'), ('89', '蛇女帝', '19', '2'), ('90', '蜂女王', '19', '2');

--
-- Table structure for table `map_skill`
--

DROP TABLE IF EXISTS `map_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map_skill` (
  `map_skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `skill_type` varchar(64) NOT NULL COMMENT '技能类型：attack,defence,passive',
  `config_type` varchar(64) NOT NULL COMMENT '配置类型:all, boss_must_have, suffix_must_have, boss_min_count, suffix_min_count',
  PRIMARY KEY (`map_skill_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map_skill`
--

LOCK TABLES `map_skill` WRITE;
/*!40000 ALTER TABLE `map_skill` DISABLE KEYS */;
/*!40000 ALTER TABLE `map_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_info`
--

DROP TABLE IF EXISTS `property_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_info` (
  `user_id` int(11) NOT NULL,
  `property_id` tinyint(1) NOT NULL COMMENT '道具ID',
  `property_num` int(3) DEFAULT '0' COMMENT '道具数量',
  `last_time` int(11) DEFAULT NULL COMMENT '最后购买时间',
  PRIMARY KEY (`user_id`,`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_info`
--

LOCK TABLES `property_info` WRITE;
/*!40000 ALTER TABLE `property_info` DISABLE KEYS */;
INSERT INTO `property_info` VALUES (27,1,0,NULL),(27,2,0,NULL),(27,3,0,NULL),(28,1,0,NULL),(28,2,0,NULL),(28,3,0,NULL),(29,1,0,NULL),(29,2,0,NULL),(29,3,0,NULL),(30,1,0,NULL),(30,2,0,NULL),(30,3,0,NULL),(31,1,0,NULL),(31,2,0,NULL),(31,3,0,NULL),(32,1,0,NULL),(32,2,0,NULL),(32,3,0,NULL),(33,1,0,NULL),(33,2,0,NULL),(33,3,0,NULL),(34,1,0,NULL),(34,2,0,NULL),(34,3,0,NULL),(35,1,0,NULL),(35,2,0,NULL),(35,3,0,NULL),(36,1,0,NULL),(36,2,0,NULL),(36,3,0,NULL),(37,1,0,NULL),(37,2,0,NULL),(37,3,0,NULL),(38,1,0,NULL),(38,2,0,NULL),(38,3,0,NULL),(39,1,0,NULL),(39,2,0,NULL),(39,3,0,NULL);
/*!40000 ALTER TABLE `property_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_bind`
--

DROP TABLE IF EXISTS `user_bind`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_bind` (
  `login_user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '账户ID',
  `bind_type` varchar(4) NOT NULL COMMENT '绑定类型',
  `bind_value` varchar(500) NOT NULL COMMENT '绑定值',
  PRIMARY KEY (`login_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='用户绑定表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_bind`
--

LOCK TABLES `user_bind` WRITE;
/*!40000 ALTER TABLE `user_bind` DISABLE KEYS */;
INSERT INTO `user_bind` VALUES (26,'mac','EC:6C:9F:0E:A4:36');
/*!40000 ALTER TABLE `user_bind` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_equip`
--

DROP TABLE IF EXISTS `user_equip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 COMMENT='用户装备列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_equip`
--

LOCK TABLES `user_equip` WRITE;
/*!40000 ALTER TABLE `user_equip` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_equip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (27,'郝晓凯',1,0,0,0,0,0,40,0,20,10,26,1);
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Dumping data for table `user_skill`
--

LOCK TABLES `user_skill` WRITE;
/*!40000 ALTER TABLE `user_skill` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `version_list`
--

DROP TABLE IF EXISTS `version_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `version_list` (
  `version_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_key` varchar(200) NOT NULL,
  `version_value` int(11) NOT NULL,
  `parent_version_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  PRIMARY KEY (`version_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `version_list`
--

LOCK TABLES `version_list` WRITE;
/*!40000 ALTER TABLE `version_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `version_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-08-29 17:48:25
--
-- Table structure for table `user_skill`
--

DROP TABLE IF EXISTS `iap_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iap_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `iap_product_id` varchar(100) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_desc` varchar(300) NOT NULL,
  `price` decimal(5,2),
  `status` tinyint(3) not null default 1,
  PRIMARY KEY (`product_id`),
  UNIQUE(iap_product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `iap_product` WRITE;
/*!40000 ALTER TABLE `iap_product` DISABLE KEYS */;
INSERT INTO iap_product (iap_product_id,product_name,product_desc,price) VALUES ('com.fightgame.60','6元包套餐','6元含有60个元宝',6.00);
INSERT INTO iap_product (iap_product_id,product_name,product_desc,price) VALUES ('com.fightgame.300','30元包套餐','30元含有300个元宝',30.00);
/*!40000 ALTER TABLE `iap_product` ENABLE KEYS */;
UNLOCK TABLES;



DROP TABLE IF EXISTS `iap_purchase_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iap_purchase_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_receipt` varchar(300) NOT NULL,
  `verify_status` tinyint(3) not null default -1,
  `ctime` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
