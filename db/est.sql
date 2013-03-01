-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 28. Feb 2013 um 13:41
-- Server Version: 5.5.29
-- PHP-Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `est`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `id_appointment` int(11) NOT NULL AUTO_INCREMENT,
  `id_teacher` int(11) NOT NULL,
  `id_parents` int(11) NOT NULL,
  `numOfTeacher` int(11) NOT NULL,
  `id_date` int(11) NOT NULL,
  PRIMARY KEY (`id_appointment`),
  KEY `fk_appointment_1` (`id_teacher`),
  KEY `fk_appointment_2` (`id_parents`),
  KEY `fk_appointment_3` (`id_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `date`
--

CREATE TABLE IF NOT EXISTS `date` (
  `id_date` int(11) NOT NULL AUTO_INCREMENT,
  `date_begin` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `appointments` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `parent`
--

CREATE TABLE IF NOT EXISTS `parent` (
  `id_parent` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Datasets for one part of parents' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `parents`
--

CREATE TABLE IF NOT EXISTS `parents` (
  `id_parents` int(11) NOT NULL AUTO_INCREMENT,
  `parent1` int(11) NOT NULL,
  `parent2` int(11) DEFAULT NULL,
  `pw` blob NOT NULL,
  PRIMARY KEY (`id_parents`),
  KEY `parent1` (`parent1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `parents_pupils`
--

CREATE TABLE IF NOT EXISTS `parents_pupils` (
  `id_parents_pupils` int(11) NOT NULL,
  `id_parents` int(11) NOT NULL,
  `id_pupil` int(11) NOT NULL,
  PRIMARY KEY (`id_parents_pupils`),
  KEY `fk_parents_pupils_1` (`id_parents`),
  KEY `fk_parents_pupils_2` (`id_pupil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pupils`
--

CREATE TABLE IF NOT EXISTS `pupils` (
  `id_pupil` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `id_schoolclass` int(11) NOT NULL,
  `bDay` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_pupil`),
  KEY `fk_pupils_1` (`id_schoolclass`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Datasets for pupils.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schoolclasses`
--

CREATE TABLE IF NOT EXISTS `schoolclasses` (
  `id_schoolclass` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(5) NOT NULL,
  PRIMARY KEY (`id_schoolclass`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id_teacher` int(11) NOT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_teacher`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teacher_classes`
--

CREATE TABLE IF NOT EXISTS `teacher_classes` (
  `id_teacher_classes` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL,
  `id_schoolclass` int(11) NOT NULL,
  PRIMARY KEY (`id_teacher_classes`),
  KEY `fk_teacher_classes_1` (`id_teacher`),
  KEY `fk_teacher_classes_2` (`id_schoolclass`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int(11) NOT NULL,
  `state` char(1) NOT NULL,
  `pw` blob,
  `username` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_1` FOREIGN KEY (`id_teacher`) REFERENCES `teachers` (`id_teacher`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_2` FOREIGN KEY (`id_parents`) REFERENCES `parents` (`id_parents`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_3` FOREIGN KEY (`id_date`) REFERENCES `date` (`id_date`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parent1` FOREIGN KEY (`parent1`) REFERENCES `parent` (`id_parent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `parents_pupils`
--
ALTER TABLE `parents_pupils`
  ADD CONSTRAINT `fk_parents_pupils_1` FOREIGN KEY (`id_parents`) REFERENCES `parents` (`id_parents`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_parents_pupils_2` FOREIGN KEY (`id_pupil`) REFERENCES `pupils` (`id_pupil`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `pupils`
--
ALTER TABLE `pupils`
  ADD CONSTRAINT `fk_pupils_1` FOREIGN KEY (`id_schoolclass`) REFERENCES `schoolclasses` (`id_schoolclass`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD CONSTRAINT `fk_teacher_classes_1` FOREIGN KEY (`id_teacher`) REFERENCES `teachers` (`id_teacher`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_teacher_classes_2` FOREIGN KEY (`id_schoolclass`) REFERENCES `schoolclasses` (`id_schoolclass`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
