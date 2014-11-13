DROP TABLE IF EXISTS historylocationbicycle CASCADE;
DROP TABLE IF EXISTS historyusagestation CASCADE;
DROP TABLE IF EXISTS historyusagebicycle;
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
   longitude float NOT NULL,
   ipaddress varchar(15) NOT NULL,
   deleted bool DEFAULT false NOT NULL
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
	FOREIGN KEY(station_id) REFERENCES station(station_id) ON DELETE CASCADE,
	FOREIGN KEY(holds_bicycle) REFERENCES bicycle(bicycle_id)
);

CREATE TABLE account
(
	username varchar(50) PRIMARY KEY,
	password varchar(255),
	email varchar(255) NOT NULL UNIQUE,
	phone varchar(20) NOT NULL,
    token varchar(255),
    reset_time bigint,
	role varchar(7) DEFAULT "user"
);

CREATE TABLE booking
(
	booking_id int PRIMARY KEY AUTO_INCREMENT,
	start_time bigint NOT NULL,
	start_station int NOT NULL,
	password int(6),
	for_user varchar(50) NOT NULL,
	used_bicycle int NULL,
	FOREIGN KEY(start_station) REFERENCES station(station_id),
	FOREIGN KEY(for_user) REFERENCES account(username),
	FOREIGN KEY(used_bicycle) REFERENCES bicycle(bicycle_id)
);

CREATE TABLE historylocationbicycle
(
	bicycle_id int,
	timeforlocation timestamp,
	latitude float NOT NULL,
	longitude float NOT NULL,
	PRIMARY KEY(bicycle_id,timeforlocation),
	FOREIGN KEY(bicycle_id) REFERENCES bicycle(bicycle_id)
);

CREATE TABLE historyusagebicycle 
(
  id int PRIMARY KEY AUTO_INCREMENT,
  bicycle_id int NOT NULL,
  start_station int DEFAULT NULL,
  start_time bigint NOT NULL,
  end_station int DEFAULT NULL,
  end_time bigint NULL DEFAULT NULL,
  booking_id int DEFAULT NULL,
  FOREIGN KEY (bicycle_id) REFERENCES bicycle(bicycle_id)
);

CREATE TABLE historyusagestation
(
    id int PRIMARY KEY AUTO_INCREMENT,
    station_id int NOT NULL,
    time bigint NOT NULL,
    num_bicycles INT NOT NULL,
    FOREIGN KEY (station_id) REFERENCES station(station_id)
);

INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Banegården - Busterminal", 57.041998, 9.917633, "127.0.0.1");--  1;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Frederikstorv", 57.045095, 9.923750, "127.0.0.1");-- 2;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Gammeltorv", 57.048140, 9.920660, "127.0.0.1");-- 3;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Haraldslund", 57.054428, 9.899529, "127.0.0.1");-- 4;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Havnefronten - Jomfru Ane Parken", 57.051315, 9.920015, "127.0.0.1");-- 5;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Karolinelund", 57.043065, 9.930580, "127.0.0.1");-- 6;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Lystbådehavnen", 57.057042, 9.903899, "127.0.0.1");-- 7;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Kunsten", 57.042814, 9.907255, "127.0.0.1");-- 8;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Kjellerups Torv", 57.046231, 9.933173, "127.0.0.1");-- 9;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Nytorv", 57.048200, 9.923068, "127.0.0.1"); -- 10;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Vestergade Nørresundby", 57.060048, 9.918804, "127.0.0.1");-- 11;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Utzon Centeret", 57.049805, 9.926532, "127.0.0.1");-- 12;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Vestbyens Station", 57.052838, 9.908873, "127.0.0.1");-- 13;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Algade v. Budolfi Plads", 57.047984, 9.917883, "127.0.0.1");-- 14;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Aalborg Zoo", 57.038530, 9.900142, "127.0.0.1");-- 15;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Aalborg Hallen", 57.044006, 9.912161, "127.0.0.1");-- 16;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Nørresundby Torv", 57.057703, 9.922752, "127.0.0.1");-- 17;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("AAU - Sohngårdsholmsvej", 57.027387, 9.945140, "127.0.0.1");-- 18;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("AU - Fibigerstræde", 57.016192, 9.977543, "127.0.0.1");-- 19;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Friis", 57.047645, 9.926114, "127.0.0.1");-- 20;
INSERT INTO station(name, latitude, longitude, ipaddress) VALUES ("Strandvejen", 57.053474, 9.911405, "127.0.0.1");-- 21;


INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (1, 6, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (2, 6, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (3, 5, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (4, 8, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (5, 2, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (6, 0, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (7, 3, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (8, 5, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (9, 6, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (10, 15, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (11, 5, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (12, 3, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (13, 5, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (14, 12, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (15, 5, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (16, 2, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (17, 6, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (18, 5, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (19, 1, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (20, 6, UNIX_TIMESTAMP());
INSERT INTO historyusagestation(station_id, num_bicycles, time) VALUES (21, 0, UNIX_TIMESTAMP());

-- Bicycles
INSERT INTO `bicycle` (`bicycle_id`, `longitude`, `latitude`) VALUES
(1, 9.91763, 57.042),
(2, 9.91763, 57.042),
(3, 9.91763, 57.042),
(4, 9.91763, 57.042),
(5, 9.91763, 57.042),
(6, 9.91763, 57.042),
(7, 9.92375, 57.0451),
(8, 9.92375, 57.0451),
(9, 9.92375, 57.0451),
(10, 9.92375, 57.0451),
(11, 9.92375, 57.0451),
(12, 9.92375, 57.0451),
(13, 9.92066, 57.0481),
(14, 9.92066, 57.0481),
(15, 9.92066, 57.0481),
(16, 9.92066, 57.0481),
(17, 9.92066, 57.0481),
(18, 9.89953, 57.0544),
(19, 9.89953, 57.0544),
(20, 9.89953, 57.0544),
(21, 9.89953, 57.0544),
(22, 9.89953, 57.0544),
(23, 9.89953, 57.0544),
(24, 9.89953, 57.0544),
(25, 9.89953, 57.0544),
(26, 9.92002, 57.0513),
(27, 9.92002, 57.0513),
(28, 9.9039, 57.057),
(29, 9.9039, 57.057),
(30, 9.9039, 57.057),
(31, 9.90726, 57.0428),
(32, 9.90726, 57.0428),
(33, 9.90726, 57.0428),
(34, 9.90726, 57.0428),
(35, 9.90726, 57.0428),
(36, 9.93317, 57.0462),
(37, 9.93317, 57.0462),
(38, 9.93317, 57.0462),
(39, 9.93317, 57.0462),
(40, 9.93317, 57.0462),
(41, 9.93317, 57.0462),
(42, 9.92307, 57.0482),
(43, 9.92307, 57.0482),
(44, 9.92307, 57.0482),
(45, 9.92307, 57.0482),
(46, 9.92307, 57.0482),
(47, 9.92307, 57.0482),
(48, 9.92307, 57.0482),
(49, 9.92307, 57.0482),
(50, 9.92307, 57.0482),
(51, 9.92307, 57.0482),
(52, 9.92307, 57.0482),
(53, 9.92307, 57.0482),
(54, 9.92307, 57.0482),
(55, 9.92307, 57.0482),
(56, 9.92307, 57.0482),
(57, 9.9188, 57.06),
(58, 9.9188, 57.06),
(59, 9.9188, 57.06),
(60, 9.9188, 57.06),
(61, 9.9188, 57.06),
(62, 9.92653, 57.0498),
(63, 9.92653, 57.0498),
(64, 9.92653, 57.0498),
(65, 9.90887, 57.0528),
(66, 9.90887, 57.0528),
(67, 9.90887, 57.0528),
(68, 9.90887, 57.0528),
(69, 9.90887, 57.0528),
(70, 9.91788, 57.048),
(71, 9.91788, 57.048),
(72, 9.91788, 57.048),
(73, 9.91788, 57.048),
(74, 9.91788, 57.048),
(75, 9.91788, 57.048),
(76, 9.91788, 57.048),
(77, 9.91788, 57.048),
(78, 9.91788, 57.048),
(79, 9.91788, 57.048),
(80, 9.91788, 57.048),
(81, 9.91788, 57.048),
(82, 9.90014, 57.0385),
(83, 9.90014, 57.0385),
(84, 9.90014, 57.0385),
(85, 9.90014, 57.0385),
(86, 9.90014, 57.0385),
(87, 9.91216, 57.044),
(88, 9.91216, 57.044),
(89, 9.92275, 57.0577),
(90, 9.92275, 57.0577),
(91, 9.92275, 57.0577),
(92, 9.92275, 57.0577),
(93, 9.92275, 57.0577),
(94, 9.92275, 57.0577),
(95, 9.94514, 57.0274),
(96, 9.94514, 57.0274),
(97, 9.94514, 57.0274),
(98, 9.94514, 57.0274),
(99, 9.94514, 57.0274),
(100, 9.97754, 57.0162),
(101, 9.92611, 57.0476),
(102, 9.92611, 57.0476),
(103, 9.92611, 57.0476),
(104, 9.92611, 57.0476),
(105, 9.92611, 57.0476),
(106, 9.92611, 57.0476),
(107, NULL, NULL),
(108, NULL, NULL),
(109, NULL, NULL),
(110, NULL, NULL),
(111, NULL, NULL),
(112, NULL, NULL),
(113, NULL, NULL),
(114, NULL, NULL),
(115, NULL, NULL),
(116, NULL, NULL),
(117, NULL, NULL),
(118, NULL, NULL),
(119, NULL, NULL),
(120, NULL, NULL),
(121, NULL, NULL),
(122, NULL, NULL),
(123, NULL, NULL),
(124, NULL, NULL),
(125, NULL, NULL),
(126, NULL, NULL),
(127, NULL, NULL),
(128, NULL, NULL),
(129, NULL, NULL),
(130, NULL, NULL),
(131, NULL, NULL),
(132, NULL, NULL),
(133, NULL, NULL),
(134, NULL, NULL),
(135, NULL, NULL),
(136, NULL, NULL),
(137, NULL, NULL),
(138, NULL, NULL),
(139, NULL, NULL),
(140, NULL, NULL),
(141, NULL, NULL),
(142, NULL, NULL),
(143, NULL, NULL),
(144, NULL, NULL),
(145, NULL, NULL),
(146, NULL, NULL),
(147, NULL, NULL),
(148, NULL, NULL),
(149, NULL, NULL),
(150, NULL, NULL),
(151, NULL, NULL),
(152, NULL, NULL),
(153, NULL, NULL),
(154, NULL, NULL),
(155, NULL, NULL),
(156, NULL, NULL),
(157, NULL, NULL),
(158, NULL, NULL),
(159, NULL, NULL),
(160, NULL, NULL),
(161, NULL, NULL),
(162, NULL, NULL),
(163, NULL, NULL),
(164, NULL, NULL),
(165, NULL, NULL),
(166, NULL, NULL),
(167, NULL, NULL),
(168, NULL, NULL),
(169, NULL, NULL),
(170, NULL, NULL),
(171, NULL, NULL),
(172, NULL, NULL),
(173, NULL, NULL),
(174, NULL, NULL),
(175, NULL, NULL),
(176, NULL, NULL),
(177, NULL, NULL),
(178, NULL, NULL);

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


-- a single admin user;
INSERT INTO account(username, password, email, phone, role) VALUES("sw707e14", "$2y$10$gnS5CuXtiCkmSZfqiSXO7OnrDBxazIbvCUzQXtVpNgWcyy8FdLxYK", "sw707e14@cs.aau.dk", "1345678", "admin");

-- some bookings
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1206887716, 5,665932,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1208120578, 5,678523,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1226771992, 5,129745,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1270666908, 5,134521,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1456989150, 5,546098,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1412838613, 5,137986,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1424095263, 5,567923,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1425606759, 5,236789,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1478425556, 5,567932,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1543419251, 5,233578,"sw707e14");
INSERT INTO booking(start_time, start_station,password,for_user) VALUES (1594571207, 5,113475,"sw707e14");

INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (140, 21, 1386586923, 13, 1386590523, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (96, 11, 213930760, 16, 213934360, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (10, 8, 1147210051, 9, 1147213651, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (39, 13, 1060319794, 4, 1060323394, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (138, 2, 1003749569, 14, 1003753169, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (8, 4, 1353718115, 21, 1353721715, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (76, 5, 100089866, 4, 100093466, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (125, 7, 924903378, 15, 924906978, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (43, 4, 431332458, 5, 431336058, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (52, 19, 309863138, 9, 309866738, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (146, 5, 1277955142, 7, 1277958742, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (124, 18, 1170812428, 18, 1170816028, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (149, 21, 398079074, 13, 398082674, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (70, 15, 1359314854, 1, 1359318454, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (74, 14, 1335422668, 6, 1335426268, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (129, 12, 330568356, 14, 330571956, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (117, 13, 678140194, 4, 678143794, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (31, 3, 1024314564, 11, 1024318164, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (62, 9, 365839295, 21, 365842895, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (21, 5, 925093415, 14, 925097015, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (132, 20, 530974844, 9, 530978444, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (127, 1, 311723269, 15, 311726869, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (131, 20, 1113292258, 19, 1113295858, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (3, 6, 1178678772, 21, 1178682372, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (21, 13, 1005602977, 19, 1005606577, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (101, 13, 1401481070, 10, 1401484670, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (48, 11, 460018312, 11, 460021912, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (105, 15, 88805735, 7, 88809335, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (1, 5, 1002738178, 18, 1002741778, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (45, 9, 136469990, 3, 136473590, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (117, 13, 303862340, 17, 303865940, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (121, 12, 151586414, 14, 151590014, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (42, 3, 1315371504, 6, 1315375104, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (99, 17, 1201124647, 8, 1201128247, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (89, 8, 497478580, 9, 497482180, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (67, 3, 1163802960, 21, 1163806560, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (83, 9, 210844505, 4, 210848105, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (103, 17, 418724273, 6, 418727873, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (50, 14, 804287044, 1, 804290644, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (49, 19, 714225062, 2, 714228662, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (100, 6, 609872833, 7, 609876433, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (87, 11, 442847355, 11, 442850955, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (37, 21, 569277063, 12, 569280663, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (147, 20, 228608083, 13, 228611683, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (57, 1, 1176344589, 20, 1176348189, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (139, 19, 156568712, 17, 156572312, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (63, 15, 387059653, 14, 387063253, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (31, 2, 169477454, 16, 169481054, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (14, 17, 928011890, 15, 928015490, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (139, 20, 1286540782, 9, 1286544382, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (36, 5, 110002556, 7, 110006156, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (48, 17, 968398461, 9, 968402061, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (67, 18, 1244990557, 20, 1244994157, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (9, 7, 935605368, 10, 935608968, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (69, 19, 840393993, 8, 840397593, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (42, 2, 432200281, 16, 432203881, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (49, 14, 1414391017, 13, 1414394617, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (113, 14, 1303629115, 15, 1303632715, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (33, 10, 418046350, 7, 418049950, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (91, 11, 1228438740, 3, 1228442340, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (62, 18, 846266867, 19, 846270467, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (67, 11, 971848404, 21, 971852004, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (22, 20, 962456452, 9, 962460052, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (86, 8, 505264781, 9, 505268381, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (56, 12, 1055256492, 21, 1055260092, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (56, 6, 492812106, 8, 492815706, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (144, 7, 629227887, 18, 629231487, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (10, 18, 786745828, 16, 786749428, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (145, 19, 768187226, 18, 768190826, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (22, 13, 736367342, 3, 736370942, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (118, 12, 132262820, 2, 132266420, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (103, 10, 407511754, 19, 407515354, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (94, 1, 906861564, 9, 906865164, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (25, 13, 1271146940, 2, 1271150540, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (93, 6, 202442911, 5, 202446511, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (60, 19, 272597604, 11, 272601204, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (72, 21, 1072740714, 3, 1072744314, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (144, 20, 1314796767, 19, 1314800367, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (58, 11, 1375850602, 9, 1375854202, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (76, 21, 1229522785, 13, 1229526385, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (8, 8, 226556413, 8, 226560013, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (43, 4, 701091421, 17, 701095021, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (21, 9, 1211607412, 2, 1211611012, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (119, 10, 1399560608, 3, 1399564208, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (1, 7, 426208802, 14, 426212402, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (113, 1, 411821584, 12, 411825184, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (100, 14, 682090202, 4, 682093802, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (57, 3, 370929122, 5, 370932722, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (95, 21, 1121781957, 13, 1121785557, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (113, 3, 400752868, 7, 400756468, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (12, 3, 247975703, 20, 247979303, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (36, 16, 1310836611, 11, 1310840211, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (112, 18, 792611526, 3, 792615126, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (89, 21, 1150521224, 19, 1150524824, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (16, 17, 770038054, 10, 770041654, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (78, 4, 1033935963, 10, 1033939563, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (136, 17, 1075331508, 18, 1075335108, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (6, 16, 85154453, 15, 85158053, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (131, 9, 838478845, 19, 838482445, 10);
INSERT INTO historyusagebicycle(bicycle_id, start_station, start_time, end_station, end_time, booking_id) VALUES (81, 7, 879025384, 18, 879028984, 10);



DELIMITER $$
DROP FUNCTION IF EXISTS LEVENSHTEIN $$
CREATE FUNCTION LEVENSHTEIN(s1 VARCHAR(255) CHARACTER SET utf8, s2 VARCHAR(255) CHARACTER SET utf8)
  RETURNS INT
  DETERMINISTIC
  BEGIN
    DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
    DECLARE s1_char CHAR CHARACTER SET utf8;
    -- max strlen=255 for this function
    DECLARE cv0, cv1 VARBINARY(256);

    SET s1_len = CHAR_LENGTH(s1),
        s2_len = CHAR_LENGTH(s2),
        cv1 = 0x00,
        j = 1,
        i = 1,
        c = 0;

    IF (s1 = s2) THEN
      RETURN (0);
    ELSEIF (s1_len = 0) THEN
      RETURN (s2_len);
    ELSEIF (s2_len = 0) THEN
      RETURN (s1_len);
    END IF;

    WHILE (j <= s2_len) DO
      SET cv1 = CONCAT(cv1, CHAR(j)),
          j = j + 1;
    END WHILE;

    WHILE (i <= s1_len) DO
      SET s1_char = SUBSTRING(s1, i, 1),
          c = i,
          cv0 = CHAR(i),
          j = 1;

      WHILE (j <= s2_len) DO
        SET c = c + 1,
            cost = IF(s1_char = SUBSTRING(s2, j, 1), 0, 1);

        SET c_temp = ORD(SUBSTRING(cv1, j, 1)) + cost;
        IF (c > c_temp) THEN
          SET c = c_temp;
        END IF;

        SET c_temp = ORD(SUBSTRING(cv1, j+1, 1)) + 1;
        IF (c > c_temp) THEN
          SET c = c_temp;
        END IF;

        SET cv0 = CONCAT(cv0, CHAR(c)),
            j = j + 1;
      END WHILE;

      SET cv1 = cv0,
          i = i + 1;
    END WHILE;

    RETURN (c);
  END $$

DELIMITER ;
