DROP TABLE IF EXISTS books CASCADE;
DROP TABLE IF EXISTS dock CASCADE;
DROP TABLE IF EXISTS booking CASCADE;
DROP TABLE IF EXISTS account CASCADE;
DROP TABLE IF EXISTS station CASCADE;
DROP TABLE IF EXISTS bicycle CASCADE;

CREATE TABLE station
(
   station_id int AUTO_INCREMENT PRIMARY KEY,
   name varchar(50),
   address varchar(100)
);

CREATE TABLE bicycle
(
	bicycle_id int AUTO_INCREMENT PRIMARY KEY,
	longitude float,
	latitude float
);

CREATE TABLE dock
(
	dock_id int AUTO_INCREMENT,
	station_id int,
	holds_bicycle int,
	PRIMARY KEY(dock_id, station_id),
	FOREIGN KEY(station_id) REFERENCES station(station_id),
	FOREIGN KEY(holds_bicycle) REFERENCES bicycle(bicycle_id)
);

CREATE TABLE account
(
	username varchar(50) PRIMARY KEY,
	password varchar(64) NOT NULL,
	salt varchar(64) NOT NULL
);

CREATE TABLE booking
(
	booking_id int PRIMARY KEY,
	start_time timestamp NOT NULL,
	start_station int NOT NULL,
	password varchar(6) NOT NULL,
	for_user varchar(50) NOT NULL,
	FOREIGN KEY(start_station) REFERENCES station(station_id),
	FOREIGN KEY(for_user) REFERENCES account(username)
);

INSERT INTO station(name) VALUES ("Banegården - Busterminal");--  1;
INSERT INTO station(name) VALUES ("Frederikstorv");-- 2;
INSERT INTO station(name) VALUES ("Gammeltorv");-- 3;
INSERT INTO station(name) VALUES ("Haraldslund");-- 4;
INSERT INTO station(name) VALUES ("Havnefronte - Jomfru Ane Parken");-- 5;
INSERT INTO station(name) VALUES ("Karolinelund");-- 6;
INSERT INTO station(name) VALUES ("Lystbådehavnen");-- 7;
INSERT INTO station(name) VALUES ("Kunsten");-- 8;
INSERT INTO station(name) VALUES ("Kjellerups Torv");-- 9;
INSERT INTO station(name) VALUES ("Nytorv"); -- 10;
INSERT INTO station(name) VALUES ("Vestergade Nørresundby");-- 11;
INSERT INTO station(name) VALUES ("Utzon Centeret");-- 12;
INSERT INTO station(name) VALUES ("Vestbyens Station");-- 13;
INSERT INTO station(name) VALUES ("Algade v. Budolfi Plads");-- 14;
INSERT INTO station(name) VALUES ("Aalborg Zoo");-- 15;
INSERT INTO station(name) VALUES ("Aalborg Hallen");-- 16;
INSERT INTO station(name) VALUES ("Nørresundby Torv");-- 17;
INSERT INTO station(name) VALUES ("AAU - Sohngårdsholmsvej");-- 18;
INSERT INTO station(name) VALUES ("AU - Fibigerstræde");-- 19;
INSERT INTO station(name) VALUES ("Friis");-- 20;
INSERT INTO station(name) VALUES ("Strandvejen");-- 21;

-- Bicycles
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),(),(),();
INSERT INTO bicycle() VALUES (),(),(),(),(),(),(),();

-- 1 16 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(1, 1);
INSERT INTO dock(station_id, holds_bicycle) VALUES(1, 2);
INSERT INTO dock(station_id, holds_bicycle) VALUES(1, 3);
INSERT INTO dock(station_id, holds_bicycle) VALUES(1,4);
INSERT INTO dock(station_id, holds_bicycle) VALUES(1, 5);
INSERT INTO dock(station_id, holds_bicycle) VALUES(1, 6);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);
INSERT INTO dock(station_id) VALUES(1);

-- 2 6 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(2, 7);
INSERT INTO dock(station_id, holds_bicycle) VALUES(2, 8);
INSERT INTO dock(station_id, holds_bicycle) VALUES(2, 9);
INSERT INTO dock(station_id, holds_bicycle) VALUES(2, 10);
INSERT INTO dock(station_id, holds_bicycle) VALUES(2, 11);
INSERT INTO dock(station_id, holds_bicycle) VALUES(2, 12);

