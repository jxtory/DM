/*
MySQL Data Transfer
Source Host: localhost
Source Database: uc
Target Host: localhost
Target Database: uc
Date: 2018/4/24 0:14:06
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for uc_auth
-- ----------------------------
CREATE TABLE `uc_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `authlevel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for uc_logs
-- ----------------------------
CREATE TABLE `uc_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_title` varchar(255) NOT NULL,
  `log_content` varchar(255) NOT NULL,
  `log_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for uc_user
-- ----------------------------
CREATE TABLE `uc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `createdate` date DEFAULT NULL,
  `loginsum` int(11) DEFAULT NULL,
  `loginlast` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
