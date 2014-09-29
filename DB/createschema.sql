DROP TABLE IF EXISTS dock CASCADE;
DROP TABLE IF EXISTS booking CASCADE;
DROP TABLE IF EXISTS station CASCADE;
DROP TABLE IF EXISTS bicycle CASCADE;

CREATE TABLE station
(
   station_id int AUTO_INCREMENT PRIMARY KEY,
   name varchar(50),
   adresse varchar(100)
);

CREATE TABLE bicycle
(
	bicycle_id int PRIMARY KEY,
	longitute int,
	latitude int
);

CREATE TABLE dock
(
	dock_id int,
	station_id int,
	holds_bicycle int,
	PRIMARY KEY(dock_id, station_id),
	FOREIGN KEY(station_id) REFERENCES station(station_id),
	FOREIGN KEY(holds_bicycle) REFERENCES bicycle(bicycle_id)
);

CREATE TABLE booking
(
	booking_id int PRIMARY KEY,
	start_time timestamp NOT NULL,
	start_station int NOT NULL,
	password varchar(6) NOT NULL,
	FOREIGN KEY(start_station) REFERENCES station(station_id)
);

INSERT INTO station(name) VALUES ("kennedy Station");

INSERT INTO bicycle(bicycle_id) VALUES (1);
INSERT INTO bicycle(bicycle_id) VALUES (2);
INSERT INTO bicycle(bicycle_id) VALUES (3);

INSERT INTO dock(dock_id, station_id, holds_bicycle) VALUES(1, 1, 1);
INSERT INTO dock(dock_id, station_id, holds_bicycle) VALUES(2, 1, 2);
INSERT INTO dock(dock_id, station_id) VALUES(3, 1);

SELECT COUNT(holds_bicycle) FROM dock WHERE station_id = 1;