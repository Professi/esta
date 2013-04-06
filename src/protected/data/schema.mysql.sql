-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 18. Mrz 2013 um 12:49
-- Server Version: 5.5.29
-- PHP-Version: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `estdb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_child_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `dateAndTime_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_appointment_parent_child1_idx` (`parent_child_id`),
  KEY `fk_appointment_user1_idx` (`user_id`),
  KEY `fk_appointment_dateAndTime1` (`dateAndTime_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `child`
--

CREATE TABLE IF NOT EXISTS `child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `date`
--

CREATE TABLE IF NOT EXISTS `date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `begin` time NOT NULL,
  `end` time NOT NULL,
  `lockAt` time NOT NULL,
  `durationPerAppointment` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dateAndTime`
--

CREATE TABLE IF NOT EXISTS `dateAndTime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` time NOT NULL,
  `date_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dateTime_date1` (`date_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `parent_child`
--

CREATE TABLE IF NOT EXISTS `parent_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `child_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_parent_child_user1_idx` (`user_id`),
  KEY `fk_parent_child_child1_idx` (`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------
--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`id`, `title`, `description`) VALUES
(0, 'Administration', NULL),
(1, 'Verwaltung', NULL),
(2, 'Lehrer', NULL),
(3, 'Eltern', NULL);
--
-- Tabellenstruktur für Tabelle `tan`
--

CREATE TABLE IF NOT EXISTS `tan` (
  `tan` int(11) NOT NULL,
  `used` tinyint(1) NOT NULL,
  PRIMARY KEY (`tan`),
  UNIQUE KEY `tan_UNIQUE` (`tan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE  TABLE IF NOT EXISTS `user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `activationKey` VARCHAR(128) NOT NULL,
  `createtime` INT UNSIGNED NOT NULL ,
  `firstname` VARCHAR(45) NOT NULL ,
  `lastname` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `title` VARCHAR(15) NULL ,
  `state` TINYINT UNSIGNED NOT NULL DEFAULT 0 ,
  `lastLogin` INT UNSIGNED NULL DEFAULT 0 ,
  `badLogins` TINYINT NOT NULL DEFAULT 0 ,
  `bannedUntil` INT UNSIGNED NULL ,
  `password` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username` (`username` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
INSERT INTO `user` (`id`, `username`, `password`, `activationKey`, `createtime`, `firstname`, `state`, `lastname`, `email`, `title`) VALUES
(1, 'admin@admin.de', 'cd613e9e5557f026ce9f11d91afc2dcca40c30cb608e756d4ad62edc50b1263098c80e161481d1b9a5e5413994072430f007b6d1c4633b0ff92c239c367954e1', 'c99375c5a0aa0267ec9342ac8d33de700ed13b8d', 1362647692, 'admin', 1, 'admin', 'admin@admin.de', NULL);


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_user_role_role1_idx` (`role_id`),
  KEY `fk_user_role_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `user_role`
--

INSERT INTO `user_role` (`id`, `role_id`, `user_id`) VALUES
(0, 0, 1);
--
-- Constraints der Tabelle `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_parent_child1` FOREIGN KEY (`parent_child_id`) REFERENCES `parent_child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_dateAndTime1` FOREIGN KEY (`dateAndTime_id`) REFERENCES `dateAndTime` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `dateAndTime`
--
ALTER TABLE `dateAndTime`
  ADD CONSTRAINT `fk_dateTime_date1` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `parent_child`
--
ALTER TABLE `parent_child`
  ADD CONSTRAINT `fk_parent_child_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_parent_child_child1` FOREIGN KEY (`child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `fk_user_role_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_role_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
