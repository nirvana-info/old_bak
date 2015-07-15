drop table if exists `lt_product_folder`;
CREATE TABLE IF NOT EXISTS `lt_product_folder`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(256) NOT NULL,
	`parent_id` INTEGER DEFAULT 0,
	`is_delete` tinyint NOT NULL DEFAULT 0,
	`company_id` INTEGER DEFAULT 0,
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
    foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
) ENGINE = InnoDB;