-- Local db にDATABASEを作成. 名前:BATON_main_database 
CREATE DATABASE BATON_main_database;

-- local db にユーザー追加  名前:BATON_user PASS:123BGhj23jkL0
CREATE USER IF NOT EXISTS BATON_user IDENTIFIED BY '123BGhj23jkL0';

-- BATON_user に BATON_main_database の中であれば何でもできる権限追加。
GRANT ALL ON BATON_main_database.* TO BATON_user;

-- BATON_main_database の中にuserテーブル作成。
CREATE TABLE `community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condition1` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition2` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition3` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition4` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition5` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `community_content` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `community_maker` (`user_email`),
  CONSTRAINT `community_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `community_user` (
  `community` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`community`,`user_email`),
  KEY `user` (`user_email`),
  CONSTRAINT `community_user_ibfk_1` FOREIGN KEY (`community`) REFERENCES `community` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `job_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` datetime NOT NULL,
  `people_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition1` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition2` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition3` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition4` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition5` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `community_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `community_id` (`community_id`),
  KEY `order_user_email` (`order_user_email`),
  KEY `receive_user_email` (`receive_user_email`),
  KEY `people_id` (`people_id`),
  CONSTRAINT `job_order_ibfk_3` FOREIGN KEY (`community_id`) REFERENCES `community` (`id`),
  CONSTRAINT `job_order_ibfk_7` FOREIGN KEY (`order_user_email`) REFERENCES `user` (`email`),
  CONSTRAINT `job_order_ibfk_9` FOREIGN KEY (`people_id`) REFERENCES `Number_of_people` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `Number_of_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adult` int(11) NOT NULL DEFAULT 0,
  `child` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pre_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urltoken` varchar(128) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `user` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`email`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

