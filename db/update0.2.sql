-- 增加mailto(抄送),deadline(过期日),pri,Stickie(普通,置顶,总置顶),state(正常,关闭评论),Highlight(高亮)字段。 
ALTER TABLE `zt_info` ADD `mailto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '' AFTER `editedCount` ,
ADD `deadline` date NOT NULL default '0000-00-00' AFTER `lastEditedDate`,
ADD `pri` tinyint(3) unsigned NOT NULL AFTER `type`,
ADD `stickie` enum('0','1','2') NOT NULL default '0',
ADD `state` enum('normal','nocomment') NOT NULL default 'normal',
ADD `highlight` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
