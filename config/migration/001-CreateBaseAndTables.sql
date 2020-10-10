-- Создаем базу --
create database if not exists `phone`;
use `phone`;


-- Таблица пользователей --
create table if not exists `users` (
    `id` int(10) unsigned not null auto_increment,
    `login` varchar(16) not null,
    `email` varchar(64) not null,
    `password` varchar(64) not null,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;


-- Таблица пользовательских сессий --
create table if not exists `users_sessions` (
    `user_id` int(10) unsigned not null,
    `session_id` varchar(64) not null,
    `date` datetime null,
    `useragent` varchar(255) null
)
engine = innodb
character set utf8
collate utf8_general_ci;


-- Таблица записной книги --
create table if not exists `phone_book` (
    `id` int(10) unsigned not null auto_increment,
    `owner_id` int(10) unsigned not null,
    `name` varchar(64) null,
    `last_name` varchar(64) null,
    `phone` varchar(16) null,
    `email` varchar(64) null,
    `image` varchar(255) null,
    primary key (id),
    FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;
