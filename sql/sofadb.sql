
SET GLOBAL event_scheduler = ON;

CREATE TABLE `admin_notes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `casenumber` varchar(100) CHARACTER SET utf8 NOT NULL,
  `caseyear` int(11) unsigned DEFAULT NULL,
  `casename` varchar(100) CHARACTER SET utf8 NOT NULL,
  `caseagency` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `memberid` int(11) unsigned NOT NULL,
  `fasex` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `faage` float UNSIGNED DEFAULT NULL,
  `faage2` float UNSIGNED DEFAULT NULL,
  `faageunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `faageunits2` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `faage_notes` varchar(100) DEFAULT NULL,
  `faancestryottext` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fastature` float unsigned DEFAULT NULL,
  `fastature2` float unsigned DEFAULT NULL,
  `fastatureunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idsex` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idsex_notes` varchar(100) DEFAULT NULL,
  `idage` float unsigned DEFAULT NULL,
  `idage_notes` varchar(100) DEFAULT NULL,
  `idageunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idraceas` boolean default 0,
  `idraceaf` boolean default 0,
  `idracewh` boolean default 0,
  `idracehi` boolean default 0,
  `idracena` boolean default 0,
  `idraceot` boolean default 0,
  `idraceottext` text CHARACTER SET utf8 DEFAULT NULL,
  `idancaddtext` text CHARACTER SET utf32 COLLATE utf32_bin DEFAULT NULL,
  `idstature` float unsigned DEFAULT NULL,
  `idstatureunits` text CHARACTER SET utf8 DEFAULT NULL,
  `idstature_notes` varchar(100) DEFAULT NULL,
  `idsource` text CHARACTER SET utf8 DEFAULT NULL,
  `known_none` tinyint(1) unsigned DEFAULT NULL,
  `known_sex` tinyint(1) unsigned DEFAULT NULL,
  `known_age` tinyint(1) unsigned DEFAULT NULL,
  `known_ancestry` tinyint(1) unsigned DEFAULT NULL,
  `known_stature` tinyint(1) unsigned DEFAULT NULL,
  `known_unable_to_determine` tinyint(1) unsigned DEFAULT NULL,
  `fdb_consent` varchar(20) DEFAULT NULL,
  `nummethods` int(11) DEFAULT NULL,
  `casenotes` text CHARACTER SET utf8 DEFAULT NULL,
  `datestarted` date DEFAULT NULL,
  `datemodified` date DEFAULT NULL,
  `datesubmitted` date DEFAULT NULL,
  `submissionstatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memberid` (`memberid`),
  KEY `submissionstatus` (`submissionstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `downloads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `input_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `input_type` varchar(50) DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(100) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `degreeyear` int(11) unsigned NOT NULL,
  `fieldofstudy` varchar(100) NOT NULL,
  `aafsstatus` int(11) unsigned NOT NULL,
  `institution` varchar(100) NOT NULL,
  `region` int(11) unsigned NOT NULL,
  `mailaddress` varchar(100) NOT NULL,
  `mailaddress2` varchar(100) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(25) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `lastlogin` DATETIME DEFAULT NULL,
  `permissionstatus` int(11) unsigned NOT NULL,
  `dateregistered` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `affiliation` varchar(100) DEFAULT NULL,
  `sponsor` varchar(100) DEFAULT NULL,
  `sponsor_email` varchar(100) DEFAULT NULL,
  `sponsor_affiliation` varchar(100) DEFAULT NULL,
  `agree_to_terms` tinyint(1) DEFAULT 0,
  `signature` varchar(100) DEFAULT NULL,
  `signature_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `methods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `methodname` varchar(100) NOT NULL,
  `methodtypenum` int(11) NOT NULL,
  `measurementtype` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `instructions` varchar(100) DEFAULT NULL,
  `methodinfotype` varchar(100) DEFAULT NULL,
  `prompt` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `top` tinyint(1) DEFAULT NULL,
  `fdb` tinyint(1) DEFAULT NULL,
  `time_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `methodid` int(10) unsigned DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `header` varchar(100) DEFAULT NULL,
  `option_header` varchar(100) DEFAULT NULL,
  `input_type` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `time_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_info_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method_infos_id` int(10) unsigned DEFAULT NULL,
  `value` varchar(500) DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_info_reference_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method_infos_id` int(10) unsigned DEFAULT NULL,
  `reference_id` int(10) unsigned DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_info_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method_type` varchar(50) DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `password_reset` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `selector` char(16) DEFAULT NULL,
  `token` char(64) DEFAULT NULL,
  `expires` DATETIME DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `prompts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prompt_name` varchar(50) DEFAULT NULL,
  `prompt` varchar(500) DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reference` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `reference_name` varchar(100) DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reference_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tier2id` int(10) unsigned DEFAULT NULL,
  `method_info_id` int(10) unsigned DEFAULT NULL,
  `reference_id` int(10) unsigned DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tier2data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `memberid` int(11) unsigned NOT NULL,
  `caseid` int(11) unsigned NOT NULL,
  `methodtype` int(11) unsigned NOT NULL,
  `methodid` int(11) unsigned NOT NULL,
  `estimated_outcome_1` varchar(100) DEFAULT NULL,
  `estimated_outcome_2` varchar(100) DEFAULT NULL,
  `estimated_outcome_units` varchar(50) DEFAULT NULL,
  `time_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `memberid` (`memberid`,`caseid`,`methodid`),
   KEY `methodtype` (`methodtype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tier3data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tier2id` int(11) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `method_info_option_id` int(10) unsigned DEFAULT NULL,
  `time_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE DEFINER='root'@'localhost' EVENT password_reset
        ON SCHEDULE EVERY 1 HOUR
        STARTS '2022-01-01 00:00:00'
	ON COMPLETION PRESERVE ENABLE
	COMMENT 'Clears out expired password_reset requests'
        DO
                DELETE FROM password_reset WHERE expires < CURRENT_TIMESTAMP;

INSERT INTO members (uname, pwd, firstname, lastname, title, degree, degreeyear, fieldofstudy, aafsstatus, institution, region, mailaddress, city, state, zip, permissionstatus) VALUES
('admin@admin.com', '$2y$10$xZD6cdVskRHYhHkk7l4Mf.oz/VQaVdiQ6LrnzMC31PFevhBxisTyG', 'ADMIN', 'User', '', '',0, '', 0, '', 0,'', '', '' ,'', 2);

INSERT INTO `input_types` (`id`, `input_type`) VALUES(1, 'multiselect');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(2, 'singleselect');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(3, 'select_each');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(4, 'numeric_entry');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(5, 'text_entry');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(6, 'user_input_with_dropdown');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(7, 'text_area');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(8, 'category');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(9, 'estimated_outcome');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(13, 'two-column');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(14, 'checkbox_select');
INSERT INTO `input_types` (`id`, `input_type`) VALUES(16, 'left_right');

