-- Local db にDATABASEを作成. 名前:BATON_main_database 
CREATE DATABASE BATON_main_database;

-- local db にユーザー追加  名前:BATON_user PASS:123BGhj23jkL0
CREATE USER IF NOT EXISTS BATON_user IDENTIFIED BY '123BGhj23jkL0';

-- BATON_user に BATON_main_database の中であれば何でもできる権限追加。
GRANT ALL ON BATON_main_database.* TO BATON_user;

-- BATON_main_database の中にuserテーブル作成。
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
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- BATON_main_database の中にorder_ver_1テーブル作成。
CREATE TABLE IF NOT EXISTS order_ver_1 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    day VARCHAR(10) NOT NULL ,
    number_of_peaple_id INT NOT NULL ,
    price INT NOT NULL ,
    Contents VARCHAR(255) NOT NULL,
    Prerequisite VARCHAR NOT NULL,
    community_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS person_group (
    id INT PRIMARY KEY AUTO_INCREMENT,
    adult INT DEFAULT 0,
    child INT DEFAULT 0
);

-- BATON_main_database の中にcommunity_ver_1テーブル作成。
CREATE TABLE IF NOT EXISTS community_ver_1 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    community_name VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

