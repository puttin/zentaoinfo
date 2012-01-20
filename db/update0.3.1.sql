ALTER TABLE `zt_infoasset` ADD `use` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '';
UPDATE `zt_infoasset` SET `status` = `status` + 1;
-- ALTER TABLE `zt_action` ADD `extinforead` enum('0','1') NOT NULL default '0';
