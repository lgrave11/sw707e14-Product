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
   address varchar(100),
   latitude float NOT NULL,
   longitude float NOT NULL
);

CREATE TABLE bicycle
(
	bicycle_id int AUTO_INCREMENT PRIMARY KEY,
	latitude float,
	longitude float
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
	salt varchar(64) NOT NULL,
	email varchar(256) NOT NULL,
	phone varchar(20) NOT NULL
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

INSERT INTO station(name, latitude, longitude) VALUES ("Banegården - Busterminal", 57.041998, 9.917633);--  1;
INSERT INTO station(name, latitude, longitude) VALUES ("Frederikstorv", 57.045095, 9.923750);-- 2;
INSERT INTO station(name, latitude, longitude) VALUES ("Gammeltorv", 57.048140, 9.920660);-- 3;
INSERT INTO station(name, latitude, longitude) VALUES ("Haraldslund", 57.054428, 9.899529);-- 4;
INSERT INTO station(name, latitude, longitude) VALUES ("Havnefronte - Jomfru Ane Parken", 57.051315, 9.920015);-- 5;
INSERT INTO station(name, latitude, longitude) VALUES ("Karolinelund", 57.043065, 9.930580);-- 6;
INSERT INTO station(name, latitude, longitude) VALUES ("Lystbådehavnen", 57.057042, 9.903899);-- 7;
INSERT INTO station(name, latitude, longitude) VALUES ("Kunsten", 57.042814, 9.907255);-- 8;
INSERT INTO station(name, latitude, longitude) VALUES ("Kjellerups Torv", 57.046231, 9.933173);-- 9;
INSERT INTO station(name, latitude, longitude) VALUES ("Nytorv", 57.048200, 9.923068); -- 10;
INSERT INTO station(name, latitude, longitude) VALUES ("Vestergade Nørresundby", 57.060048, 9.918804);-- 11;
INSERT INTO station(name, latitude, longitude) VALUES ("Utzon Centeret", 57.049805, 9.926532);-- 12;
INSERT INTO station(name, latitude, longitude) VALUES ("Vestbyens Station", 57.052838, 9.908873);-- 13;
INSERT INTO station(name, latitude, longitude) VALUES ("Algade v. Budolfi Plads", 57.047984, 9.917883);-- 14;
INSERT INTO station(name, latitude, longitude) VALUES ("Aalborg Zoo", 57.038530, 9.900142);-- 15;
INSERT INTO station(name, latitude, longitude) VALUES ("Aalborg Hallen", 57.044006, 9.912161);-- 16;
INSERT INTO station(name, latitude, longitude) VALUES ("Nørresundby Torv", 57.057703, 9.922752);-- 17;
INSERT INTO station(name, latitude, longitude) VALUES ("AAU - Sohngårdsholmsvej", 57.027387, 9.945140);-- 18;
INSERT INTO station(name, latitude, longitude) VALUES ("AU - Fibigerstræde", 57.016192, 9.977543);-- 19;
INSERT INTO station(name, latitude, longitude) VALUES ("Friis", 57.047645, 9.926114);-- 20;
INSERT INTO station(name, latitude, longitude) VALUES ("Strandvejen", 57.053474, 9.911405);-- 21;

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


-- a single user;
INSERT INTO account(username, password, salt, email, phone) VALUES("sw707e14", "83fd021a41733e76771229d059c052b02bc984528c7fd0634cc5dc566eeb0e89", "12HjN8isnE3T5ArK9wLXDOpmWxukazPCtUSqBYRc6boQlVvFfJMy74gIhGde0Z", "sw707e14@cs.aau.dk", "1345678");

DROP FUNCTION IF EXISTS levenshtein;
CREATE DEFINER=`sw707e14`@`localhost` FUNCTION `levenshtein`( s1 VARCHAR(255), s2 VARCHAR(255) ) RETURNS int(11)
    DETERMINISTIC
BEGIN
DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
DECLARE s1_char CHAR;
-- max strlen=255
DECLARE cv0, cv1 VARBINARY(256);
SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
IF s1 = s2 THEN
RETURN 0;
ELSEIF s1_len = 0 THEN
RETURN s2_len;
ELSEIF s2_len = 0 THEN
RETURN s1_len;
ELSE
WHILE j <= s2_len DO
SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
END WHILE;
WHILE i <= s1_len DO
SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
WHILE j <= s2_len DO
SET c = c + 1;
IF s1_char = SUBSTRING(s2, j, 1) THEN
SET cost = 0; ELSE SET cost = 1;
END IF;
SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
IF c > c_temp THEN SET c = c_temp; END IF;
SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
IF c > c_temp THEN
SET c = c_temp;
END IF;
SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
END WHILE;
SET cv1 = cv0, i = i + 1;
END WHILE;
END IF;
RETURN c;
END
