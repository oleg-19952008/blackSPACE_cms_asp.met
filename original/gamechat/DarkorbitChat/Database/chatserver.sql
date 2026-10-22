-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 35.164.68.199
-- Erstellungszeit: 22. Okt 2013 um 21:00
-- Server Version: 5.5.32
-- PHP-Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `chatserver`
--
CREATE DATABASE IF NOT EXISTS `chatserver` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chatserver`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `Username` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bannedips`
--

CREATE TABLE IF NOT EXISTS `bannedips` (
  `Ip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bannedusers`
--

CREATE TABLE IF NOT EXISTS `bannedusers` (
  `Username` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chatrooms`
--

CREATE TABLE IF NOT EXISTS `chatrooms` (
  `Index` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Id` int(11) NOT NULL,
  UNIQUE KEY `Id` (`Id`),
  UNIQUE KEY `Index` (`Index`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `chatrooms`
--

INSERT INTO `chatrooms` (`Index`, `Name`, `Id`) VALUES
(0, 'Elitepvpers', 250),
(1, 'English', 251),
(2, 'German', 252);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `Timestamp` bigint(20) NOT NULL,
  `From` text NOT NULL,
  `To` text NOT NULL,
  `Message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
