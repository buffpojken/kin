# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.21)
# Database: tmertz_dev.kin.com
# Generation Time: 2014-12-03 12:12:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table kin_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_comments`;

CREATE TABLE `kin_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `updateID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table kin_friendships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_friendships`;

CREATE TABLE `kin_friendships` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `friendID` int(11) DEFAULT NULL,
  `isConfirmed` binary(1) DEFAULT '0',
  `timeCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table kin_likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_likes`;

CREATE TABLE `kin_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `updateID` int(11) DEFAULT NULL,
  `commentID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table kin_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_messages`;

CREATE TABLE `kin_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `threadID` int(11) DEFAULT '0',
  `senderID` int(11) DEFAULT NULL,
  `recipientID` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subject` varchar(200) DEFAULT '',
  `message` longtext,
  `isRead` binary(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table kin_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_notifications`;

CREATE TABLE `kin_notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipientID` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `message` longtext,
  `link` longtext,
  `isRead` binary(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table kin_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_options`;

CREATE TABLE `kin_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_key` varchar(100) DEFAULT NULL,
  `option_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table kin_updates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_updates`;

CREATE TABLE `kin_updates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `message` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table kin_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_users`;

CREATE TABLE `kin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteAdmin` binary(1) DEFAULT '0',
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `userHash` varchar(40) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `passwordResetHash` varchar(40) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table kin_users_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kin_users_meta`;

CREATE TABLE `kin_users_meta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `meta_key` varchar(100) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
