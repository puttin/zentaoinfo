ALTER TABLE `zt_infoasset` ADD `viewedCount` smallint(6) NOT NULL DEFAULT '0' AFTER `editedCount`,
ADD `product` mediumint(8) unsigned NOT NULL default '0' AFTER `module`,
ADD `project` mediumint(8) unsigned NOT NULL default '0' AFTER `product`;
ALTER TABLE `zt_info` ADD `viewedCount` smallint(6) NOT NULL DEFAULT '0' AFTER `editedCount`,
ADD `relatedStory` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
ADD `relatedTask` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
ADD `relatedBug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

