<?php

$sql = "
DROP TABLE IF EXISTS `rf_addon_trader_list`;
CREATE TABLE `rf_addon_trader_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `wxname` varchar(50) NOT NULL COMMENT '姓名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `phone` varchar(50) COMMENT '电话',
  `department` varchar(50) NOT NULL COMMENT '部门',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(-1:已删除,0:禁用,1:正常)',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='销售员表';

-- ----------------------------
-- Table structure for rf_addon_sign_shopping_street_record
-- ----------------------------
DROP TABLE IF EXISTS `rf_addon_trader_log`;
CREATE TABLE `rf_addon_trader_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `wxid` varchar(255) NOT NULL,
  `channels` varchar(2048) DEFAULT NULL,
  `fansum` int(11) DEFAULT '0',
  `record_image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(-1:已删除,0:禁用,1:正常)',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='考勤表';

-- ----------------------------
-- Table structure for rf_addon_sign_shopping_street_stat
-- ----------------------------
DROP TABLE IF EXISTS `rf_addon_trader_channel`;
CREATE TABLE `rf_addon_trader_channel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '渠道名称',
  `icon` varchar(255) CHARACTER SET utf8mb4  DEFAULT '' COMMENT '标识',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(-1:已删除,0:禁用,1:正常)',
  `description` char(140) DEFAULT '' COMMENT '描述',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='渠道表';

";

// 执行sql
 Yii::$app->getDb()->createCommand($sql)->execute();