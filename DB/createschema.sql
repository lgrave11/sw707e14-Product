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
