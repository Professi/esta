-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 18. Mrz 2013 um 12:10
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
  `dateTime_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_appointment_parent_child1_idx` (`parent_child_id`),
  KEY `fk_appointment_user1_idx` (`user_id`),
  KEY `fk_appointment_dateTime1` (`dateTime_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Daten für Tabelle `child`
--

INSERT INTO `child` (`id`, `firstname`, `lastname`) VALUES
(1, 'Peter', 'Horst'),
(2, 'Hans', 'Meier'),
(3, 'Horst', 'Peter'),
(4, 'Peter', 'Hans'),
(5, 'Paul', 'Wurst'),
(6, 'Happe', 'Kall'),
(7, 'Test', 'Kind'),
(8, 'Bla', 'bla'),
(9, 'top', 'top'),
(10, 'blub', 'blub'),
(11, 'qwe', 'qwe'),
(12, 'Test', 'test'),
(13, 'TestEltern', 'TestEltern'),
(14, 'Christian', 'Ehringfeld'),
(15, 'David', 'Mock'),
(16, 'David', 'Muck');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dateTime`
--

CREATE TABLE IF NOT EXISTS `dateTime` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Daten für Tabelle `parent_child`
--

INSERT INTO `parent_child` (`id`, `user_id`, `child_id`) VALUES
(3, 1, 2),
(4, 1, 3),
(17, 26, 12),
(18, 26, 9),
(19, 26, 8),
(20, 31, 13),
(21, 31, 14),
(22, 31, 16);

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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activationKey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(45) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '0',
  `lastname` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(45) NOT NULL,
  `title` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`state`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='itle' AUTO_INCREMENT=128 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `activationKey`, `createtime`, `firstname`, `state`, `lastname`, `email`, `title`) VALUES