-- 3 8 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(3,13);
INSERT INTO dock(station_id, holds_bicycle) VALUES(3, 14);
INSERT INTO dock(station_id, holds_bicycle) VALUES(3, 15);
INSERT INTO dock(station_id, holds_bicycle) VALUES(3, 16);
INSERT INTO dock(station_id, holds_bicycle) VALUES(3, 17);
INSERT INTO dock(station_id) VALUES(3);
INSERT INTO dock(station_id) VALUES(3);
INSERT INTO dock(station_id) VALUES(3);

-- 4 8 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(4, 18);
INSERT INTO dock(station_id, holds_bicycle) VALUES(4, 19);
INSERT INTO dock(station_id, holds_bicycle) VALUES(4, 20);
INSERT INTO dock(station_id, holds_bicycle) VALUES(4, 21);
INSERT INTO dock(station_id, holds_bicycle) VALUES(4, 22);
INSERT INTO dock(station_id, holds_bicycle) VALUES(4, 23);
INSERT INTO dock(station_id, holds_bicycle) VALUES(4, 24);
INSERT INTO dock(station_id, holds_bicycle) VALUES(4, 25);

-- 5 8 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(5, 26);
INSERT INTO dock(station_id, holds_bicycle) VALUES(5, 27);
INSERT INTO dock(station_id) VALUES(5);
INSERT INTO dock(station_id) VALUES(5);
INSERT INTO dock(station_id) VALUES(5);
INSERT INTO dock(station_id) VALUES(5);
INSERT INTO dock(station_id) VALUES(5);
INSERT INTO dock(station_id) VALUES(5);

-- 6 6 pladser;
INSERT INTO dock(station_id) VALUES(6);
INSERT INTO dock(station_id) VALUES(6);
INSERT INTO dock(station_id) VALUES(6);
INSERT INTO dock(station_id) VALUES(6);
INSERT INTO dock(station_id) VALUES(6);
INSERT INTO dock(station_id) VALUES(6);

-- 7 8 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(7, 28);
INSERT INTO dock(station_id, holds_bicycle) VALUES(7, 29);
INSERT INTO dock(station_id, holds_bicycle) VALUES(7, 30);
INSERT INTO dock(station_id) VALUES(7);
INSERT INTO dock(station_id) VALUES(7);
INSERT INTO dock(station_id) VALUES(7);
INSERT INTO dock(station_id) VALUES(7);
INSERT INTO dock(station_id) VALUES(7);

-- 8 6 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(8, 31);
INSERT INTO dock(station_id, holds_bicycle) VALUES(8, 32);
INSERT INTO dock(station_id, holds_bicycle) VALUES(8, 33);
INSERT INTO dock(station_id, holds_bicycle) VALUES(8, 34);
INSERT INTO dock(station_id, holds_bicycle) VALUES(8, 35);
INSERT INTO dock(station_id) VALUES(8);

-- 9 8 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(9,36);
INSERT INTO dock(station_id, holds_bicycle) VALUES(9, 37);
INSERT INTO dock(station_id, holds_bicycle) VALUES(9, 38);
INSERT INTO dock(station_id, holds_bicycle) VALUES(9,39);
INSERT INTO dock(station_id, holds_bicycle) VALUES(9,40);
INSERT INTO dock(station_id, holds_bicycle) VALUES(9,41);
INSERT INTO dock(station_id) VALUES(9);
INSERT INTO dock(station_id) VALUES(9);

-- 10  20 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 42);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 43);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 44);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 45);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 46);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 47);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10,48);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 49);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 50);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 51);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 52);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 53);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 54);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 55);
INSERT INTO dock(station_id, holds_bicycle) VALUES(10, 56);
INSERT INTO dock(station_id) VALUES(10);
INSERT INTO dock(station_id) VALUES(10);
INSERT INTO dock(station_id) VALUES(10);
INSERT INTO dock(station_id) VALUES(10);
INSERT INTO dock(station_id) VALUES(10);

-- 11 - 6 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(11, 57);
INSERT INTO dock(station_id, holds_bicycle ) VALUES(11, 58);
INSERT INTO dock(station_id, holds_bicycle) VALUES(11, 59);
INSERT INTO dock(station_id, holds_bicycle) VALUES(11, 60);
INSERT INTO dock(station_id, holds_bicycle) VALUES(11,61);
INSERT INTO dock(station_id) VALUES(11);

