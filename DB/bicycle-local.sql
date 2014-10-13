-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 13. 10 2014 kl. 15:51:14
-- Serverversion: 5.6.20
-- PHP-version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bicycle-local`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `Id` int(11) NOT NULL,
  `StartTime` bigint(20) NOT NULL,
  `Password` int(6) NOT NULL,
  `StationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `dock`
--

CREATE TABLE IF NOT EXISTS `dock` (
  `Id` int(11) NOT NULL,
  `StationID` int(11) NOT NULL,
  `Holds_bicycle` int(11) NOT NULL,
  `IsLocked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `station`
--

CREATE TABLE IF NOT EXISTS `station` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `booking`
--
ALTER TABLE `booking`
 ADD PRIMARY KEY (`Id`);

--
-- Indeks for tabel `dock`
--
ALTER TABLE `dock`
 ADD PRIMARY KEY (`Id`,`StationID`);

--
-- Indeks for tabel `station`
--
ALTER TABLE `station`
 ADD PRIMARY KEY (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
