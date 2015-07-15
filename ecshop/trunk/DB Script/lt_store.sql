drop table if exists `lt_store`;
CREATE TABLE IF NOT EXISTS `lt_store`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(256) NOT NULL,
	`platform` INTEGER NOT NULL DEFAULT 1,
	`is_active` INTEGER NOT NULL DEFAULT 1,
	`company_id` INTEGER DEFAULT 0,
	`last_listing_sync_time_utc` INT(11) NULL DEFAULT 0
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
    foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
) ENGINE = InnoDB;