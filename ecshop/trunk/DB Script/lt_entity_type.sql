drop table if exists `lt_entity_type`;
CREATE TABLE IF NOT EXISTS `lt_entity_type`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`code` varchar(256) not null,
    `model` VARCHAR(256) NOT NULL,
	`table_name` INTEGER NOT NULL DEFAULT 1,
	`is_delete` tinyint NOT NULL DEFAULT 0
) ENGINE = InnoDB;