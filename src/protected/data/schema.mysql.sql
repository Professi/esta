-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 09. Mai 2013 um 16:02
-- Server Version: 5.5.31-0ubuntu0.13.04.1
-- PHP-Version: 5.4.9-4ubuntu2

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
  `parent_child_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dateAndTime_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointment_fk1` (`parent_child_id`),
  KEY `appointment_fk2` (`user_id`),
  KEY `appointment_fk3` (`dateAndTime_id`),
  KEY `idx_appointment_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `blockedAppointment`
--

CREATE TABLE IF NOT EXISTS `blockedAppointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` text,
  `dateAndTime_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_blockedAppointment` (`dateAndTime_id`,`user_id`),
  KEY `blockedAppointment_fk2` (`user_id`),
  KEY `idx_blockedAppointment_id` (`id`)
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
  KEY `idx_child_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `date`
--

CREATE TABLE IF NOT EXISTS `date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `begin` time NOT NULL,
  `end` time NOT NULL,
  `lockAt` int(11) NOT NULL,
  `durationPerAppointment` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_date_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dateAndTime`
--

CREATE TABLE IF NOT EXISTS `dateAndTime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` time NOT NULL,
  `date_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_dateAndTime_date_id_time` (`time`,`date_id`),
  KEY `dateAndTime_fk1` (`date_id`),
  KEY `idx_dateAndTime_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `date_has_group`
--

CREATE TABLE IF NOT EXISTS `date_has_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date_has_group1` (`date_id`,`group_id`),
  KEY `date_has_group_fk2` (`group_id`),
  KEY `idx_date_has_group_id2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_group_name` (`groupname`),
  KEY `idx_group_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `parent_child`
--

CREATE TABLE IF NOT EXISTS `parent_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_child_fk1` (`child_id`),
  KEY `parent_child_fk2` (`user_id`),
  KEY `idx_ parent_child_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_role_title` (`title`),
  KEY `idx_role_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`id`, `title`, `description`) VALUES
(0, 'Administration', NULL),
(1, 'Verwaltung', NULL),
(2, 'Lehrer', NULL),
(3, 'Eltern', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tan`
--

CREATE TABLE IF NOT EXISTS `tan` (
  `tan` int(11) DEFAULT NULL,
  `used` tinyint(1) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `used_by_user_id` int(11) DEFAULT NULL,
  `child_id` int(11) DEFAULT NULL,
  UNIQUE KEY `tan` (`tan`),
  KEY `tan_fk1` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `activationKey` varchar(255) NOT NULL,
  `createtime` bigint(20) NOT NULL DEFAULT '0',
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `state` tinyint(3) DEFAULT NULL,
  `lastLogin` bigint(20) DEFAULT '0',
  `badLogins` tinyint(4) DEFAULT NULL,
  `bannedUntil` bigint(20) DEFAULT '0',
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `activationKey`, `createtime`, `firstname`, `lastname`, `title`, `state`, `lastLogin`, `badLogins`, `bannedUntil`, `password`) VALUES
(1, 'admin@admin.de', 'admin@admin.de', 'bb907ba9379992565e7baa09d2681b7a1636719e', '2013-04-29 14:36:46', 'Admin', 'Admin', NULL, 1, 1367422688, 3, 0, 'cd613e9e5557f026ce9f11d91afc2dcca40c30cb608e756d4ad62edc50b1263098c80e161481d1b9a5e5413994072430f007b6d1c4633b0ff92c239c367954e1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_has_group`
--

CREATE TABLE IF NOT EXISTS `user_has_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_has_group1` (`user_id`,`group_id`),
  KEY `user_has_group_fk2` (`group_id`),
  KEY `idx_user_has_group_id2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role_fk1` (`role_id`),
  KEY `user_role_fk2` (`user_id`),
  KEY `idx_user_role_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `user_role` (`id`, `role_id`, `user_id`) VALUES
(1, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `YiiCache`
--

CREATE TABLE IF NOT EXISTS `YiiCache` (
  `id` varchar(255) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `value` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `YiiSession`
--

CREATE TABLE IF NOT EXISTS `YiiSession` (
  `id` varchar(255) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_fk3` FOREIGN KEY (`dateAndTime_id`) REFERENCES `dateAndTime` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `appointment_fk1` FOREIGN KEY (`parent_child_id`) REFERENCES `parent_child` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `appointment_fk2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `blockedAppointment`
--
ALTER TABLE `blockedAppointment`
  ADD CONSTRAINT `blockedAppointment_fk2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `blockedAppointment_fk1` FOREIGN KEY (`dateAndTime_id`) REFERENCES `dateAndTime` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `dateAndTime`
--
ALTER TABLE `dateAndTime`
  ADD CONSTRAINT `dateAndTime_fk1` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `date_has_group`
--
ALTER TABLE `date_has_group`
  ADD CONSTRAINT `date_has_group_fk2` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `date_has_group_fk1` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `parent_child`
--
ALTER TABLE `parent_child`
  ADD CONSTRAINT `parent_child_fk2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `parent_child_fk1` FOREIGN KEY (`child_id`) REFERENCES `child` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tan`
--
ALTER TABLE `tan`
  ADD CONSTRAINT `tan_fk1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `tan_fk2` FOREIGN KEY (`child_id`) REFERENCES `child` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
 ADD CONSTRAINT `tan_fk3` FOREIGN KEY (`used_by_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
--
-- Constraints der Tabelle `user_has_group`
--
ALTER TABLE `user_has_group`
  ADD CONSTRAINT `user_has_group_fk2` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_has_group_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_fk2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_role_fk1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
