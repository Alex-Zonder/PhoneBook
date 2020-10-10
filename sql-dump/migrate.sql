-- Создаем базу --
create database if not exists `my_cyber_light_new`;
use `my_cyber_light_new`;


-- Таблица пользователей --
create table if not exists `users` (
	`id` int(10) unsigned not null auto_increment,
	`login` varchar(16) not null,
	`email` varchar(255) not null,
	`password` varchar(255) not null,
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
