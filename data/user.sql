CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` char(13) NOT NULL,
  `password` char(32) NOT NULL,
  `del_time` datetime NOT NULL,
  `is_ban` tinyint(4) NOT NULL DEFAULT '0',
  `uuid` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='用户表'

INSERT INTO api.`user` (mobile,password,del_time,is_ban,uuid) VALUES
('15511111111','e10adc3949ba59abbe56e057f20f883e','2020-04-13 12:36:04.0',0,'');