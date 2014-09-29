CREATE TABLE station
(
   station-id int PRIMARY KEY
);

CREATE TABLE bicycle
(
	bicycle-id int PRIMARY KEY,
	location point
);

CREATE TABLE dock
(
	dock-id int,
	station-id int,
	holds-bicycle int,
	PRIMARY KEY(dock-id, station-id),
	FOREIGN KEY(station-id) REFERENCES station(station-id),
	FOREIGN KEY(bicycle-id) REFERENCES bicycle(bicycle-id)
);

CREATE TABLE booking
(
	booking-id int PRIMARY KEY,
	start-time timestamp NOT NULL,
	start-station int NOT NULL,
	FOREIGN KEY(start-station) REFERENCES station(station-id)
);