CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(50) NOT NULL,
 `email` varchar(100) NOT NULL,
 `password` varchar(255) NOT NULL,
 `nickname` varchar(50) NOT NULL,
 `name` varchar(100) NOT NULL,
 `birthdate` date NOT NULL,
 `gender` enum('Male','Female','Other') NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`),
 UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_c

ALTER TABLE `users` ADD `profile_image` BLOB NULL DEFAULT NULL AFTER `gender`;
ALTER TABLE `users` ADD `comment` VARCHAR(255) NULL DEFAULT NULL AFTER `profile_image`;
