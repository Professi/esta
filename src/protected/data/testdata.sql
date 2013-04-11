-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. Apr 2013 um 08:34
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `appointment`
--

INSERT INTO `appointment` (`id`, `parent_child_id`, `user_id`, `dateAndTime_id`) VALUES
(5, 3, 29, 25),
(6, 5, 30, 26),
(7, 4, 30, 31),
(8, 7, 26, 27),
(9, 4, 28, 30),
(10, 5, 26, 28),
(11, 2, 25, 32),
(12, 2, 30, 28),
(13, 2, 29, 30);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `blockedAppointment`
--

CREATE TABLE IF NOT EXISTS `blockedAppointment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reason` text,
  `dateAndTime_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_blockedAppointments_dateAndTime1` (`dateAndTime_id`),
  KEY `fk_blockedAppointments_user1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Daten für Tabelle `child`
--

INSERT INTO `child` (`id`, `firstname`, `lastname`) VALUES
(2, 'Hans', 'Peter'),
(3, 'Maier', 'Peter'),
(4, 'Mimimimi', 'Mimimimi'),
(5, 'Pew', 'Pew'),
(6, 'Windows', 'Gates'),
(7, 'Bolle', 'Bolle'),
(8, 'Kolli', 'Knolli'),
(9, 'Null', 'Exception'),
(10, 'Klein', 'Hansi'),
(11, 'Way', 'ToGate'),
(12, 'Master', 'Root'),
(13, 'Paul', 'Paul'),
(14, 'Peddy', 'Wolle'),
(15, 'Viernullvier', 'Nichtgefunden'),
(16, 'Schalom', 'Schalom'),
(17, 'Meister', 'Eder'),
(18, 'Mensch', 'Meister'),
(19, 'Master', 'OfTheUniverse'),
(20, 'Papa', 'Schlumpf'),
(21, 'Misa', 'Schmecknix'),
(22, 'Olaf', 'Kuh'),
(23, 'Steffen', 'Kerze'),
(24, 'Zlati', 'Messi'),
(25, 'Kind', 'Drei'),
(26, 'Halil', 'Franz'),
(27, 'Google', 'Mich'),
(28, 'Google', 'Dich'),
(29, 'Sarpei', 'Hans'),
(30, 'Kabel', 'Salat'),
(31, 'Salat', 'Klein'),
(32, 'Nils', 'Nixgut'),
(33, 'Wurzel', 'Root');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `date`
--

CREATE TABLE IF NOT EXISTS `date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `begin` time NOT NULL,
  `end` time NOT NULL,
  `lockAt` int(10) unsigned NOT NULL,
  `durationPerAppointment` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `date`
--

INSERT INTO `date` (`id`, `date`, `begin`, `end`, `lockAt`, `durationPerAppointment`) VALUES
(2, '2013-04-26', '17:00:00', '19:00:00', 1366981200, 15);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Daten für Tabelle `dateAndTime`
--

