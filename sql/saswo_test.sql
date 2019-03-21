


CREATE TABLE `casemethodfeature` (
  `caseid` int(11) NOT NULL,
  `methodid` int(11) NOT NULL,
  `featureid` int(11) NOT NULL,
  `stage` text CHARACTER SET utf8,
  `outcome` text CHARACTER SET utf8,
  `m1` float DEFAULT NULL,
  `m1units` text CHARACTER SET utf8,
  `m2` float DEFAULT NULL,
  `m2units` text CHARACTER SET utf8,
  `matched` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  `nummethods` int(11) DEFAULT NULL,
  `casenotes` text CHARACTER SET utf8,
  `datestarted` date NOT NULL,
  `datemodified` date NOT NULL,
  `datesubmitted` date NOT NULL,
  `submissionstatus` int(11) NOT NULL,
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


CREATE TABLE `membercasetable` (
  `memberid` int(11) NOT NULL,
  `caseid` int(11) NOT NULL,
  KEY `memberid` (`memberid`,`caseid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `methoddata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `methodid` int(11) DEFAULT NULL,
  `dataname` text,
  `datatype` text,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `phase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phasename` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE `simplecase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `user` text CHARACTER SET utf8 NOT NULL,
  `datestarted` date NOT NULL,
  `datemodified` date NOT NULL,
  `datesubmitted` date NOT NULL,
  `datewithdrawn` date NOT NULL,
  `agefa` float NOT NULL,
  `agefaunits` int(11) NOT NULL,
  `staturefa` float NOT NULL,
  `staturefaunits` int(11) NOT NULL,
  `ancestryfa` int(11) NOT NULL,
  `sexfa` int(11) NOT NULL,
  `age` float NOT NULL,
  `ageunits` int(11) NOT NULL,
  `stature` float NOT NULL,
  `statureunits` int(11) NOT NULL,
  `ancestry` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `sourceother` text CHARACTER SET utf8 NOT NULL,
  `notes` text CHARACTER SET utf8 NOT NULL,
  `extra1` int(11) NOT NULL,
  `extra2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tier2data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `caseid` int(11) NOT NULL,
  `methodtype` int(11) NOT NULL,
  `methodid` int(11) NOT NULL,
  `featureid` int(11) DEFAULT NULL,
  `phaseid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memberid` (`memberid`,`caseid`,`methodid`,`featureid`,`phaseid`),
  KEY `methodtype` (`methodtype`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE `tier3data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tier2id` int(11) DEFAULT NULL,
  `caseid` int(11) DEFAULT NULL,
  `methodid` int(11) DEFAULT NULL,
  `methodinfoid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `method_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `methodid` int(11) NOT NULL,
  `output_data_1` varchar(100) DEFAULT NULL,
  `output_data_2` varchar(100) DEFAULT NULL,
  `output_data_1_description` varchar(100) DEFAULT NULL,
  `output_data_2_description` varchar(100) DEFAULT NULL,
  `age_range` varchar(100) DEFAULT NULL,
  `user_interaction` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8