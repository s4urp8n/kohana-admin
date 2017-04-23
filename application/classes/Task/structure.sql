
SET @@sql_mode = '';
SET @@GLOBAL.sql_mode = '';


DROP TABLE IF EXISTS  `main_items`;
CREATE TABLE IF NOT EXISTS `main_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ru_name` varchar(255) NOT NULL,
  `en_name` varchar(255) NOT NULL,
  `ru_content` longtext NOT NULL,
  `en_content` longtext NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `ru_title` longtext,
  `en_title` longtext,
  `videos` longtext NOT NULL,
  `ru_description` longtext,
  `en_description` longtext,
  `ru_keywords` longtext,
  `en_keywords` longtext,
  `visible` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '0',
  `show_caption` int(11) NOT NULL DEFAULT '1',
  `go_child` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_2` (`ru_name`),
  UNIQUE KEY `name_3` (`en_name`),
  KEY `sort` (`sort`),
  KEY `module` (`module`),
  KEY `show_caption` (`show_caption`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS  `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_datetime` date NOT NULL,
  `ru_text` longtext NOT NULL,
  `en_text` longtext NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  `ru_caption` varchar(1024) NOT NULL,
  `en_caption` varchar(1024) NOT NULL,
  `ru_keywords` longtext,
  `en_keywords` longtext,
  `ru_description` longtext,
  `en_description` longtext,
  `ru_title` longtext,
  `en_title` longtext,
  `videos` longtext,
  PRIMARY KEY (`id`),
  KEY `visible` (`visible`),
  KEY `ru_caption` (`ru_caption`(255)),
  KEY `en_caption` (`en_caption`(255)),
  KEY `_datetime` (`_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS  `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS  `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  KEY `user_id_2` (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS  `secondary_items`;
CREATE TABLE IF NOT EXISTS `secondary_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `main_item_id` bigint(20) unsigned NOT NULL,
  `ru_name` varchar(255) NOT NULL,
  `en_name` varchar(255) NOT NULL,
  `ru_content` longtext NOT NULL,
  `en_content` longtext NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `ru_title` longtext,
  `en_title` longtext,
  `videos` longtext,
  `ru_description` longtext,
  `en_description` longtext,
  `ru_keywords` longtext,
  `en_keywords` longtext,
  `visible` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '0',
  `show_caption` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `en_name` (`en_name`),
  KEY `ru_name` (`ru_name`),
  KEY `visible` (`visible`),
  KEY `sort` (`sort`),
  KEY `module` (`module`),
  KEY `show_caption` (`show_caption`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS  `uploads`;
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_2` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS  `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `real_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `registered` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` int(6) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `password` (`password`),
  KEY `discount` (`discount`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS  `user_tokens`;
CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `settings`;
CREATE TABLE `settings` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`contact_email` CHAR(255) NOT NULL,
	`contact_phone` CHAR(255) NOT NULL,
	`contact_latitude` CHAR(255) NOT NULL,
	`contact_longitude` CHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;


DROP TABLE IF EXISTS  `translate`;
CREATE TABLE `translate` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`_key` VARCHAR(255) NOT NULL,
	`ru` LONGTEXT  NULL,
	`en` LONGTEXT  NULL,
	`strip` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	INDEX `key` (`_key`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;


DROP TABLE IF EXISTS  `index_gallery`;
CREATE TABLE `index_gallery` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`ru_caption` VARCHAR(255) NOT NULL,
	`en_caption` VARCHAR(255) NOT NULL,
	`link` VARCHAR(1024) NOT NULL,
	`visible` INT(11) NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	INDEX `visible` (`visible`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;