INSERT INTO `dateAndTime` (`id`, `time`, `date_id`) VALUES
(25, '17:00:00', 2),
(26, '17:15:00', 2),
(27, '17:30:00', 2),
(28, '17:45:00', 2),
(29, '18:00:00', 2),
(30, '18:15:00', 2),
(31, '18:30:00', 2),
(32, '18:45:00', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Daten für Tabelle `parent_child`
--

INSERT INTO `parent_child` (`id`, `user_id`, `child_id`) VALUES
(2, 90, 2),
(3, 95, 3),
(4, 107, 4),
(5, 105, 5),
(6, 106, 6),
(7, 90, 7),
(8, 97, 8),
(9, 97, 9),
(10, 108, 10),
(11, 115, 11),
(12, 117, 12),
(13, 95, 13),
(14, 110, 14),
(15, 112, 15),
(16, 113, 16),
(17, 103, 17),
(18, 104, 18),
(19, 103, 19),
(20, 102, 20),
(21, 98, 21),
(22, 110, 22),
(23, 100, 23),
(24, 111, 24),
(25, 109, 25),
(26, 100, 26),
(27, 95, 27),
(28, 96, 28),
(29, 116, 29),
(30, 97, 30),
(31, 108, 31),
(32, 98, 32),
(33, 117, 33);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `activationKey` varchar(128) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(15) DEFAULT NULL,
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lastLogin` int(10) unsigned DEFAULT '0',
  `badLogins` tinyint(4) NOT NULL DEFAULT '0',
  `bannedUntil` int(10) unsigned DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `activationKey`, `createtime`, `firstname`, `lastname`, `title`, `state`, `lastLogin`, `badLogins`, `bannedUntil`, `password`) VALUES
(1, 'admin@admin.de', 'admin@admin.de', 'c99375c5a0aa0267ec9342ac8d33de700ed13b8d', 1362647692, 'admin', 'admin', NULL, 1, 1365661864, 0, NULL, 'cd613e9e5557f026ce9f11d91afc2dcca40c30cb608e756d4ad62edc50b1263098c80e161481d1b9a5e5413994072430f007b6d1c4633b0ff92c239c367954e1'),
(4, 'v.adam@uni-mainz.de', 'v.adam@uni-mainz.de', '23321a328fcbfb464a680ede027698322ed308f3', 1365481843, 'Vjeka Maria', 'Adam', '', 1, 0, 0, NULL, 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0'),
(5, 'g.adler@bws-hofheim.de', 'g.adler@bws-hofheim.de', '479e70d0ddb7b9daedd3b127db71e502dcaebb56', 1365481843, 'Gregor', 'Adler', '', 1, 0, 0, NULL, 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0'),
(25, 't.fischer@bws-hofheim.de', 't.fischer@bws-hofheim.de', '5d81fcf592645cf0539f54af134c3ac7f4d3a087', 1365481843, 'Thomas', 'Fischer', '', 1, 0, 0, NULL, 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0'),
(26, 'j.foerster@bws-hofheim.de', 'j.foerster@bws-hofheim.de', 'c518bd78e16fcb1c5ad63090eddf14a1d1fc62aa', 1365481843, 'Jürgen', 'Förster', '', 1, 0, 0, NULL, 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0'),
(27, 's.gerling@bws-hofheim.de', 's.gerling@bws-hofheim.de', '9ba792019307ec22ba111a7dd13b2762f0aad24c', 1365481843, 'Sabine', 'Gerling', '', 1, 0, 0, NULL, 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0'),
(28, 'p.gienandt@bws-hofheim.de', 'p.gienandt@bws-hofheim.de', '785a29713b100637f6429572e55ff161ea399136', 1365481843, 'Petra', 'Gienandt', '', 1, 0, 0, NULL, 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0'),
(29, 'edwin@edwin-gram.de', 'edwin@edwin-gram.de', 'a08c30222ca9539980a87f00bab00bef5d7c7109', 1365481843, 'Edwin', 'Gram', '', 1, 0, 0, NULL, 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0'),
(30, 'p.gruening@bws-hofheim.de', 'p.gruening@bws-hofheim.de', '741211c35ee7dfd284ecfce2106f3e4a3874101e', 1365481843, 'Peter', 'Grüning', '', 1, 1365660486, 0, NULL, 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0'),
(90, 'eltern@eltern.de', 'eltern@eltern.de', 'b6987a1e0b8cff7ad7c3676934b070240db35ffc', 1365567070, 'Eltern', 'Eltern', NULL, 1, 1365661843, 1, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609'),
(91, 'admin2@admin2.de', 'admin2@admin2.de', 'a05caa3bf021f9d4d2e22ee5bf4ea15cc78d28b9', 1365652530, 'Admin2', 'Admin2', NULL, 1, 0, 0, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609'),
(92, 'verwaltung@verwaltung.de', 'verwaltung@verwaltung.de', 'cb61c49220e0317ae2d261e13f7198737331220f', 1365652548, 'Verwaltung', 'Verwaltung', NULL, 1, 0, 0, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609'),
(93, 'verwaltung2@verwaltung2.de', 'verwaltung2@verwaltung2.de', '39262e8aa8717508c331f980793d312671dde987', 1365652585, 'Verwaltung2', 'Verwaltung2', NULL, 1, 0, 0, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609'),
(94, 'MeiHan', NULL, '43c4475b1928593817143624364c9b53699994e4', 1365652751, 'Hans', 'Meier', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(95, 'HorPet', NULL, 'd93b10507f8de1364e8d6fc9b2763a25646183a3', 1365652759, 'Peter', 'Horst', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(96, 'HorRud', NULL, 'de84fe034a9d96388bc3e3c0c3ba46a0e5eb4048', 1365652815, 'Rudolf', 'Horst', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(97, 'KolKar', NULL, '3fa09a4d6b611cb0c06e75e614c668a5871ce44a', 1365652839, 'Karl-Heinz', 'Kolle', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(98, 'NixCha', NULL, '39e5ec763b9a563097cb356189681a6381d7570b', 1365652859, 'Charlotte', 'Nixgut', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(99, 'MüCha', NULL, 'a18962e349550866d090e142f8269688e5ff4617', 1365652879, 'Chantall', 'Müller', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(100, 'FriPet', NULL, '705e20cabb6cc9930c2af4c145c3258bee13ad57', 1365652893, 'Peter', 'Fritz', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(101, 'PetFri', NULL, 'd3e6db593a1261fd64e5114d1f0ce925e2a4f84d', 1365652900, 'Fritz', 'Peter', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(102, 'PetPet', NULL, '7cf6d830f49dac16e0a5394316bead4ba7053499', 1365652913, 'Peter', 'Peter', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(103, 'MeiMar', NULL, 'b88a7833309183984eb524bf05db1647ce31c064', 1365652942, 'Mario', 'Meister', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(104, 'ManMar', NULL, 'a6a319ad63a68231e2b8147a6e23848f005c871b', 1365652963, 'Marco', 'Mann', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(105, 'MocDav', NULL, '9b329b3bab7db1223bca108b2c356979aad3c06e', 1365652996, 'David', 'Mockup', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(106, 'UntMat', NULL, 'b6ce5557d3cb41d00f08bd55ea8ed6045a456f15', 1365653010, 'Matthias', 'Untermbaum', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(107, 'AufChr', NULL, '0896bf9b486d5db8a844a24ed3727fea9061b4d7', 1365653040, 'Christian', 'Aufmfeld', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(108, 'KleHan', NULL, '41835f8b505be57cb567623d68cf3cf6a560bee4', 1365653058, 'Hansi', 'Klein', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(109, 'ZwePet', NULL, 'e7b56ea1268cad234702b429aa440159ee650d41', 1365653080, 'Peter', 'Zwei', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(110, 'PedWol', NULL, '6a2b6ce7102680177c772ef11cf11d2d26aed061', 1365653117, 'Wolfgang', 'Peddy', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(111, 'IbrZla', NULL, '644df751e73c24d8ee2d5a619ec2b4688b5b94ce', 1365653171, 'Zlatan', 'Ibrakadabra', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(112, 'PerVie', NULL, 'ac5ace7eef7ad163d9c92ea29e6ad5aa753ff743', 1365653212, 'Viernulldrei', 'Permission', NULL, 0, 0, 0, NULL, '631bc113301d4c52b26525ed6123f16f3f67e2d18e7828c379319787d0cb290e6c5078a99164998d2b8ae0c6897c0d79ead9ed4e4c31f68495b61d7aacdf94fe'),
(113, 'palim@palim.de', 'palim@palim.de', '842b50f0b0cdc2c2583dfd685c2c8a1301e3136e', 1365653505, 'Palim', 'Palim', NULL, 1, 0, 0, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609'),
(114, 'google@suchmaschine.de', 'google@suchmaschine.de', '56d621520b05dc50bbef2730a749d587306d7208', 1365653532, 'Google', 'Suchmaschine', NULL, 1, 0, 0, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609'),
(115, 'gate@way.de', 'gate@way.de', '46fe6f638d0cfb7e9da6ca92eed1bee0e7bdfe6e', 1365653563, 'Gate', 'Way', NULL, 1, 0, 0, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609'),
(116, 'hansi@mei.de', 'hansi@mei.de', 'd0405fe3f47a0a2c29fe7308a7e2b06f2138691b', 1365653616, 'Hans', 'Imglück', NULL, 1, 0, 0, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609'),
(117, 'root@root.de', 'root@root.de', 'fa66b80747ba15afee113e21f7cd8edafa07d742', 1365653672, 'Root', 'Root', NULL, 1, 0, 0, NULL, '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

--
-- Daten für Tabelle `user_role`
--

INSERT INTO `user_role` (`id`, `role_id`, `user_id`) VALUES
(0, 0, 1),
(3, 2, 4),
(4, 2, 5),
(24, 2, 25),
(25, 2, 26),
(26, 2, 27),
(27, 2, 28),
(28, 2, 29),
(29, 2, 30),
(89, 3, 90),
(90, 0, 91),
(91, 1, 92),
(92, 1, 93),
(93, 3, 94),
(94, 3, 95),
(95, 3, 96),
(96, 3, 97),
(97, 3, 98),
(98, 3, 99),
(99, 3, 100),
(100, 3, 101),
(101, 3, 102),
(102, 3, 103),
(103, 3, 104),
(104, 3, 105),
(105, 3, 106),
(106, 3, 107),
(107, 3, 108),
(108, 3, 109),
(109, 3, 110),
(110, 3, 111),
(111, 3, 112),
(112, 3, 113),
(113, 3, 114),
(114, 3, 115),
(115, 3, 116),
(116, 3, 117);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_dateAndTime1` FOREIGN KEY (`dateAndTime_id`) REFERENCES `dateAndTime` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_parent_child1` FOREIGN KEY (`parent_child_id`) REFERENCES `parent_child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `blockedAppointment`
--
ALTER TABLE `blockedAppointment`
  ADD CONSTRAINT `fk_blockedAppointment_dateAndTime1` FOREIGN KEY (`dateAndTime_id`) REFERENCES `dateAndTime` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_blockedAppointment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `dateAndTime`
--
ALTER TABLE `dateAndTime`
  ADD CONSTRAINT `fk_dateTime_date1` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `parent_child`
--
ALTER TABLE `parent_child`
  ADD CONSTRAINT `fk_parent_child_child1` FOREIGN KEY (`child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_parent_child_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `fk_user_role_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_role_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
