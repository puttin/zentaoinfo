SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- DROP TABLE IF EXISTS `zt_info`;
CREATE TABLE IF NOT EXISTS `zt_info` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `keywords` varchar(255) NOT NULL default '',
  `lib` varchar(30) NOT NULL,
  `module` mediumint(8) unsigned NOT NULL default '0',
  `createdBy` varchar(30) NOT NULL default '',
  `createdDate` datetime NOT NULL,
  `lastEditedBy` varchar(30) NOT NULL default '',
  `lastEditedDate` datetime NOT NULL,
  `deadline` date NOT NULL default '0000-00-00',
  `editedCount` smallint(6) NOT NULL default '0',
  `mailto` varchar(255) NOT NULL default '',
  `deleted` enum('0','1') NOT NULL default '0',
  `company` mediumint(8) unsigned NOT NULL,
  `account` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `pri` tinyint(3) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `digest` varchar(255) NOT NULL,
  `stickie` enum('0','1','2') NOT NULL default '0',
  `state` enum('normal','nocomment') NOT NULL default 'normal',
  `highlight` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `company` (`company`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `zt_infolib`;
CREATE TABLE IF NOT EXISTS `zt_infolib` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `company` smallint(5) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  `deleted` enum('0','1') NOT NULL default '0',
  `defaultlib` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `company` (`company`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `zt_infomodule`;
CREATE TABLE IF NOT EXISTS `zt_infomodule` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `company` mediumint(8) unsigned NOT NULL,
  `root` mediumint(8) unsigned NOT NULL default '0',
  `name` char(60) NOT NULL default '',
  `parent` mediumint(8) unsigned NOT NULL default '0',
  `path` char(255) NOT NULL default '',
  `grade` tinyint(3) unsigned NOT NULL default '0',
  `order` tinyint(3) unsigned NOT NULL default '0',
  `type` char(30) NOT NULL,
  `owner` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `company` (`company`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
