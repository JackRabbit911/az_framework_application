<?php

return [
    'users' => "CREATE TABLE `users` (
        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(128) NOT NULL,
        `email` varchar(128) NOT NULL,
        `phone` decimal(11) NULL,
        `dob` date NULL,
        `sex` bool NULL,
        -- `langs` varchar(32) NOT NULL,
        `password` varchar(128) NOT NULL,
        `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);",

    'users_tokens' => "CREATE TABLE `users_tokens` (
        `token` varchar(128) COLLATE latin1_bin NOT NULL,
        `user_id` int(10) UNSIGNED NULL,
        `user_agent` varchar(32) COLLATE latin1_bin NOT NULL,
        `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY `token_user_agent` (`token`,`user_agent`),
        KEY `user_id` (`user_id`),
        KEY `last_activity` (`last_activity`),
        CONSTRAINT `users_tokens_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;",
];
