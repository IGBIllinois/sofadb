
CREATE TABLE `cases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `casenumber` varchar(100) CHARACTER SET utf8 NOT NULL,
  `caseyear` int(11) unsigned DEFAULT NULL,
  `casename` varchar(100) CHARACTER SET utf8 NOT NULL,
  `caseagency` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `memberid` int(11) unsigned NOT NULL,
  `fasex` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `faage` float unsigned DEFAULT NULL,
  `faage2` float unsigned DEFAULT NULL,
  `faageunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `faageunits2` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `faancestryeuro` tinyint(11) unsigned DEFAULT NULL,
  `faancestryaf` tinyint(11) unsigned DEFAULT NULL,
  `faancestryas` text CHARACTER SET utf8,
  `faancestryna` tinyint(11) unsigned DEFAULT NULL,
  `faancestryhi` int(11) unsigned DEFAULT NULL,
  `faancestryot` int(11) unsigned DEFAULT NULL,
  `faancestryottext` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fastature` float unsigned DEFAULT NULL,
  `fastature2` float unsigned DEFAULT NULL,
  `fastatureunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idsex` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idage` int(11) unsigned DEFAULT NULL,
  `idageunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idraceas` tinyint(11) unsigned DEFAULT NULL,
  `idraceaf` tinyint(11) unsigned DEFAULT NULL,
  `idracewh` tinyint(11) unsigned DEFAULT NULL,
  `idracehi` tinyint(11) unsigned DEFAULT NULL,
  `idracena` tinyint(11) unsigned DEFAULT NULL,
  `idraceot` tinyint(11) unsigned DEFAULT NULL,
  `idraceottext` text CHARACTER SET utf8,
  `idancaddtext` text CHARACTER SET utf32 COLLATE utf32_bin,
  `idstature` float unsigned DEFAULT NULL,
  `idstatureunits` text CHARACTER SET utf8,
  `idsource` text CHARACTER SET utf8,
  `known_none` tinyint(1) unsigned DEFAULT NULL,
  `known_sex` tinyint(1) unsigned DEFAULT NULL,
  `known_age` tinyint(1) unsigned DEFAULT NULL,
  `known_ancestry` tinyint(1) unsigned DEFAULT NULL,
  `known_stature` tinyint(1) unsigned DEFAULT NULL,
  `known_unable_to_determine` tinyint(1) unsigned DEFAULT NULL,
  `nummethods` int(11) DEFAULT NULL,
  `casenotes` text CHARACTER SET utf8,
  `datestarted` date DEFAULT NULL,
  `datemodified` date DEFAULT NULL,
  `datesubmitted` date DEFAULT NULL,
  `submissionstatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memberid` (`memberid`),
  KEY `submissionstatus` (`submissionstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
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
  `fieldofstudy` varchar(100) CHARACTER SET latin1 NOT NULL,
  `aafsstatus` int(11) unsigned NOT NULL,
  `institution` varchar(100) NOT NULL,
  `yearsexperience` int(11) unsigned NOT NULL,
  `caseperyear` int(11) unsigned NOT NULL,
  `region` int(11) unsigned NOT NULL,
  `mailaddress` varchar(100) NOT NULL,
  `mailaddress2` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `city` varchar(50) CHARACTER SET latin1 NOT NULL,
  `state` varchar(25) CHARACTER SET latin1 NOT NULL,
  `zip` varchar(10) CHARACTER SET latin1 NOT NULL,
  `phone` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `lastlogin` date DEFAULT NULL,
  `permissionstatus` int(11) unsigned NOT NULL,
  `casessubmitted` int(11) unsigned NOT NULL DEFAULT '0',
  `caseswithdrawn` int(11) unsigned NOT NULL DEFAULT '0',
  `dateregistered` date NOT NULL,
  `totalcases` int(11) unsigned NOT NULL DEFAULT '0',
  `affiliation` varchar(100) DEFAULT NULL,
  `sponsor` varchar(100) DEFAULT NULL,
  `sponsor_email` varchar(100) DEFAULT NULL,
  `sponsor_affiliation` varchar(100) DEFAULT NULL,
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

CREATE TABLE `method_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `methodid` int(10) unsigned DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `header` varchar(100) DEFAULT NULL,
  `option_header` varchar(100) DEFAULT NULL,
  `input_type` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `methods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `methodname` varchar(100) CHARACTER SET latin1 NOT NULL,
  `methodtype` varchar(100) CHARACTER SET latin1 NOT NULL,
  `methodtypenum` int(11) NOT NULL,
  `measurementtype` varchar(100) CHARACTER SET latin1 NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `instructions` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `methodinfotype` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `password_reset` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `selector` char(16) DEFAULT NULL,
  `token` char(64) DEFAULT NULL,
  `expires` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `memberid` (`memberid`,`caseid`,`methodid`),
  KEY `methodtype` (`methodtype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tier3data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tier2id` int(11) DEFAULT NULL,
  `value` text,
  `method_info_option_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
