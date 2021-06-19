CREATE TABLE `user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` varchar(255) NOT NULL UNIQUE,
	`email` varchar(255) NOT NULL UNIQUE,
	`password_hash` varchar(60) NOT NULL,
	`auth_key` varchar(32) NOT NULL,
	`unconfirmed_email` varchar(255) NOT NULL,
	`registration_ip` varchar(45),
	`flags` INT NOT NULL DEFAULT '0',
	`confirmed_at` INT NOT NULL,
	`blocked_at` INT NOT NULL,
	`updated_at` INT NOT NULL,
	`created_at` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `role` (
	`id` INT NOT NULL,
	`role_name` varchar(255) NOT NULL,
	`user_id` INT NOT NULL
);

CREATE TABLE `decaissement` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`date_demande` DATETIME NOT NULL UNIQUE,
	`montant` DECIMAL NOT NULL,
	`motif` varchar(255) NOT NULL,
	`piece_jointe` varchar(255) NOT NULL,
	`status` INT NOT NULL,
	`user_id` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `transaction` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`date_transaction` DATETIME NOT NULL,
	`montant` DECIMAL NOT NULL,
	`decaissment_id` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `grade` (
	`user_id` INT NOT NULL,
	`role_id` INT NOT NULL,
	`niveau` varchar(255) NOT NULL,
	`montant` DECIMAL NOT NULL
);

CREATE TABLE `profil` (
	`user_id` INT NOT NULL,
	`name` varchar(255) NOT NULL,
	`public_email` varchar(255) NOT NULL,
	`gravatar_email` varchar(255) NOT NULL,
	`gravatar_id` varchar(32) NOT NULL,
	`location` varchar(255) NOT NULL,
	`website` varchar(255) NOT NULL,
	`timezone` varchar(40) NOT NULL,
	`bio` TEXT NOT NULL
);

ALTER TABLE `role` ADD CONSTRAINT `role_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `decaissement` ADD CONSTRAINT `decaissement_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `transaction` ADD CONSTRAINT `transaction_fk0` FOREIGN KEY (`decaissment_id`) REFERENCES `decaissement`(`id`);

ALTER TABLE `grade` ADD CONSTRAINT `grade_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

-- Error MySQL
-- ALTER TABLE `grade` ADD CONSTRAINT `grade_fk1` FOREIGN KEY (`role_id`) REFERENCES `role`(`id`);

ALTER TABLE `profil` ADD CONSTRAINT `profil_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
