CREATE DATABASE IF NOT EXISTS `yeticave`;
USE `yeticave`;

CREATE TABLE IF NOT EXISTS `categories` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(254) NOT NULL
);

CREATE TABLE IF NOT EXISTS `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`registration_date` DATETIME NULL,
	`email` VARCHAR(254) NOT NULL,
	`name` VARCHAR(254) NOT NULL,
	`password` VARCHAR(254) NOT NULL,
	`avatar` TEXT,
	`contacts` TEXT,
	UNIQUE INDEX `email` (`email`)
);

CREATE TABLE IF NOT EXISTS `lots` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`date_start` DATETIME NULL DEFAULT NULL,
	`name` VARCHAR(254) NOT NULL,
	`description` TEXT,
	`image` VARCHAR(254) NOT NULL,
	`price_start` INT(10) UNSIGNED NOT NULL,
	`date_end` DATETIME NOT NULL,
	`price_incriment` INT(10) UNSIGNED NOT NULL,
	`favorite_count` INT(10) UNSIGNED NULL DEFAULT NULL,
	`author` INT(10) UNSIGNED NOT NULL,
	`winner` INT(10) UNSIGNED NULL DEFAULT NULL,
	`category_id` INT(10) UNSIGNED NOT NULL,
	INDEX `name` (`name`),
	CONSTRAINT `FK_lot_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
	CONSTRAINT `FK_lot_user` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
	CONSTRAINT `FK_lot_user_w` FOREIGN KEY (`winner`) REFERENCES `users` (`id`)
);

CREATE TABLE IF NOT EXISTS `bets` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`date` DATETIME NULL DEFAULT NULL,
	`price` INT(10) UNSIGNED NOT NULL,
	`lot_id` INT(10) UNSIGNED NOT NULL,
	`user_id` INT(10) UNSIGNED NOT NULL,
	CONSTRAINT `FK_bet_lot` FOREIGN KEY	(`lot_id`) REFERENCES `lots` (`id`),
	CONSTRAINT `FK_bet_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);
