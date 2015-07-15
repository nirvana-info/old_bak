drop table if exists `lt_product`;
CREATE TABLE IF NOT EXISTS `lt_product`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`sn` varchar(256) not null,
    `name` VARCHAR(256) NOT NULL,
	`folder_id` INTEGER NOT NULL DEFAULT 1,
	`is_real` tinyint NOT NULL DEFAULT 1,
	`is_delete` tinyint NOT NULL DEFAULT 1,
	`company_id` INTEGER DEFAULT 0,
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
    foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
	foreign key (`folder_id`) references lt_product_folder (`id`) on delete cascade on update cascade
) ENGINE = InnoDB;