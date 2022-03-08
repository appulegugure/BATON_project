-- Local db にDATABASEを作成. 名前:BATON_main_database 
CREATE DATABASE IF NOT EXISTS BATON_main_database;

-- local db にユーザー追加  名前:BATON_user PASS:123BGhj23jkL0
CREATE USER IF NOT EXISTS BATON_user IDENTIFIED BY '123BGhj23jkL0';

-- BATON_user に BATON_main_database の中であれば何でもできる権限追加。
GRANT ALL ON BATON_main_database.* TO BATON_user;

-- BATON_main_database の中にuserテーブル作成。
CREATE TABLE IF NOT EXISTS user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50)  UNIQUE NOT NULL,
    password VARCHAR(3000) NOT NULL,
    corporation_flag BOOL,
    company VARCHAR(50),
    corporatiion_number INT,
    name VARCHAR(32) NOT NULL,
    address INT NOT NULL,
    tel INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- BATON_main_database の中にcommunityテーブル作成。
CREATE TABLE IF NOT EXISTS community (
    community_id INT PRIMARY KEY AUTO_INCREMENT,
    community_name VARCHAR(50) NOT NULL,
    community_maker INT NOT NULL,
    condition1  VARCHAR(250),
    condition2  VARCHAR(250),
    condition3  VARCHAR(250),
    condition4  VARCHAR(250),
    condition5  VARCHAR(250),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- BATON_main_database の中にorderテーブル作成。
CREATE TABLE IF NOT EXISTS job_order (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    community INT NOT NULL,
    order_user INT NOT NULL,
    receive_user INT,
    title VARCHAR(32) NOT NULL,
    job VARCHAR(250) NOT NULL,
    day DATE NOT NULL,
    people INT,
    price INT NOT NULL,
    status VARCHAR(32),
    condition1  VARCHAR(250),
    condition2  VARCHAR(250),
    condition3  VARCHAR(250),
    condition4  VARCHAR(250),
    condition5  VARCHAR(250),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- BATON_main_database の中にcommunity_userテーブル作成。
CREATE TABLE IF NOT EXISTS community_user (
    community INT,
    user INT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (community, user)
);