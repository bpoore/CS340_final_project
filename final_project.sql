DROP TABLE beer_on_tap;
DROP TABLE beer;
DROP table brewery;
DROP table outdoor_seating;
DROP TABLE food;
DROP table taphouse;


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
	`tap_id` int,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`tap_id`) REFERENCES `taphouse` (`id`)
);

CREATE TABLE `food`
(
	`id` int NOT NULL AUTO_INCREMENT,
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

INSERT INTO taphouse (name, city, state) VALUES ('Apex', 'Portland', 'Oregon'), ('Uptown', 'Portland', 'Oregon'), ('Crux', 'Bend', 'Oregon'), ('YNot', 'Beaverton', 'Oregon'), ('Tap House', 'Seattle', 'Washington');

INSERT INTO outdoor_seating (tap_id) VALUES ((SELECT taphouse.id FROM taphouse WHERE taphouse.name='Apex'));
INSERT INTO brewery (name, city, state) VALUES ('Boneyard', 'Bend', 'Oregon'), ('Barley Brown', 'Burns', 'Oregon');
INSERT INTO beer (name, type, brewery) VALUES ('Pallet Jack', 'India Pale Ale', (SELECT brewery.id FROM brewery WHERE name='Barley Brown')), ('RPM', 'India Pale Ale', (SELECT brewery.id FROM brewery WHERE name='Boneyard'));
INSERT INTO beer_on_tap (tap_id, beer_id, pintPrice, growlerPrice) VALUES ((SELECT taphouse.id FROM taphouse WHERE name='Apex'), (SELECT beer.id FROM beer WHERE name='RPM'), 4, 13);


mysql> SELECT taphouse.name FROM taphouse 
    -> INNER JOIN beer_on_tap on taphouse.id = beer_on_tap.tap_id
    -> INNER JOIN beer on beer.id=beer_on_tap.beer_id
    -> WHERE beer.name='Pallet Jack';