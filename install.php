<?php

$sql = "
DROP TABLE IF EXISTS `rf_addon_trader_list`;
CREATE TABLE `rf_addon_trader_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `phone` varchar(50) NOT NULL COMMENT '电话',
  `department` varchar(50) NOT NULL COMMENT '部门',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='销售员表';

-- ----------------------------
-- Table structure for rf_addon_sign_shopping_street_record
-- ----------------------------
DROP TABLE IF EXISTS `rf_addon_trader_log`;
CREATE TABLE `rf_addon_trader_log` (
  `id` int(11) NOT NULL,
  `wxid` varchar(255) NOT NULL,
  `channels` varchar(255) DEFAULT NULL,
  `fansum` int(11) DEFAULT '0',
  `record_date` date DEFAULT NULL COMMENT '日期',
  `record_image` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='考勤表';

-- ----------------------------
-- Table structure for rf_addon_sign_shopping_street_stat
-- ----------------------------
DROP TABLE IF EXISTS `rf_addon_trader_channel`;
CREATE TABLE `rf_addon_trader_channel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '渠道名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='渠道表';

";

// 执行sql
 Yii::$app->getDb()->createCommand($sql)->execute();