(1, 'admin@admin.de', 'cd613e9e5557f026ce9f11d91afc2dcca40c30cb608e756d4ad62edc50b1263098c80e161481d1b9a5e5413994072430f007b6d1c4633b0ff92c239c367954e1', 'c99375c5a0aa0267ec9342ac8d33de700ed13b8d', 1362647692, 'admin', 1, 'admin', 'admin@admin.de', NULL),
(26, 'ehr@ehr.de', '8651e90efc915b43c0a66c311d8e5884fe0bd4922a6751cc45fc8491b6360bd69eddd48484f52703dc6913eab78f2e6ea03f0a85ddd8144bdc2be21fe549df64', '4b03888105fc82bb8ca584f5a078d57d32737784', 1362666109, 'ehr', 0, 'ehr', 'ehr@ehr.de', NULL),
(28, 'qwe@qwe.de', '718e1644094133b27344a0c2e5b619131b6502728ead64b9bbcef8a37230e7c5a135f1c611ff07a51547f653db598950be801f8434a6780904d6a6eebcdfc9b5', '45dfcfa6657398b4d0ddd2c5fc23ad18333db126', 1362666856, 'qwe', 0, 'qwe', 'qwe@qwe.de', NULL),
(29, 'meier@hans.de', 'a9b708c762bc943b3afef23e742075fcbd8f6655f8d93e750bd318c1ff10e427911a996d9f5bab17dd43b7ea4cdab997c84d0ec548effb95bcb9c3e99023cffe', '386cd53ffbdab2b8d24913ee9b552f6d94fb5bf8', 1363166874, 'Hans', 0, 'Meier', 'meier@hans.de', NULL),
(30, 'verwaltung@verwaltung.de', 'a9b708c762bc943b3afef23e742075fcbd8f6655f8d93e750bd318c1ff10e427911a996d9f5bab17dd43b7ea4cdab997c84d0ec548effb95bcb9c3e99023cffe', '06677962dadea045d6a06a08a2486a66d2ca949d', 1363254668, 'verwaltung', 1, 'verwaltung', 'verwaltung@verwaltung.de', NULL),
(31, 'eltern@eltern.de', 'a9b708c762bc943b3afef23e742075fcbd8f6655f8d93e750bd318c1ff10e427911a996d9f5bab17dd43b7ea4cdab997c84d0ec548effb95bcb9c3e99023cffe', 'c879539ee28e2c450519a2ebbb653b5d3c1ac15e', 1363254728, 'eltern', 1, 'eltern', 'eltern@eltern.de', NULL),
(32, 'lehrer@lehrer.de', 'a9b708c762bc943b3afef23e742075fcbd8f6655f8d93e750bd318c1ff10e427911a996d9f5bab17dd43b7ea4cdab997c84d0ec548effb95bcb9c3e99023cffe', '2a9c03664405a13f4590eeb67b18b2a15dcb021c', 1363254753, 'lehrer', 1, 'lehrer', 'lehrer@lehrer.de', NULL),
(33, 'super@toll.de', '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609', '5cbb000e59ab0026d2b81623203cc2f40cfe564f', 1363261487, 'super', 1, 'toll', 'super@toll.de', NULL),
(38, 'c.ehringfeld@t-online.de', 'c019cfeeba822ff3f332b50e5906649c884204f33949eae99a896bd26007d0d4c30e2d65514a40172d5689fd6292f04f93d37df63108afae929ccd4e9614a687', 'f577fb82ce4375ce472bafe85f3097934e41f841', 1363360496, 'Christian', 1, 'Ehringfeld', 'c.ehringfeld@t-online.de', NULL),
(39, 'matthias.unterbusch@web.de', 'a9b708c762bc943b3afef23e742075fcbd8f6655f8d93e750bd318c1ff10e427911a996d9f5bab17dd43b7ea4cdab997c84d0ec548effb95bcb9c3e99023cffe', '273e07444ee8f7d5b9fe7326c10ba797896a66c1', 1363447431, 'Matthias', 1, 'Unterbusch', 'matthias.unterbusch@web.de', NULL),
(40, 'v.adam@uni-mainz.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '88d6dfd9e3f47df7b88eb66d4c05cf6572c91cb2', 1363520681, 'Vjeka Maria', 1, 'Adam', 'v.adam@uni-mainz.de', ''),
(41, 'g.adler@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '31710f7f24ab3bb7dbd896f164d4dfc840f91f47', 1363520681, 'Gregor', 1, 'Adler', 'g.adler@bws-hofheim.de', ''),
(42, 'm.albers@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'd2cce0dc7d5aebab5fbfbb34a265fa65e0426488', 1363520681, 'Michael Günter', 1, 'Albers', 'm.albers@bws-hofheim.de', ''),
(43, 'artner@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '8ceeed4c11abb3588430d9f49a508c0f6b15e7fc', 1363520681, 'Elisabeth Maria', 1, 'Artner-Peil', 'artner@gmx.de', ''),
(44, 'i.becker@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '8f5a4080cd9ee187289c772d42bb71027724d812', 1363520681, 'Ingeborg', 1, 'Becker', 'i.becker@bws-hofheim.de', ''),
(45, 'm.becker@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '688b2aa97b4cb1f8496d09ab8d27f099572bc1d8', 1363520681, 'Manuela', 1, 'Becker', 'm.becker@bws-hofheim.de', ''),
(46, 'h.benz@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '7b916b641e7cf7dde9b8a437ad35dc3fdcf8ef5d', 1363520681, 'Hubert', 1, 'Benz', 'h.benz@bws-hofheim.de', 'Dr.'),
(47, 'christophberg@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '2cdc73bbe99a9a7f3d990f306901d31ad96f06b4', 1363520681, 'Christoph', 1, 'Berg', 'christophberg@gmx.de', ''),
(48, 'w.bill@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'b72838fe41233956c22fc82caa391a8c1dfe9b06', 1363520681, 'Wolfgang', 1, 'Bill', 'w.bill@bws-hofheim.de', ''),
(49, 'v.blam@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '97a145da7b746bd9cfa7137de9f806054726220b', 1363520681, 'Volker', 1, 'Blam', 'v.blam@bws-hofheim.de', ''),
(50, 'e.blenn@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'adedea2bb7b04655184ff5706fb70ec226ccb65f', 1363520681, 'Ernst Otto', 1, 'Blenn', 'e.blenn@bws-hofheim.de', ''),
(51, 'l.boeckle@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '16cfdee21a6ababe88f02acfe6068ce8131e7bf2', 1363520681, 'Linda', 1, 'Böckle', 'l.boeckle@bws-hofheim.de', ''),
(52, 'k.boecking@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'c66ac49269735b69538abe0cd5316230ca5843a1', 1363520681, 'Karl', 1, 'Boecking', 'k.boecking@bws-hofheim.de', ''),
(53, 'alfred-boehm@arcor.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '1ca425228ebcf8c2a2eb3ab7f25a143c2c1dcf75', 1363520681, 'Alfred', 1, 'Böhm', 'alfred-boehm@arcor.de', ''),
(54, 'e.breuninger@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'e491066120d3a502db9d68abee3efb178d77c9a1', 1363520681, 'Ernst', 1, 'Breuninger', 'e.breuninger@bws-hofheim.de', ''),
(55, 'a.briedis@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '1ec2ee871f5453b2c8e356524f4cd890ba292e6b', 1363520681, 'Arthur', 1, 'Briedis', 'a.briedis@bws-hofheim.de', ''),
(56, 'm.brueckner@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '03a064a74f270fa3d85e5047983add14f530e911', 1363520681, 'Manuela', 1, 'Brückner', 'm.brueckner@bws-hofheim.de', ''),
(57, 'f.burggraf@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '41ef795d9e67f5fd37274142ec3fcb54d3c4546e', 1363520681, 'Frank', 1, 'Burggraf', 'f.burggraf@bws-hofheim.de', ''),
(58, 'm.comtesse@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'eb9dad28ae9970810b9493934ab84a4437d438d9', 1363520681, 'Mirjam', 1, 'Comtesse', 'm.comtesse@bws-hofheim.de', ''),
(59, 'p.ebrecht@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'a95f006013f6f04a72c57aaeda0e15780615814f', 1363520681, 'Peter', 1, 'Ebrecht', 'p.ebrecht@bws-hofheim.de', ''),
(60, 'u.elser@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '5000c39c6362b83b1a30a281c48e3d1ff6abaa4a', 1363520682, 'Ute', 1, 'Elser', 'u.elser@bws-hofheim.de', ''),
(61, 't.fischer@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '22a740c59d32ce99c55e05840dd0af6d3f9ed964', 1363520682, 'Thomas', 1, 'Fischer', 't.fischer@bws-hofheim.de', ''),
(62, 'j.foerster@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '44a0550f8f02666b66c99b5de1334fd3a91f1f59', 1363520682, 'Jürgen', 1, 'Förster', 'j.foerster@bws-hofheim.de', ''),
(63, 's.gerling@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'a2153419ecab7e26e7135dadd36b1d2975b43d09', 1363520682, 'Sabine', 1, 'Gerling', 's.gerling@bws-hofheim.de', ''),
(64, 'p.gienandt@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '2a904fe0c14fb94f4e25cf0f363e7bbf1f37d55f', 1363520682, 'Petra', 1, 'Gienandt', 'p.gienandt@bws-hofheim.de', ''),
(65, 'edwin@edwin-gram.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '5648227d8ea19ef15d9f319e9b438d64ef63e067', 1363520682, 'Edwin', 1, 'Gram', 'edwin@edwin-gram.de', ''),
(66, 'p.gruening@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '177170f29046c49ca6acc5ccbca89852aa89112b', 1363520682, 'Peter', 1, 'Grüning', 'p.gruening@bws-hofheim.de', ''),
(67, 'sarah.guha@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '236e53616453f892707620fcc77beeb303f2c2e7', 1363520682, 'Sarah', 1, 'Guha', 'sarah.guha@gmx.de', ''),
(68, 'y.guenther@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '3b99d6b8689d3880fa720028de32ebe3b3246e1d', 1363520682, 'Yvonne', 1, 'Günther', 'y.guenther@bws-hofheim.de', ''),
(69, 'udo.haarstark@web.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '5ec9423b67e01f5e203db3f5114759f4b3f88798', 1363520682, 'Udo', 1, 'Haarstark', 'udo.haarstark@web.de', ''),
(70, 's.hausotter@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'ba69d9ca36a0ec364fbb6b57de5a2cad17f3c708', 1363520682, 'Siegfried', 1, 'Hausotter', 's.hausotter@bws-hofheim.de', ''),
(71, 'hess_Dirk@web.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '2e966b7187a915251568ebfe81451ec5e12ab742', 1363520682, 'Dirk', 1, 'Heß', 'hess_Dirk@web.de', ''),
(72, 'm.heuser@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'a11cdab46030ee1ca7bdd251a4b78d922aaa5777', 1363520682, 'Manfred', 1, 'Heuser', 'm.heuser@bws-hofheim.de', ''),
(73, 'j.hirth@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'ce4f712f21521c4caa705ff6dec9129d85d92b48', 1363520682, 'Joachim', 1, 'Hirth', 'j.hirth@bws-hofheim.de', ''),
(74, 'a.jahn@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '26e9c8cce1e09316d3eecfa00f1a86041c3c6178', 1363520682, 'Annette', 1, 'Jahn', 'a.jahn@bws-hofheim.de', ''),
(75, 'kallenberg@web.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '1c4e978019f6cf5ad7063dc2e8d86f1ed4592cc0', 1363520682, 'Klaus', 1, 'Kallenberg', 'kallenberg@web.de', ''),
(76, 'o.kasior@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '390cc39c4774c92d5c0a0dbd18c3f8153c58a907', 1363520682, 'Olaf', 1, 'Kasior', 'o.kasior@bws-hofheim.de', ''),
(77, 'olafkleinboehl@ad.com', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'd4df5e6cc836d8efaf35f6b7a1e8cdff32030c9c', 1363520682, 'Olaf', 1, 'Kleinböhl', 'olafkleinboehl@ad.com', ''),
(78, 's.koenen@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'df220be69dfbc0d789721aa7ef20ee4901e4bcd6', 1363520682, 'Susanne', 1, 'Koenen', 's.koenen@bws-hofheim.de', ''),
(79, 'detlef-koepke@t-online.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '94085126a7e1de3286ab52cbb96733c9a1c8f1e6', 1363520682, 'Detlef', 1, 'Köpke', 'detlef-koepke@t-online.de', 'Dr.'),
(80, 'a.korinth@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '673e1f75d3fd43312d6f582166ce2fed93802730', 1363520682, 'Axel', 1, 'Korinth', 'a.korinth@bws-hofheim.de', ''),
(81, 'ulrike.krahl@googlemail.com', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '6baf9a480c6c386a05bf00d00e1dee71b4040de7', 1363520682, 'Ulrike', 1, 'Krahl', 'ulrike.krahl@googlemail.com', ''),
(82, 's.kubiczek@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '998408aee2bf0d3ba9a6faeaeb21eae3d2ad8662', 1363520682, 'Stephan', 1, 'Kubiczek', 's.kubiczek@bws-hofheim.de', ''),
(83, 'u.kunkel@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '41c9ed03ca01fcf6a538ed478ceb0376af8a717f', 1363520682, 'Ulrich', 1, 'Kunkel', 'u.kunkel@bws-hofheim.de', ''),
(84, 'm.leetz@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'f4681ac6ed34bbe9e955ea269497b2c7058a106e', 1363520682, 'Michael', 1, 'Leetz', 'm.leetz@bws-hofheim.de', ''),
(85, 'claudia.limberg@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'ba29cdb307fb91bf7fa14a9f4465d7457b42ce78', 1363520682, 'Claudia', 1, 'Limberg', 'claudia.limberg@gmx.de', ''),
(86, 'h.lorenz@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '29269a5d20c570a0b80cb4bb76747ee615e1c7f4', 1363520682, 'Hans-Albert', 1, 'Lorenz', 'h.lorenz@bws-hofheim.de', ''),
(87, 'a.markus@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'a9f2f5fe714f07b05d4c2662f1a16dd575ae6d7f', 1363520682, 'Andreas', 1, 'Markus', 'a.markus@bws-hofheim.de', ''),
(88, 'thomas.maul@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'd5baecba2e375894b395336dffac35f43effa130', 1363520682, 'Thomas', 1, 'Maul', 'thomas.maul@gmx.de', ''),
(89, 't.mensing@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '7e6b0ec1e47023a3e99123d64c761bd43d4eb7c0', 1363520682, 'Tobias', 1, 'Mensing', 't.mensing@bws-hofheim.de', ''),
(90, 'm.micieli@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'c79a57cd961060ffc9c203896fdb3f2f56339b67', 1363520682, 'Margot', 1, 'Micieli', 'm.micieli@bws-hofheim.de', ''),
(91, 'a.milde-schmidt@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'd274fd35325de65227b6a5ee770a2a67bf29c86c', 1363520682, 'Angelika', 1, 'Milde-Schmidt', 'a.milde-schmidt@bws-hofheim.de', ''),
(92, 'c.morawietz@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'c44be2ffdc875e1981ba5e23ba7dcfc0134a945e', 1363520682, 'Christof', 1, 'Morawietz', 'c.morawietz@bws-hofheim.de', ''),
(93, 'nurtsch@web.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'f96c65e1934fe72796e735142d7f58eee3581d02', 1363520682, 'Tanja Lieselotte', 1, 'Nurtsch', 'nurtsch@web.de', ''),
(94, 'r.ortwein@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '8c297ed2a94748ce59d2fd47be76f515e98ca8c5', 1363520682, 'Romy', 1, 'Ortwein', 'r.ortwein@bws-hofheim.de', ''),
(95, 'silke-ostermeier@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '2e96a5fa1d99417c221aee20b2852ad2c28ad614', 1363520682, 'Silke', 1, 'Ostermeier', 'silke-ostermeier@gmx.de', ''),
(96, 'i.pereirahuppertz@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'bceea1806ec75552308498ad453871a2ddb54fd2', 1363520683, 'Izabel Ermelinda', 1, 'Pereira Huppertz', 'i.pereirahuppertz@bws-hofheim.de', ''),
(97, 'd.peuthert@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'd1536322661fb3e629e4a1d3603b071cf7c9dd14', 1363520683, 'Detlef', 1, 'Peuthert', 'd.peuthert@bws-hofheim.de', ''),
(98, 't.pfeiffer@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'f4b736c7cf795455c4f0b36ba9ecb1c5107a6392', 1363520683, 'Thomas', 1, 'Pfeiffer', 't.pfeiffer@bws-hofheim.de', ''),
(99, 't.proc@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '2fc1a8201ba18537ff1b55059d06eb89c61c9ed8', 1363520683, 'Thomas', 1, 'Proc', 't.proc@bws-hofheim.de', ''),
(100, 'g.raimondi@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '14170da7c6a0fdb59b4aa1bd0682934ae2a69cce', 1363520683, 'Gian Maria', 1, 'Raimondi', 'g.raimondi@bws-hofheim.de', 'Dr.'),
(101, 'j.rippel@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '6cfd3b0dbaab09d7ffde636559043d77ad3c1b53', 1363520683, 'Jürgen Werner', 1, 'Rippel', 'j.rippel@bws-hofheim.de', ''),
(102, 'c.rueckert@online.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '649cac220b7289cdec96e4549034546de1a8e487', 1363520683, 'Christine', 1, 'Rückert', 'c.rueckert@online.de', ''),
(103, 'c.rump79@googlemail.com', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '1e3338d37a46e57792eee075a0f783342a12786d', 1363520683, 'Claudia', 1, 'Rump', 'c.rump79@googlemail.com', ''),
(104, 'h.sauer@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'dc9adada1c7306a1aabe1d562ff5f1e336e169be', 1363520683, 'Helene', 1, 'Sauer', 'h.sauer@bws-hofheim.de', ''),
(105, 'Martina.Sax@t-online.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '8f3e681716cca9af1f261715ed3f78365efe6eba', 1363520683, 'Martina', 1, 'Sax', 'Martina.Sax@t-online.de', ''),
(106, 'hellmut.scheuermann@t-online.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '5e77df7c9154640e3d9986e080f16fa66902e495', 1363520683, 'Hellmut', 1, 'Scheuermann', 'hellmut.scheuermann@t-online.de', 'Dr.'),
(107, 'Fusytedata@aol.com', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '1fdb5cb186883ac9434b542ef62a0a3155180e35', 1363520683, 'Aloisius', 1, 'Schirra', 'Fusytedata@aol.com', ''),
(108, 'j.schirra@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'd5c69a46af77859b661ab9c178077572f5932c44', 1363520683, 'Joachim', 1, 'Schirra', 'j.schirra@bws-hofheim.de', ''),
(109, 'Kerstin.Schubert@bigpond.com', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'd1ed98153f5db2fa6d55a2000f530da419559ae8', 1363520683, 'Kerstin', 1, 'Schubert', 'Kerstin.Schubert@bigpond.com', ''),
(110, 'i.schuster@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'f53e15e91158d955d7a9e449b87fdc83ffea403e', 1363520683, 'Irene', 1, 'Schuster', 'i.schuster@bws-hofheim.de', ''),
(111, 'stefan.schymalla@web.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '14ac1e29b6a1e260bae301948ecd7ebbc8bc9413', 1363520683, 'Stefan', 1, 'Schymalla', 'stefan.schymalla@web.de', ''),
(112, 'e-secer@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '0b05d0eac2fbda206b9769186b75c3ea347f146b', 1363520683, 'Ebru', 1, 'Secer', 'e-secer@gmx.de', ''),
(113, 'nadja.theviot@googlemail.com', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '120de5b08878b655fff08abe769ecf56bb77b850', 1363520683, 'Nadja', 1, 'Theviot', 'nadja.theviot@googlemail.com', ''),
(114, 'j.tieke@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'a5fa8ee5b23056e86c053fd76020b35e1dd1e529', 1363520683, 'Jan Wilhelm', 1, 'Tieke', 'j.tieke@bws-hofheim.de', ''),
(115, 'p.tripp@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'ac6829f940521e1d77ae393db16ea9026692cce9', 1363520683, 'Peter', 1, 'Tripp', 'p.tripp@bws-hofheim.de', ''),
(116, 'elketrueck@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '46762890d905b65c089cc601bbb6557b750afa5a', 1363520683, 'Elke', 1, 'Trück-Eichenauer', 'elketrueck@gmx.de', ''),
(117, 'animei@gmx.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'c41e8c37e1461215d4b74f3b9de1d0bd84535b10', 1363520684, 'Günter', 1, 'Ullmer', 'animei@gmx.de', ''),
(118, 'uwesusanne@t-online.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '2fa41e5608e6eb6f274ad16ad51b537024817e1f', 1363520684, 'Susanne', 1, 'Urban', 'uwesusanne@t-online.de', ''),
(119, 'thilo.vester@freenet.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '8c97351965bfe180cbaeeb2ab0f86d6397151e0f', 1363520684, 'Thilo', 1, 'Vester', 'thilo.vester@freenet.de', ''),
(120, 's.walker@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '87b769134d1d017fd70eb69d3a4e9f43e0476788', 1363520684, 'Sabine', 1, 'Walker', 's.walker@bws-hofheim.de', 'Dr.'),
(121, 'm.weigand@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', 'ec11488a6550f7bf200da0117ab9feb47dcc5a91', 1363520684, 'Marco', 1, 'Weigand', 'm.weigand@bws-hofheim.de', ''),
(122, 'n.wild@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '5313271a1c102d7c90f2b3883badefaa6db41c82', 1363520684, 'Norbert', 1, 'Wild', 'n.wild@bws-hofheim.de', ''),
(123, 'm.zeh@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '4f3992662cde102fabf236746fc100f14c77dc0f', 1363520684, 'Michael', 1, 'Zeh', 'm.zeh@bws-hofheim.de', ''),
(124, 'eva.nagy@web.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '5263936da605ae2f888337df35e229e12ca66da2', 1363520684, 'Eva', 1, 'Zinnbauer', 'eva.nagy@web.de', ''),
(125, 'j.zoell@bws-hofheim.de', 'cfdd744ece87445cf47f1f0d797977f0de6679f1223a867ff9fc80698de2b3b06f516df548c495ab0b4bc280547edd75e9e2b5d35f8e7a4b9385b6b333a43ae0', '9c8b253f0f9defb74d514a76fda39ea6c2c64a3b', 1363520684, 'Jürgen', 1, 'Zöll', 'j.zoell@bws-hofheim.de', ''),
(126, 'oeman@oeman.de', '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609', 'cc0787b887a9a65bf8eeaf7f88eb20829b5be740', 1363596202, 'Ölölölölö', 1, 'ölölö', 'oeman@oeman.de', NULL),
(127, 'olololo@olololol.de', '76bcf731bd40c23ad8436e64f3badc52085b7dfb61a712e9e09eabf8890843f107e20c4c279af0453ff91c7c504139d3ed4e6329ab00d1fb31a1b88330502609', '43ee5d83b1a463b9e36f0f8281ee5daa28cfed60', 1363596395, 'olololololollol', 1, 'olololololo', 'olololo@olololol.de', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Daten für Tabelle `user_role`
--

INSERT INTO `user_role` (`id`, `role_id`, `user_id`) VALUES
(0, 0, 1),
(5, 3, 28),
(6, 2, 29),
(7, 1, 30),
(8, 3, 31),
(9, 2, 32),
(10, 3, 33),
(15, 3, 38),
(19, 3, 26),
(20, 3, 39),
(21, 2, 40),
(22, 2, 41),
(23, 2, 42),
(24, 2, 43),
(25, 2, 44),
(26, 2, 45),
(27, 2, 46),
(28, 2, 47),
(29, 2, 48),
(30, 2, 49),
(31, 2, 50),
(32, 2, 51),
(33, 2, 52),
(34, 2, 53),
(35, 2, 54),
(36, 2, 55),
(37, 2, 56),
(38, 2, 57),
(39, 2, 58),
(40, 2, 59),
(41, 2, 60),
(42, 2, 61),
(43, 2, 62),
(44, 2, 63),
(45, 2, 64),
(46, 2, 65),
(47, 2, 66),
(48, 2, 67),
(49, 2, 68),
(50, 2, 69),
(51, 2, 70),
(52, 2, 71),
(53, 2, 72),
(54, 2, 73),
(55, 2, 74),
(56, 2, 75),
(57, 2, 76),
(58, 2, 77),
(59, 2, 78),
(60, 2, 79),
(61, 2, 80),
(62, 2, 81),
(63, 2, 82),
(64, 2, 83),
(65, 2, 84),
(66, 2, 85),
(67, 2, 86),
(68, 2, 87),
(69, 2, 88),
(70, 2, 89),
(71, 2, 90),
(72, 2, 91),
(73, 2, 92),
(74, 2, 93),
(75, 2, 94),
(76, 2, 95),
(77, 2, 96),
(78, 2, 97),
(79, 2, 98),
(80, 2, 99),
(81, 2, 100),
(82, 2, 101),
(83, 2, 102),
(84, 2, 103),
(85, 2, 104),
(86, 2, 105),
(87, 2, 106),
(88, 2, 107),
(89, 2, 108),
(90, 2, 109),
(91, 2, 110),
(92, 2, 111),
(93, 2, 112),
(94, 2, 113),
(95, 2, 114),
(96, 2, 115),
(97, 2, 116),
(98, 2, 117),
(99, 2, 118),
(100, 2, 119),
(101, 2, 120),
(102, 2, 121),
(103, 2, 122),
(104, 2, 123),
(105, 2, 124),
(106, 2, 125),
(107, 2, 126),
(108, 2, 127);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_dateTime1` FOREIGN KEY (`dateTime_id`) REFERENCES `dateTime` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_parent_child1` FOREIGN KEY (`parent_child_id`) REFERENCES `parent_child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `dateTime`
--
ALTER TABLE `dateTime`
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
