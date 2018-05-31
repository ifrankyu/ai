DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) DEFAULT NULL,
  `spellName` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 未设置 1 男 2 女',
  `logo` varchar(255) DEFAULT NULL,
  `briefIntro` varchar(255) DEFAULT NULL,
  `letter` char(1) DEFAULT NULL,
  `provinceId` smallint(6) unsigned NOT NULL DEFAULT '0',
  `province` varchar(50) DEFAULT NULL,
  `cityId` smallint(6) unsigned NOT NULL DEFAULT '0',
  `city` varchar(50) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_ix` (`phone`),
  UNIQUE KEY `spellName_ix` (`spellName`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
