
CREATE TABLE `cases` (
  `id` int(11) UNSIGNED NOT NULL,
  `casenumber` varchar(100) CHARACTER SET utf8 NOT NULL,
  `caseyear` int(11) UNSIGNED DEFAULT NULL,
  `casename` varchar(100) CHARACTER SET utf8 NOT NULL,
  `caseagency` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `memberid` int(11) UNSIGNED NOT NULL,
  `fasex` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `faage` float UNSIGNED DEFAULT NULL,
  `faage2` float UNSIGNED DEFAULT NULL,
  `faageunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `faageunits2` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `faancestryeuro` tinyint(11) UNSIGNED DEFAULT NULL,
  `faancestryaf` tinyint(11) UNSIGNED DEFAULT NULL,
  `faancestryas` text CHARACTER SET utf8,
  `faancestryna` tinyint(11) UNSIGNED DEFAULT NULL,
  `faancestryhi` int(11) UNSIGNED DEFAULT NULL,
  `faancestryot` int(11) UNSIGNED DEFAULT NULL,
  `faancestryottext` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fastature` float UNSIGNED DEFAULT NULL,
  `fastature2` float UNSIGNED DEFAULT NULL,
  `fastatureunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idsex` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idage` int(11) UNSIGNED DEFAULT NULL,
  `idageunits` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `idraceas` tinyint(11) UNSIGNED DEFAULT NULL,
  `idraceaf` tinyint(11) UNSIGNED DEFAULT NULL,
  `idracewh` tinyint(11) UNSIGNED DEFAULT NULL,
  `idracehi` tinyint(11) UNSIGNED DEFAULT NULL,
  `idracena` tinyint(11) UNSIGNED DEFAULT NULL,
  `idraceot` tinyint(11) UNSIGNED DEFAULT NULL,
  `idraceottext` text CHARACTER SET utf8,
  `idancaddtext` text CHARACTER SET utf32 COLLATE utf32_bin,
  `idstature` float UNSIGNED DEFAULT NULL,
  `idstatureunits` text CHARACTER SET utf8,
  `idsource` text CHARACTER SET utf8,
  `known_none` tinyint(1) UNSIGNED DEFAULT NULL,
  `known_sex` tinyint(1) UNSIGNED DEFAULT NULL,
  `known_age` tinyint(1) UNSIGNED DEFAULT NULL,
  `known_ancestry` tinyint(1) UNSIGNED DEFAULT NULL,
  `known_stature` tinyint(1) UNSIGNED DEFAULT NULL,
  `known_unable_to_determine` tinyint(1) UNSIGNED DEFAULT NULL,
  `nummethods` int(11) DEFAULT NULL,
  `casenotes` text CHARACTER SET utf8,
  `datestarted` date DEFAULT NULL,
  `datemodified` date DEFAULT NULL,
  `datesubmitted` date DEFAULT NULL,
  `submissionstatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `feature` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `input_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `input_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `pwd` text NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `degreeyear` int(11) UNSIGNED NOT NULL,
  `fieldofstudy` varchar(100) CHARACTER SET latin1 NOT NULL,
  `aafsstatus` int(11) UNSIGNED NOT NULL,
  `institution` varchar(100) NOT NULL,
  `yearsexperience` int(11) UNSIGNED NOT NULL,
  `caseperyear` int(11) UNSIGNED NOT NULL,
  `region` int(11) UNSIGNED NOT NULL,
  `mailaddress` varchar(100) NOT NULL,
  `mailaddress2` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `city` varchar(50) CHARACTER SET latin1 NOT NULL,
  `state` varchar(25) CHARACTER SET latin1 NOT NULL,
  `zip` varchar(10) CHARACTER SET latin1 NOT NULL,
  `phone` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `lastlogin` date DEFAULT NULL,
  `permissionstatus` int(11) UNSIGNED NOT NULL,
  `casessubmitted` int(11) UNSIGNED NOT NULL,
  `caseswithdrawn` int(11) UNSIGNED NOT NULL,
  `dateregistered` date NOT NULL,
  `totalcases` int(11) UNSIGNED NOT NULL,
  `affiliation` varchar(100) DEFAULT NULL,
  `sponsor` varchar(100) DEFAULT NULL,
  `sponsor_email` varchar(100) DEFAULT NULL,
  `sponsor_affiliation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `methods` (
  `id` int(11) UNSIGNED NOT NULL,
  `methodname` varchar(100) CHARACTER SET latin1 NOT NULL,
  `methodtype` varchar(100) CHARACTER SET latin1 NOT NULL,
  `methodtypenum` int(11) NOT NULL,
  `measurementtype` varchar(100) CHARACTER SET latin1 NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `instructions` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `methodinfotype` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_infos` (
  `id` int(10) UNSIGNED NOT NULL,
  `methodid` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `header` varchar(100) DEFAULT NULL,
  `option_header` varchar(100) DEFAULT NULL,
  `input_type` int(10) UNSIGNED DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_info_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `method_infos_id` int(10) UNSIGNED DEFAULT NULL,
  `value` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `method_info_reference_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `method_infos_id` int(10) UNSIGNED DEFAULT NULL,
  `reference_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `password_reset` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `selector` char(16) DEFAULT NULL,
  `token` char(64) DEFAULT NULL,
  `expires` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reference` (
  `id` int(11) NOT NULL,
  `reference_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reference_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `tier2id` int(10) UNSIGNED DEFAULT NULL,
  `method_info_id` int(10) UNSIGNED DEFAULT NULL,
  `reference_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tier2data` (
  `id` int(11) UNSIGNED NOT NULL,
  `memberid` int(11) UNSIGNED NOT NULL,
  `caseid` int(11) UNSIGNED NOT NULL,
  `methodtype` int(11) UNSIGNED NOT NULL,
  `methodid` int(11) UNSIGNED NOT NULL,
  `estimated_outcome_1` varchar(100) DEFAULT NULL,
  `estimated_outcome_2` varchar(100) DEFAULT NULL,
  `estimated_outcome_units` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tier3data` (
  `id` int(11) NOT NULL,
  `tier2id` int(11) DEFAULT NULL,
  `value` text,
  `method_info_option_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memberid` (`memberid`),
  ADD KEY `submissionstatus` (`submissionstatus`);

ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `feature`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `input_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `methods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `method_infos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `method_info_options`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `method_info_reference_list`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reference`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reference_data`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tier2data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memberid` (`memberid`,`caseid`,`methodid`),
  ADD KEY `methodtype` (`methodtype`);

ALTER TABLE `tier3data`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `cases`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `input_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `methods`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `method_infos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `method_info_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `method_info_reference_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `password_reset`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reference_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tier2data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tier3data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


