/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50541
Source Host           : localhost:3306
Source Database       : phalcon_crud

Target Server Type    : MYSQL
Target Server Version : 50541
File Encoding         : 65001

Date: 2015-08-10 07:02:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `type_id` int(11) unsigned NOT NULL,
  `status` varchar(50) DEFAULT 'ok',
  `price` int(5) unsigned DEFAULT NULL,
  `created` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `products-users` (`user_id`),
  KEY `status` (`status`),
  KEY `price` (`price`),
  KEY `created` (`created`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `products-users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `protucts-type` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', 'Prod1', '2', '1', 'ok', null, '444444');
INSERT INTO `products` VALUES ('2', 'Prod2', '2', '2', 'ok', null, '7867687');
INSERT INTO `products` VALUES ('4', 'Prod4', '2', '2', 'ok', null, '76768');
INSERT INTO `products` VALUES ('7', 'Money', '1', '2', 'good', '1000000', '1439170797');

-- ----------------------------
-- Table structure for types
-- ----------------------------
DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of types
-- ----------------------------
INSERT INTO `types` VALUES ('1', 'Type1');
INSERT INTO `types` VALUES ('2', 'Type2');
INSERT INTO `types` VALUES ('3', 'Type3');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `login` (`login`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'qqq@qq.qq', '$2a$08$YgfcJNSG/4iscwizps975eTqPvQQgHWifpJTw00Oz88eEI4uK8/Da', 'user');
INSERT INTO `users` VALUES ('2', 'user1', 'qqq1@qq.qq', '$2a$08$YgfcJNSG/4iscwizps975eTqPvQQgHWifpJTw00Oz88eEI4uK8/Da', 'user');
INSERT INTO `users` VALUES ('3', 'user2', 'qqq2@qq.qq', '$2a$08$YgfcJNSG/4iscwizps975eTqPvQQgHWifpJTw00Oz88eEI4uK8/Da', 'user');
INSERT INTO `users` VALUES ('6', 'zzzzz', 'zzz@zz.zz', '$2a$08$9mLduH9lGXwzCgQj.gCs9.cOjsd2Xf8Zl4J4nJFkE/SvlCjAjaASW', 'user');
