SET GLOBAL event_scheduler = ON;

DROP TABLE contact;
ALTER TABLE members MODIFY lastlogin DATETIME DEFAULT NULL;
ALTER TABLE members MODIFY dateregistered DATETIME DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE password_reset MODIFY expires DATETIME DEFAULT NULL;
CREATE DEFINER='root'@'localhost' EVENT password_reset
        ON SCHEDULE EVERY 1 HOUR
        STARTS '2022-01-01 00:00:00'
        ON COMPLETION PRESERVE ENABLE
        COMMENT 'Clears out expired password_reset requests'
        DO
                DELETE FROM password_reset WHERE expires < CURRENT_TIMESTAMP;
