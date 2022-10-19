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
