/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : jason_shop

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-06-05 18:42:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for shop_address
-- ----------------------------
DROP TABLE IF EXISTS `shop_address`;
CREATE TABLE `shop_address` (
  `addressid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) NOT NULL DEFAULT '',
  `lastname` varchar(32) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `address` text,
  `postcode` char(6) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `telephone` varchar(20) NOT NULL DEFAULT '',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`addressid`),
  KEY `shop_address_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_address
-- ----------------------------

-- ----------------------------
-- Table structure for shop_admin
-- ----------------------------
DROP TABLE IF EXISTS `shop_admin`;
CREATE TABLE `shop_admin` (
  `adminid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `adminuser` varchar(32) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `adminpass` char(64) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `adminemail` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员电子邮箱',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `loginip` bigint(20) NOT NULL DEFAULT '0' COMMENT '登录IP',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`adminid`),
  UNIQUE KEY `shop_admin_adminuser_adminpass` (`adminuser`,`adminpass`),
  UNIQUE KEY `shop_admin_adminuser_adminemail` (`adminuser`,`adminemail`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_admin
-- ----------------------------
INSERT INTO `shop_admin` VALUES ('1', 'admin', '202cb962ac59075b964b07152d234b70', 'shop@imooc.com', '1559696566', '2130706433', '1559555435');
INSERT INTO `shop_admin` VALUES ('2', 'superadmin', '$2y$13$LlgZgKjTz0To6zuApt49m.LyEYkvbvgcNuXxEKAKvAtwXFYLpthRy', 'superadmin@163.com', '0', '0', '0');

-- ----------------------------
-- Table structure for shop_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `shop_auth_assignment`;
CREATE TABLE `shop_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色名称、权限',
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户id',
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `shop_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `shop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户拥有的角色表';

-- ----------------------------
-- Records of shop_auth_assignment
-- ----------------------------

-- ----------------------------
-- Table structure for shop_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_auth_item`;
CREATE TABLE `shop_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色名字，',
  `type` smallint(6) NOT NULL COMMENT '1权限2角儿',
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `module_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '角色是否有效',
  `sys` int(11) DEFAULT '0' COMMENT '是否是系统角色1是',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`) USING BTREE,
  KEY `idx-auth_item-type` (`type`) USING BTREE,
  KEY `fk_module_id` (`module_id`) USING BTREE,
  CONSTRAINT `shop_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `shop_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `shop_auth_item_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色权限表';

-- ----------------------------
-- Records of shop_auth_item
-- ----------------------------
INSERT INTO `shop_auth_item` VALUES ('admin', '1', '超级管理员', null, null, null, '1', '0', '1559719318', '1559719318');
INSERT INTO `shop_auth_item` VALUES ('category/*', '2', 'category/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('category/add', '2', 'category/add', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('category/del', '2', 'category/del', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('category/delete', '2', 'category/delete', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('category/list', '2', 'category/list', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('category/mod', '2', 'category/mod', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('category/rename', '2', 'category/rename', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('category/tree', '2', 'category/tree', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('common/*', '2', 'common/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('default/*', '2', 'default/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('default/index', '2', 'default/index', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('manage/*', '2', 'manage/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('manage/changeemail', '2', 'manage/changeemail', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('manage/changepass', '2', 'manage/changepass', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('manage/del', '2', 'manage/del', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('manage/mailchangepass', '2', 'manage/mailchangepass', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('manage/managers', '2', 'manage/managers', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('manage/reg', '2', 'manage/reg', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('order/*', '2', 'order/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('order/detail', '2', 'order/detail', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('order/list', '2', 'order/list', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('order/send', '2', 'order/send', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('product/*', '2', 'product/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('product/add', '2', 'product/add', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('product/del', '2', 'product/del', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('product/list', '2', 'product/list', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('product/mod', '2', 'product/mod', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('product/off', '2', 'product/off', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('product/on', '2', 'product/on', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('product/removepic', '2', 'product/removepic', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('public/*', '2', 'public/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('public/login', '2', 'public/login', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('public/logout', '2', 'public/logout', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('public/seekpassword', '2', 'public/seekpassword', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('rbac/*', '2', 'rbac/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('rbac/createrole', '2', 'rbac/createrole', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('rbac/roles', '2', 'rbac/roles', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('user', '1', '普通用户', null, null, null, '1', '0', '1559719576', '1559719576');
INSERT INTO `shop_auth_item` VALUES ('user/*', '2', 'user/*', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('user/del', '2', 'user/del', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('user/reg', '2', 'user/reg', null, null, null, '1', '0', '1559726340', '1559726340');
INSERT INTO `shop_auth_item` VALUES ('user/users', '2', 'user/users', null, null, null, '1', '0', '1559726340', '1559726340');

-- ----------------------------
-- Table structure for shop_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `shop_auth_item_child`;
CREATE TABLE `shop_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限',
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色',
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`) USING BTREE,
  CONSTRAINT `shop_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `shop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `shop_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `shop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色权限关系表';

-- ----------------------------
-- Records of shop_auth_item_child
-- ----------------------------
INSERT INTO `shop_auth_item_child` VALUES ('user', 'admin');
INSERT INTO `shop_auth_item_child` VALUES ('user', 'category/*');
INSERT INTO `shop_auth_item_child` VALUES ('user', 'manage/*');

-- ----------------------------
-- Table structure for shop_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `shop_auth_rule`;
CREATE TABLE `shop_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of shop_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for shop_cart
-- ----------------------------
DROP TABLE IF EXISTS `shop_cart`;
CREATE TABLE `shop_cart` (
  `cartid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `productid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `productnum` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cartid`),
  KEY `shop_cart_productid` (`productid`),
  KEY `shop_cart_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_cart
-- ----------------------------

-- ----------------------------
-- Table structure for shop_category
-- ----------------------------
DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE `shop_category` (
  `cateid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL DEFAULT '',
  `parentid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cateid`),
  KEY `shop_category_parentid` (`parentid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_category
-- ----------------------------
INSERT INTO `shop_category` VALUES ('1', '电子产品', '0', '1559630616');
INSERT INTO `shop_category` VALUES ('2', '移动产品', '1', '1559630652');
INSERT INTO `shop_category` VALUES ('3', '手机', '2', '1559630665');
INSERT INTO `shop_category` VALUES ('4', '12121', '0', '1559637165');
INSERT INTO `shop_category` VALUES ('5', '2222', '0', '1559637169');
INSERT INTO `shop_category` VALUES ('6', '33333', '0', '1559637172');
INSERT INTO `shop_category` VALUES ('7', '44444', '0', '1559637174');
INSERT INTO `shop_category` VALUES ('8', '55555', '0', '1559637176');
INSERT INTO `shop_category` VALUES ('9', '66666', '0', '1559637179');
INSERT INTO `shop_category` VALUES ('10', '777777', '0', '1559637182');
INSERT INTO `shop_category` VALUES ('12', '99999', '0', '1559637187');
INSERT INTO `shop_category` VALUES ('13', '10', '0', '1559637191');
INSERT INTO `shop_category` VALUES ('14', '11', '0', '1559637194');
INSERT INTO `shop_category` VALUES ('15', '吴沐辰', '0', '1559637198');

-- ----------------------------
-- Table structure for shop_order
-- ----------------------------
DROP TABLE IF EXISTS `shop_order`;
CREATE TABLE `shop_order` (
  `orderid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `addressid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  `expressid` int(10) unsigned NOT NULL DEFAULT '0',
  `expressno` varchar(50) NOT NULL DEFAULT '',
  `tradeno` varchar(100) NOT NULL DEFAULT '',
  `tradeext` text,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderid`),
  KEY `shop_order_userid` (`userid`),
  KEY `shop_order_addressid` (`addressid`),
  KEY `shop_order_expressid` (`expressid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_order
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail`;
CREATE TABLE `shop_order_detail` (
  `detailid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `productid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `productnum` int(10) unsigned NOT NULL DEFAULT '0',
  `orderid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`detailid`),
  KEY `shop_order_detail_productid` (`productid`),
  KEY `shop_order_detail_orderid` (`orderid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_order_detail
-- ----------------------------

-- ----------------------------
-- Table structure for shop_product
-- ----------------------------
DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE `shop_product` (
  `productid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cateid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `descr` text,
  `num` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cover` varchar(200) NOT NULL DEFAULT '',
  `pics` text,
  `issale` enum('0','1') NOT NULL DEFAULT '0',
  `ishot` enum('0','1') NOT NULL DEFAULT '0',
  `istui` enum('0','1') NOT NULL DEFAULT '0',
  `saleprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ison` enum('0','1') NOT NULL DEFAULT '1',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`productid`),
  KEY `shop_product_cateid` (`cateid`),
  KEY `shop_product_ison` (`ison`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_product
-- ----------------------------

-- ----------------------------
-- Table structure for shop_profile
-- ----------------------------
DROP TABLE IF EXISTS `shop_profile`;
CREATE TABLE `shop_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `truename` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '2016-01-01' COMMENT '生日',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `company` varchar(100) NOT NULL DEFAULT '' COMMENT '公司',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户的ID',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `shop_profile_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_profile
-- ----------------------------

-- ----------------------------
-- Table structure for shop_user
-- ----------------------------
DROP TABLE IF EXISTS `shop_user`;
CREATE TABLE `shop_user` (
  `userid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(32) NOT NULL DEFAULT '',
  `userpass` char(64) NOT NULL DEFAULT '',
  `useremail` varchar(100) NOT NULL DEFAULT '',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `shop_user_username_userpass` (`username`,`userpass`),
  UNIQUE KEY `shop_user_useremail_userpass` (`useremail`,`userpass`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_user
-- ----------------------------
INSERT INTO `shop_user` VALUES ('1', 'imooc_5cf7186f61a84', 'cd1757b0485aa44a0938768641c14f09', '1992873023@qq.com', '1559697522');
INSERT INTO `shop_user` VALUES ('2', 'mmmmmm', '$2y$13$ygc3aOwCzjC7pJyqVuBNq.W2X90N7IHXmhI4HyNq/YwzeuPnUVmdu', 'mmmmmm@163.com', '1559714078');
