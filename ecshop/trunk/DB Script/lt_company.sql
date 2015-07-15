drop table if exists `lt_company`;
CREATE TABLE IF NOT EXISTS `lt_company`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(256) NOT NULL,
	`phone` VARCHAR(256),
	`country` VARCHAR(256),
	`owner_id` INTEGER DEFAULT 0,
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER
) ENGINE = InnoDB;
