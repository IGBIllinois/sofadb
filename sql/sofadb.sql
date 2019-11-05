
CREATE TABLE `cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `casenumber` text CHARACTER SET utf8 NOT NULL,
  `caseyear` int(11) DEFAULT NULL,
  `casename` text CHARACTER SET utf8 NOT NULL,
  `caseagency` text CHARACTER SET utf8,
  `memberid` int(11) NOT NULL,
  `fasex` text CHARACTER SET utf8,
  `faage` float DEFAULT NULL,
  `faage2` float DEFAULT NULL,
  `faageunits` text CHARACTER SET utf8,
  `faageunits2` text CHARACTER SET utf8,
  `faancestryeuro` int(11) DEFAULT NULL,
  `faancestryaf` int(11) DEFAULT NULL,
  `faancestryas` text CHARACTER SET utf8,
  `faancestryna` int(11) DEFAULT NULL,
  `faancestryhi` int(11) DEFAULT NULL,
  `faancestryot` int(11) DEFAULT NULL,
  `faancestryottext` text CHARACTER SET utf8,
  `fastature` float DEFAULT NULL,
  `fastature2` float DEFAULT NULL,
  `fastatureunits` text CHARACTER SET utf8,
  `idsex` text CHARACTER SET utf8,
  `idage` int(11) DEFAULT NULL,
  `idageunits` text CHARACTER SET utf8,
  `idraceas` int(11) DEFAULT NULL,
  `idraceaf` int(11) DEFAULT NULL,
  `idracewh` int(11) DEFAULT NULL,
  `idracehi` int(11) DEFAULT NULL,
  `idracena` int(11) DEFAULT NULL,
  `idraceot` int(11) DEFAULT NULL,
  `idraceottext` text CHARACTER SET utf8,
  `idancaddtext` text CHARACTER SET utf32 COLLATE utf32_bin,
  `idstature` float DEFAULT NULL,
  `idstatureunits` text CHARACTER SET utf8,
  `idsource` text CHARACTER SET utf8,
  `known_none` tinyint(1) DEFAULT NULL,
  `known_sex` tinyint(1) DEFAULT NULL,
  `known_age` tinyint(1) DEFAULT NULL,
  `known_ancestry` tinyint(1) DEFAULT NULL,
  `known_stature` tinyint(1) DEFAULT NULL,
  `known_unable_to_determine` tinyint(1) DEFAULT NULL,
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
  `input_type` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` text NOT NULL,
  `pwd` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `title` text NOT NULL,
  `degree` text NOT NULL,
  `degreeyear` int(11) NOT NULL,
  `fieldofstudy` text CHARACTER SET latin1 NOT NULL,
  `aafsstatus` int(11) NOT NULL,
  `institution` text NOT NULL,
  `yearsexperience` int(11) NOT NULL,
  `caseperyear` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `mailaddress` text NOT NULL,
  `mailaddress2` text CHARACTER SET latin1,
  `city` text CHARACTER SET latin1 NOT NULL,
  `state` text CHARACTER SET latin1 NOT NULL,
  `zip` text CHARACTER SET latin1 NOT NULL,
  `phone` text CHARACTER SET latin1,
  `lastlogin` date DEFAULT NULL,
  `permissionstatus` int(11) NOT NULL,
  `casessubmitted` int(11) NOT NULL,
  `caseswithdrawn` int(11) NOT NULL,
  `dateregistered` date NOT NULL,
  `totalcases` int(11) NOT NULL,
  `affiliation` text,
  `sponsor` text,
  `sponsor_email` text,
  `sponsor_affiliation` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `methodid` int(11) NOT NULL,
  `output_data_1` varchar(500) DEFAULT NULL,
  `output_data_2` varchar(500) DEFAULT NULL,
  `output_data_3` varchar(500) DEFAULT NULL,
  `output_data_4` varchar(500) DEFAULT NULL,
  `output_data_1_description` varchar(100) DEFAULT NULL,
  `output_data_2_description` varchar(100) DEFAULT NULL,
  `output_data_3_description` varchar(100) DEFAULT NULL,
  `output_data_4_description` varchar(100) DEFAULT NULL,
  `reference_list` varchar(100) DEFAULT NULL,
  `age_range` varchar(100) DEFAULT NULL,
  `user_interaction` varchar(100) DEFAULT NULL,
  `expected_result_1` varchar(100) DEFAULT NULL,
  `expected_result_2` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_info_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method_infos_id` int(10) unsigned DEFAULT NULL,
  `value` text,
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
  `name` text,
  `header` text,
  `option_header` text,
  `input_type` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `methodfeature` (
  `methodid` int(11) NOT NULL,
  `featureid` int(11) NOT NULL,
  `measurementtype` text CHARACTER SET utf8 NOT NULL,
  KEY `methodid` (`methodid`,`featureid`),
  KEY `featureid` (`featureid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `methodphase` (
  `methodid` int(11) NOT NULL,
  `featureid` int(11) NOT NULL,
  `phaseid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `methodname` text CHARACTER SET latin1 NOT NULL,
  `methodtype` text CHARACTER SET latin1 NOT NULL,
  `methodtypenum` int(11) NOT NULL,
  `measurementtype` text CHARACTER SET latin1 NOT NULL,
  `description` text,
  `instructions` text CHARACTER SET latin1,
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

CREATE TABLE `phase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phasename` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

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

CREATE TABLE `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `tier2data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `caseid` int(11) NOT NULL,
  `methodtype` int(11) NOT NULL,
  `methodid` int(11) NOT NULL,
  `featureid` int(11) DEFAULT NULL,
  `phaseid` int(11) DEFAULT NULL,
  `estimated_outcome_1` varchar(100) DEFAULT NULL,
  `estimated_outcome_2` varchar(100) DEFAULT NULL,
  `estimated_outcome_units` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memberid` (`memberid`,`caseid`,`methodid`,`featureid`,`phaseid`),
  KEY `methodtype` (`methodtype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tier3data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tier2id` int(11) DEFAULT NULL,
  `methodinfoid` int(11) DEFAULT NULL,
  `value` text,
  `reference` varchar(100) DEFAULT NULL,
  `method_info_option_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

