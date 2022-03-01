CREATE DATABASE IF NOT EXISTS `website01` DEFAULT CHARACTER SET utf8;

CREATE USER `website01`@`%` IDENTIFIED WITH mysql_native_password BY 'eLow8yBSp34wXx';
GRANT ALL PRIVILEGES ON `website01`.* TO `website01`@`%`;

USE `website01`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(256) UNIQUE COLLATE utf8_unicode_ci,
  `password` varchar(256) COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `users` (`id`, `name`, `password`) VALUES
  (1, 'user1', SHA2('abc', 256));

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categories` (`id`, `title`) VALUES
  (1, 'Default'),
  (2, 'Homework');

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int,
  `title` varchar(256) COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `category_id` int,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`category_id`) REFERENCES categories(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `notes` (`id` ,`date`, `user_id`, `title`, `content`, `category_id`) VALUES
  (1, '2022-01-26 17:27:49', 1, 'Note 1', 'Content for note 1', 1),
  (2, '2022-02-08 11:17:16', 1, 'Note 2', 'Content for note 2', 1);