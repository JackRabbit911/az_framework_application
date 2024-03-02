<?php

class _2023_12_25_13_23_02_create_table_queues
{
    public function up()
    {
        return "CREATE TABLE `queues` (
            `id` char(13) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
            `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `name` varchar(64) NOT NULL,
            `job` varchar(255) DEFAULT NULL,
            `data` json DEFAULT NULL,
            `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `status` (`status`),
            KEY `created` (`created`),
            KEY `name` (`name`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    }

    public function down()
    {
        return "DROP TABLE `queues`";
    }
}