-- 12 6 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(12,62);
INSERT INTO dock(station_id, holds_bicycle) VALUES(12,63);
INSERT INTO dock(station_id, holds_bicycle) VALUES(12,64);
INSERT INTO dock(station_id) VALUES(12);
INSERT INTO dock(station_id) VALUES(12);
INSERT INTO dock(station_id) VALUES(12);

-- 13 6 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(13,65);
INSERT INTO dock(station_id, holds_bicycle) VALUES(13,66);
INSERT INTO dock(station_id, holds_bicycle) VALUES(13,67);
INSERT INTO dock(station_id, holds_bicycle) VALUES(13, 68);
INSERT INTO dock(station_id, holds_bicycle) VALUES(13,69);
INSERT INTO dock(station_id) VALUES(13);

-- 14 16 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 70);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 71);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 72);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 73);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 74);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 75);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 76);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 77);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 78);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 79);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 80);
INSERT INTO dock(station_id, holds_bicycle) VALUES(14, 81);
INSERT INTO dock(station_id) VALUES(14);
INSERT INTO dock(station_id) VALUES(14);
INSERT INTO dock(station_id) VALUES(14);
INSERT INTO dock(station_id) VALUES(14);

-- 15 6 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(15, 82);
INSERT INTO dock(station_id, holds_bicycle) VALUES(15, 83);
INSERT INTO dock(station_id, holds_bicycle) VALUES(15, 84);
INSERT INTO dock(station_id, holds_bicycle) VALUES(15, 85);
INSERT INTO dock(station_id, holds_bicycle) VALUES(15, 86);
INSERT INTO dock(station_id) VALUES(15);

-- 16 6 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(16, 87);
INSERT INTO dock(station_id, holds_bicycle) VALUES(16, 88);
INSERT INTO dock(station_id) VALUES(16);
INSERT INTO dock(station_id) VALUES(16);
INSERT INTO dock(station_id) VALUES(16);
INSERT INTO dock(station_id) VALUES(16);

-- 17 - 8 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(17, 89);
INSERT INTO dock(station_id, holds_bicycle) VALUES(17, 90);
INSERT INTO dock(station_id, holds_bicycle) VALUES(17, 91);
INSERT INTO dock(station_id, holds_bicycle) VALUES(17,92);
INSERT INTO dock(station_id, holds_bicycle) VALUES(17,93);
INSERT INTO dock(station_id, holds_bicycle) VALUES(17,94);
INSERT INTO dock(station_id) VALUES(17);
INSERT INTO dock(station_id) VALUES(17);

-- 18 8 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(18, 95);
INSERT INTO dock(station_id, holds_bicycle) VALUES(18, 96);
INSERT INTO dock(station_id, holds_bicycle) VALUES(18, 97);
INSERT INTO dock(station_id, holds_bicycle) VALUES(18, 98);
INSERT INTO dock(station_id, holds_bicycle) VALUES(18, 99);
INSERT INTO dock(station_id) VALUES(18);
INSERT INTO dock(station_id) VALUES(18);
INSERT INTO dock(station_id) VALUES(18);

-- 19 10 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(19, 100);
INSERT INTO dock(station_id) VALUES(19);
INSERT INTO dock(station_id) VALUES(19);
INSERT INTO dock(station_id) VALUES(19);
INSERT INTO dock(station_id) VALUES(19);
INSERT INTO dock(station_id) VALUES(19);
INSERT INTO dock(station_id) VALUES(19);
INSERT INTO dock(station_id) VALUES(19);
INSERT INTO dock(station_id) VALUES(19);
INSERT INTO dock(station_id) VALUES(19);

-- 20 6 pladser;
INSERT INTO dock(station_id, holds_bicycle) VALUES(20, 101);
INSERT INTO dock(station_id, holds_bicycle) VALUES(20, 102);
INSERT INTO dock(station_id, holds_bicycle) VALUES(20, 103);
INSERT INTO dock(station_id, holds_bicycle) VALUES(20, 104);
INSERT INTO dock(station_id, holds_bicycle) VALUES(20, 105);
INSERT INTO dock(station_id, holds_bicycle) VALUES(20, 106);

-- 21 6 pladser;
INSERT INTO dock(station_id) VALUES(21);
INSERT INTO dock(station_id) VALUES(21);
INSERT INTO dock(station_id) VALUES(21);
INSERT INTO dock(station_id) VALUES(21);
INSERT INTO dock(station_id) VALUES(21);
INSERT INTO dock(station_id) VALUES(21);