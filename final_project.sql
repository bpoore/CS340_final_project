CREATE TABLE `taphouse` 
(
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`street_address` varchar(255),
	`city` varchar(255),
	`state` varchar(255),
	`zip` int,
	`open` time,
	`close` time, 
	PRIMARY KEY(`id`),
	CONSTRAINT unique_location UNIQUE (`name`, `street_address`, `zip`)
);

CREATE TABLE `brewery` 
(
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`city` varchar(255),
	`state` varchar(255),
	PRIMARY KEY (`id`)
);


CREATE TABLE `outdoor_seating`
(
	`id` int NOT NULL AUTO_INCREMENT,
	`tap_id` int UNIQUE,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`tap_id`) REFERENCES `taphouse` (`id`)
);

CREATE TABLE `food`
(
	`id` int NOT NULL AUTO_INCREMENT,
	`food_type` varchar(255),
	`tap_id` int,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`tap_id`) REFERENCES `taphouse` (`id`)
);

CREATE TABLE `beer`
(
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255),
	`type` varchar(255),
	`alc_bv` int,
	`brewery` int,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`brewery`) REFERENCES `brewery` (`id`)
);

CREATE TABLE `beer_on_tap` 
(
	`id` int NOT NULL AUTO_INCREMENT,
	`tap_id` int NOT NULL,
	`beer_id` int NOT NULL,
	`pintPrice` int,
	`growlerPrice` int,
	PRIMARY KEY(`id`), 
	FOREIGN KEY(`tap_id`) REFERENCES `taphouse` (`id`),
	FOREIGN KEY(`beer_id`) REFERENCES `beer` (`id`)
);

