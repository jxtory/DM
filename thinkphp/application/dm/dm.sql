/*
MySQL Data Transfer
Source Host: localhost
Source Database: dm
Target Host: localhost
Target Database: dm
Date: 2018/4/17 22:17:53
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for dm_brand
-- ----------------------------
CREATE TABLE `dm_brand` (
  `brand` varchar(30) NOT NULL,
  PRIMARY KEY (`brand`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_components
-- ----------------------------
CREATE TABLE `dm_components` (
  `component` varchar(30) NOT NULL,
  PRIMARY KEY (`component`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_dept1
-- ----------------------------
CREATE TABLE `dm_dept1` (
  `dept1` varchar(10) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`dept1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_dept2
-- ----------------------------
CREATE TABLE `dm_dept2` (
  `dept2` varchar(10) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`dept2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_devices
-- ----------------------------
CREATE TABLE `dm_devices` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `an` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `brand` varchar(30) DEFAULT NULL,
  `model` varchar(30) DEFAULT NULL,
  `sn` varchar(30) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_devicetype
-- ----------------------------
CREATE TABLE `dm_devicetype` (
  `devicetype` varchar(30) NOT NULL,
  PRIMARY KEY (`devicetype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_history
-- ----------------------------
CREATE TABLE `dm_history` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `did` int(5) NOT NULL,
  `holder` int(5) NOT NULL,
  `grant_date` date NOT NULL,
  `return_time` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_holders
-- ----------------------------
CREATE TABLE `dm_holders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(5) NOT NULL,
  `holder` int(5) NOT NULL,
  `grant_date` date NOT NULL,
  `components` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_macaddress
-- ----------------------------
CREATE TABLE `dm_macaddress` (
  `did` int(5) NOT NULL,
  `macaddress1` varchar(20) DEFAULT NULL,
  `macaddress2` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_model
-- ----------------------------
CREATE TABLE `dm_model` (
  `model` varchar(30) NOT NULL,
  PRIMARY KEY (`model`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_personnels
-- ----------------------------
CREATE TABLE `dm_personnels` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `personnel` varchar(20) NOT NULL,
  `phoneticize` varchar(20) DEFAULT NULL,
  `dept1` varchar(20) DEFAULT NULL,
  `dept2` varchar(20) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  `sex` varchar(5) DEFAULT NULL,
  `leader` varchar(20) DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `time` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_qualityandhealth
-- ----------------------------
CREATE TABLE `dm_qualityandhealth` (
  `did` int(5) NOT NULL,
  `quality` varchar(10) DEFAULT NULL,
  `health` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dm_repair_record
-- ----------------------------
CREATE TABLE `dm_repair_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(5) NOT NULL,
  `title` varchar(30) NOT NULL,
  `record` text,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
