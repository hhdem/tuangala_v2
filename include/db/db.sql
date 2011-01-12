-- MySQL dump 10.11
--
-- Host: localhost    Database: zuitu_cv
-- ------------------------------------------------------
-- Server version	5.0.91

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
-- Table structure for table `ask`
--

DROP TABLE IF EXISTS `ask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ask` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `partner_id` int(10) unsigned NOT NULL default '0',
  `team_id` int(10) unsigned NOT NULL default '0',
  `city_id` int(10) unsigned NOT NULL default '0',
  `type` enum('ask','transfer') NOT NULL default 'ask',
  `content` text,
  `comment` text,
  `create_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `card`
--

DROP TABLE IF EXISTS `card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `card` (
  `id` varchar(16) NOT NULL,
  `code` varchar(16) default NULL,
  `partner_id` int(10) unsigned NOT NULL default '0',
  `team_id` int(10) unsigned NOT NULL default '0',
  `order_id` int(10) unsigned NOT NULL default '0',
  `credit` int(10) unsigned NOT NULL default '0',
  `consume` enum('Y','N') NOT NULL default 'N',
  `ip` varchar(16) default NULL,
  `begin_time` int(10) unsigned NOT NULL default '0',
  `end_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `zone` varchar(16) default NULL,
  `czone` varchar(32) default NULL,
  `name` varchar(32) default NULL,
  `ename` varchar(16) default NULL,
  `letter` char(1) default NULL,
  `sort_order` int(11) NOT NULL default '0',
  `display` enum('Y','N') NOT NULL default 'Y',
  `parent_id`  int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNQ_zne` (`zone`,`name`,`ename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon`
--

DROP TABLE IF EXISTS `coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon` (
  `id` varchar(12) NOT NULL default '',
  `user_id` int(10) unsigned NOT NULL default '0',
  `partner_id` int(10) unsigned NOT NULL default '0',
  `team_id` int(10) unsigned NOT NULL default '0',
  `order_id` int(10) unsigned NOT NULL default '0',
  `type` enum('consume','credit') NOT NULL default 'consume',
  `credit` int(10) unsigned NOT NULL default '0',
  `secret` varchar(10) default NULL,
  `consume` enum('Y','N') NOT NULL default 'N',
  `ip` varchar(16) default NULL,
  `sms` int(10) unsigned NOT NULL default '0',
  `expire_time` int(10) unsigned NOT NULL default '0',
  `consume_time` int(10) unsigned NOT NULL default '0',
  `create_time` int(10) unsigned NOT NULL default '0',
  `sms_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `city_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `category` enum('suggest','seller') NOT NULL default 'suggest',
  `title` varchar(128) default NULL,
  `contact` varchar(255) default NULL,
  `content` text,
  `create_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `flow`
--

DROP TABLE IF EXISTS `flow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flow` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `admin_id` int(10) unsigned NOT NULL default '0',
  `detail_id` varchar(32) default NULL,
  `detail` varchar(255) default NULL,
  `direction` enum('income','expense') NOT NULL default 'income',
  `money` double(10,2) NOT NULL default '0.00',
  `action` varchar(16) NOT NULL default 'buy',
  `create_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friendlink`
--

DROP TABLE IF EXISTS `friendlink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendlink` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(32) default NULL,
  `url` varchar(255) default NULL,
  `logo` varchar(255) default NULL,
  `sort_order` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invite`
--

DROP TABLE IF EXISTS `invite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invite` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `admin_id` int(10) unsigned NOT NULL default '0',
  `user_ip` varchar(16) default NULL,
  `other_user_id` int(10) unsigned NOT NULL default '0',
  `other_user_ip` varchar(16) default NULL,
  `team_id` int(10) unsigned NOT NULL default '0',
  `pay` enum('Y','N','C') NOT NULL default 'N',
  `credit` int(10) unsigned NOT NULL default '0',
  `buy_time` int(10) unsigned NOT NULL default '0',
  `create_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNQ_uo` (`user_id`,`other_user_id`),
  UNIQUE KEY `UNQ_o` (`other_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `pay_id` varchar(32) default NULL,
  `service` varchar(16) NOT NULL default 'alipay',
  `user_id` int(10) unsigned NOT NULL default '0',
  `admin_id` int(10) unsigned NOT NULL default '0',
  `team_id` int(10) unsigned NOT NULL default '0',
  `city_id` int(10) unsigned NOT NULL default '0',
  `card_id` varchar(16) default NULL,
  `state` enum('unpay','pay') NOT NULL default 'unpay',
  `quantity` int(10) unsigned NOT NULL default '1',
  `realname` varchar(32) default NULL,
  `mobile` varchar(128) default NULL,
  `zipcode` char(6) default NULL,
  `address` varchar(128) default NULL,
  `express` enum('Y','N') NOT NULL default 'Y',
  `express_xx` varchar(128) default NULL,
  `express_id` int(10) unsigned NOT NULL default '0',
  `express_no` varchar(32) default NULL,
  `price` double(10,2) NOT NULL default '0.00',
  `money` double(10,2) NOT NULL default '0.00',
  `origin` double(10,2) NOT NULL default '0.00',
  `credit` double(10,2) NOT NULL default '0.00',
  `card` double(10,2) NOT NULL default '0.00',
  `fare` double(10,2) NOT NULL default '0.00',
  `condbuy` varchar(128) default NULL,
  `remark` text,
  `create_time` int(10) unsigned NOT NULL default '0',
  `pay_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNQ_p` (`pay_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` varchar(16) NOT NULL,
  `value` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partner`
--

DROP TABLE IF EXISTS `partner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(32) default NULL,
  `password` varchar(32) default NULL,
  `title` varchar(128) default NULL,
  `group_id` int(10) unsigned NOT NULL default '0',
  `homepage` varchar(128) default NULL,
  `city_id` int(10) unsigned NOT NULL default '0',
  `bank_name` varchar(128) default NULL,
  `bank_no` varchar(128) default NULL,
  `bank_user` varchar(128) default NULL,
  `location` text NOT NULL,
  `contact` varchar(32) default NULL,
  `image` varchar(128) default NULL,
  `image1` varchar(128) default NULL,
  `image2` varchar(128) default NULL,
  `phone` varchar(18) default NULL,
  `address` varchar(128) default NULL,
  `other` text,
  `mobile` varchar(12) default NULL,
  `open` enum('Y','N') NOT NULL default 'N',
  `display` enum('Y','N') NOT NULL default 'N',
  `enable` enum('Y','N') NOT NULL default 'Y',
  `head` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `create_time` int(10) unsigned NOT NULL default '0',
  `longlat` varchar(40) default NULL, 
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNQ_ct` (`city_id`,`title`),
  UNIQUE KEY `UNQ_u` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pay`
--

DROP TABLE IF EXISTS `pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay` (
  `id` varchar(32) NOT NULL default '',
  `order_id` int(10) unsigned NOT NULL default '0',
  `bank` varchar(32) default NULL,
  `money` double(10,2) default NULL,
  `currency` enum('CNY','USD') NOT NULL default 'CNY',
  `service` varchar(16) NOT NULL default 'alipay',
  `create_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNQ_o` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `smssubscribe`
--

DROP TABLE IF EXISTS `smssubscribe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `smssubscribe` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `mobile` varchar(18) default NULL,
  `city_id` int(10) unsigned NOT NULL default '0',
  `secret` char(6) default NULL,
  `enable` enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNQ_e` (`mobile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subscribe`
--

DROP TABLE IF EXISTS `subscribe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscribe` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `email` varchar(128) default NULL,
  `city_id` int(10) unsigned NOT NULL default '0',
  `secret` varchar(32) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNQ_e` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system`
--

DROP TABLE IF EXISTS `system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system` (
  `id` enum('1') NOT NULL default '1',
  `value` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(128) default NULL,
  `summary` text,
  `city_id` int(10) unsigned NOT NULL default '0',
  `group_id` int(10) unsigned NOT NULL default '0',
  `partner_id` int(10) unsigned NOT NULL default '0',
  `system` enum('Y','N') NOT NULL default 'Y',
  `team_price` double(10,2) NOT NULL default '0.00',
  `market_price` double(10,2) NOT NULL default '0.00',
  `schedule_price` double(10,2) NULL default '0.00',
  `product` varchar(128) default NULL,
  `condbuy` varchar(255) default NULL,
  `per_number` int(10) unsigned NOT NULL default '1',
  `min_number` int(10) unsigned NOT NULL default '1',
  `max_number` int(10) unsigned NOT NULL default '0',
  `now_number` int(10) unsigned NOT NULL default '0',
  `pre_number` int(10) unsigned NOT NULL default '0',
  `image` varchar(128) default NULL,
  `image1` varchar(128) default NULL,
  `image2` varchar(128) default NULL,
  `flv` varchar(128) default NULL,
  `mobile` varchar(16) default NULL,
  `credit` int(10) unsigned NOT NULL default '0',
  `card` int(10) unsigned NOT NULL default '0',
  `fare` int(10) unsigned NOT NULL default '0',
  `farefree` int(11) NOT NULL default '0',
  `bonus` int(11) NOT NULL default '0',
  `address` varchar(128) default NULL,
  `detail` text,
  `systemreview` text,
  `userreview` text,
  `notice` text,
  `express` text,
  `delivery` enum('coupon','express','pickup') NOT NULL default 'coupon',
  `state` enum('none','success','soldout','failure','refund') NOT NULL default 'none',
  `conduser` enum('Y','N') NOT NULL default 'Y',
  `buyonce` enum('Y','N') NOT NULL default 'Y',
  `team_type` varchar(20) default 'normal',
  `sort_order` int(11) NOT NULL default '0',
  `expire_time` int(10) unsigned NOT NULL default '0',
  `begin_time` int(10) unsigned NOT NULL default '0',
  `end_time` int(10) unsigned NOT NULL default '0',
  `reach_time` int(10) unsigned NOT NULL default '0',
  `close_time` int(10) unsigned NOT NULL default '0',
  `lastbuy_time` int(10) unsigned NOT NULL default '0',
  `audit` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(128) default NULL,
  `team_id` int(10) unsigned NOT NULL default '0',
  `city_id` int(10) unsigned NOT NULL default '0',
  `public_id` int(10) unsigned NOT NULL default '0',
  `content` text,
  `head` int(10) unsigned NOT NULL default '0',
  `reply_number` int(10) unsigned NOT NULL default '0',
  `view_number` int(10) unsigned NOT NULL default '0',
  `last_user_id` int(10) unsigned NOT NULL default '0',
  `last_time` int(10) unsigned NOT NULL default '0',
  `create_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `email` varchar(128) default NULL,
  `username` varchar(32) default NULL,
  `realname` varchar(32) default NULL,
  `password` varchar(32) default NULL,
  `avatar` varchar(128) default NULL,
  `gender` enum('M','F') NOT NULL default 'M',
  `newbie` enum('Y','N') NOT NULL default 'Y',
  `mobile` varchar(16) default NULL,
  `qq` varchar(16) default NULL,
  `money` double(10,2) NOT NULL default '0.00',
  `score` int(11) NOT NULL default '0',
  `zipcode` char(6) default NULL,
  `address` varchar(255) default NULL,
  `city_id` int(10) unsigned NOT NULL default '0',
  `enable` enum('Y','N') NOT NULL default 'Y',
  `manager` enum('Y','N') NOT NULL default 'N',
  `secret` varchar(32) default NULL,
  `recode` varchar(32) default NULL,
  `sns` varchar(32) default NULL,
  `ip` varchar(16) default NULL,
  `login_time` int(10) unsigned NOT NULL default '0',
  `create_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNQ_name` (`username`),
  UNIQUE KEY `UNQ_e` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vote_feedback`
--

DROP TABLE IF EXISTS `vote_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_feedback` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(32) default NULL,
  `user_id` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `addtime` char(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vote_feedback_input`
--

DROP TABLE IF EXISTS `vote_feedback_input`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_feedback_input` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `feedback_id` bigint(20) unsigned NOT NULL,
  `options_id` mediumint(8) unsigned NOT NULL,
  `value` varchar(256) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vote_feedback_question`
--

DROP TABLE IF EXISTS `vote_feedback_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_feedback_question` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `feedback_id` bigint(20) unsigned NOT NULL,
  `question_id` mediumint(8) unsigned NOT NULL,
  `options_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vote_options`
--

DROP TABLE IF EXISTS `vote_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_options` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `question_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  `is_br` char(1) NOT NULL default '0',
  `is_input` char(1) NOT NULL default '0',
  `is_show` char(1) NOT NULL default '1',
  `order` mediumint(8) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vote_question`
--

DROP TABLE IF EXISTS `vote_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_question` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL default 'radio',
  `is_show` char(1) NOT NULL default '1',
  `addtime` char(10) NOT NULL,
  `order` mediumint(8) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
--
--
DROP TABLE IF EXISTS `goods`;
CREATE TABLE  `goods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `image` varchar(128) NOT NULL,
  `score` int(10) unsigned NOT NULL DEFAULT '0',
  `consume` int(10) unsigned NOT NULL DEFAULT '0',
  `display` enum('Y','N') NOT NULL DEFAULT 'N',
  `enable` enum('Y','N') NOT NULL DEFAULT 'N',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `credit`;
CREATE TABLE  `credit` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0',
  `score` int(10) NOT NULL DEFAULT '0',
  `action` varchar(100) NOT NULL,
  `detail_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vote_question`
--

DROP TABLE IF EXISTS `vote_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_question` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL default 'radio',
  `is_show` char(1) NOT NULL default '1',
  `addtime` char(10) NOT NULL,
  `order` mediumint(8) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `partner_pay`;
CREATE TABLE  `partner_pay` (
  `id` int(10) unsigned NOT NULL,
  `alipaymid` varchar(120) DEFAULT NULL,
  `alipaysec` varchar(120) DEFAULT NULL,
  `alipayacc` varchar(120) DEFAULT NULL,
  `alipayitbpay` varchar(120) DEFAULT NULL,
  `tenpaymid` varchar(120) DEFAULT NULL,
  `tenpaysec` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `partner_drawmoney`;
CREATE TABLE  `partner_drawmoney` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL,
  `currentmoney` double(10,2) NOT NULL default '0.00',
  `drawmoney` double(10,2) NOT NULL default '0.00',
  `drawdatetime` int(10) unsigned NOT NULL default '0',
  `state` enum('draw','success','drawing','failure') NOT NULL default 'draw',
  `summary` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE  `user_address` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `post` varchar(6) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `mobile` varchar(15) NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-08-20 10:16:09
