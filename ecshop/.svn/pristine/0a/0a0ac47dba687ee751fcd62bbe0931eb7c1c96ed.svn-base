drop table if exists `lt_user`;
CREATE TABLE IF NOT EXISTS `lt_user`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `email` VARCHAR(256) NOT NULL,
    `username` VARCHAR(256) NOT NULL,
    `password` VARCHAR(256) NOT NULL,
	`company_id` INTEGER DEFAULT 0,
    `last_login_time_utc` INTEGER DEFAULT 0,
	`last_login_ip` VARCHAR(128),
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
	foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
) ENGINE = InnoDB;

