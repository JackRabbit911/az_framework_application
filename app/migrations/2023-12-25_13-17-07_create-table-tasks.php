<?php

class _2023_12_25_13_17_07_create_table_tasks
{
    public function up()
    {
        return "CREATE TABLE `tasks` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
            `expression` varchar(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
            `next_time` timestamp NULL DEFAULT NULL,
            `worker` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
            `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
            `timeout` smallint(4) unsigned DEFAULT '60',
            `wait` tinyint(1) unsigned DEFAULT '0',
            `data` json DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `next_time` (`next_time`),
            KEY `status` (`status`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    }

    public function down()
    {
        return "DROP TABLE `tasks`";
    }
}
