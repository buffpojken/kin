
CREATE TABLE IF NOT EXISTS `kin_subscriptions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
	`updateID` int(11) NOT NULL, 
	`userID` int(11) NOT NULL, 
	`active` binary(1) DEFAULT '1', 
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `kin_notifications` ADD COLUMN `groupingKey` VARCHAR(10); 