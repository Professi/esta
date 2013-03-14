-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 14. Mrz 2013 um 08:36
-- Server Version: 5.5.29
-- PHP-Version: 5.4.6-1ubuntu1.1

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
  `time` time NOT NULL,
  `date_id` int(11) NOT NULL,
  `parent_child_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_appointment_date1_idx` (`date_id`),
  KEY `fk_appointment_parent_child1_idx` (`parent_child_id`),
  KEY `fk_appointment_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `child`
--

CREATE TABLE IF NOT EXISTS `child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET latin1 NOT NULL,
  `lastname` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `firstname` (`firstname`,`lastname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `child`
--

INSERT INTO `child` (`id`, `firstname`, `lastname`) VALUES
(8, 'Bla', 'bla'),
(10, 'blub', 'blub'),
(2, 'Hans', 'Meier'),
(6, 'Happe', 'Kall'),
(3, 'Horst', 'Peter'),
(5, 'Paul', 'Wurst'),
(4, 'Peter', 'Hans'),
(1, 'Peter', 'Horst'),
(11, 'qwe', 'qwe'),
(7, 'Test', 'Kind'),
(12, 'Test', 'test'),
(9, 'top', 'top');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `date`
--

CREATE TABLE IF NOT EXISTS `date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `begin` time NOT NULL,
  `end` time NOT NULL,
  `durationPerAppointment` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `date`
--

INSERT INTO `date` (`id`, `date`, `begin`, `end`, `durationPerAppointment`) VALUES
(1, '2013-08-30', '12:30:00', '20:30:00', 120);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Daten für Tabelle `parent_child`
--

INSERT INTO `parent_child` (`id`, `user_id`, `child_id`) VALUES
(3, 1, 2),
(4, 1, 3),
(17, 26, 12),
(18, 26, 9),
(19, 26, 8);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
  `tan` int(11) NOT NULL,
  `used` tinyint(1) NOT NULL,
  PRIMARY KEY (`tan`),
  UNIQUE KEY `tan_UNIQUE` (`tan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activationKey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(45) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '0',
  `lastname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `title` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`state`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='itle' AUTO_INCREMENT=30 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `activationKey`, `createtime`, `firstname`, `state`, `lastname`, `email`, `title`) VALUES
(1, 'admin@admin.de', 'cd613e9e5557f026ce9f11d91afc2dcca40c30cb608e756d4ad62edc50b1263098c80e161481d1b9a5e5413994072430f007b6d1c4633b0ff92c239c367954e1', 'c99375c5a0aa0267ec9342ac8d33de700ed13b8d', 1362647692, 'admin', 1, 'admin', 'admin@admin.de', NULL),
(26, 'ehr@ehr.de', '8651e90efc915b43c0a66c311d8e5884fe0bd4922a6751cc45fc8491b6360bd69eddd48484f52703dc6913eab78f2e6ea03f0a85ddd8144bdc2be21fe549df64', '4b03888105fc82bb8ca584f5a078d57d32737784', 1362666109, 'ehr', 0, 'ehr', 'ehr@ehr.de', NULL),
(28, 'qwe@qwe.de', '718e1644094133b27344a0c2e5b619131b6502728ead64b9bbcef8a37230e7c5a135f1c611ff07a51547f653db598950be801f8434a6780904d6a6eebcdfc9b5', '45dfcfa6657398b4d0ddd2c5fc23ad18333db126', 1362666856, 'qwe', 0, 'qwe', 'qwe@qwe.de', NULL),
(29, 'meier@hans.de', 'a9b708c762bc943b3afef23e742075fcbd8f6655f8d93e750bd318c1ff10e427911a996d9f5bab17dd43b7ea4cdab997c84d0ec548effb95bcb9c3e99023cffe', '386cd53ffbdab2b8d24913ee9b552f6d94fb5bf8', 1363166874, 'Hans', 0, 'Meier', 'meier@hans.de', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `user_role`
--

INSERT INTO `user_role` (`id`, `role_id`, `user_id`) VALUES
(2, 0, 1),
(3, 3, 26),
(5, 3, 28),
(6, 2, 29);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_date1` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_parent_child1` FOREIGN KEY (`parent_child_id`) REFERENCES `parent_child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
