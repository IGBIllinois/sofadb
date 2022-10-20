ALTER TABLE methods ADD time_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
UPDATE methods SET time_created="0000-00-00 00:00:00";

ALTER TABLE method_infos ADD time_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
UPDATE method_infos SET time_created="000-00-00 00:00:00";

ALTER TABLE tier2data ADD time_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
UPDATE tier2data SET time_created="000-00-00 00:00:00";

ALTER TABLE tier3data ADD time_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
UPDATE tier3data SET time_created="000-00-00 00:00:00";

ALTER TABLE cases DROP COLUMN faancestryeuro,
        DROP COLUMN faancestryaf,
        DROP COLUMN faancestryas,
        DROP COLUMN faancestryna,
        DROP COLUMN faancestryhi,
        DROP COLUMN faancestryot;


ALTER TABLE cases CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE tier2data CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE region (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) DEFAULT '',
	PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO region(id,name) VALUES('1','U.S. Northeast');
INSERT INTO region(id,name) VALUES('2','U.S. West');
INSERT INTO region(id,name) VALUES('3','U.S. Midwest');
INSERT INTO region(id,name) VALUES('4','U.S. South');
INSERT INTO region(id,name) VALUES('5','Africa');
INSERT INTO region(id,name) VALUES('6','Asia Pacific');
INSERT INTO region(id,name) VALUES('7','Central America');
INSERT INTO region(id,name) VALUES('8','Canada');
INSERT INTO region(id,name) VALUES('9','Caribbean');
INSERT INTO region(id,name) VALUES('10','Europe');
INSERT INTO region(id,name) VALUES('11','Middle East');
INSERT INTO region(id,name) VALUES('12','South America');

UPDATE cases SET caseregion=0 WHERE caseregion IS NULL;
UPDATE members SET region=0 WHERE region IS NULL;

ALTER TABLE cases CHANGE caseregion region_id INT NOT NULL DEFAULT 0;
ALTER TABLE members CHANGE region region_id INT NOT NULL DEFAULT 0; 
UPDATE cases SET region_id=0 WHERE region_id IS NULL;
UPDATE members SET region_id=0 WHERE region_id IS NULL;

DELETE FROM cases WHERE memberid=0;

