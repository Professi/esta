-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Mrz 2013 um 15:35
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
  `parent_child_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `date_id` int(11) NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`,`parent_child_id`,`user_id`,`date_id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_appointment_parent_child1` (`parent_child_id`),
  KEY `fk_appointment_user1` (`user_id`),
  KEY `fk_appointment_date1` (`date_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `child`
--

CREATE TABLE IF NOT EXISTS `child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `class` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `firstname` (`firstname`,`lastname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `parent_child`
--

CREATE TABLE IF NOT EXISTS `parent_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`child_id`,`user_id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_parent_child_child1` (`child_id`),
  KEY `fk_parent_child_user1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`id`, `title`, `description`) VALUES
(0, 'Administration', 'Administration'),
(1, 'Verwaltung', 'Verwaltung'),
(2, 'Eltern', 'Eltern'),
(3, 'Lehrer', 'Lehrkräfte');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 NOT NULL,
  `salt` varchar(128) CHARACTER SET utf8 NOT NULL,
  `activationKey` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(45) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `lastname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `activationKey`, `createtime`, `firstname`, `status`, `lastname`, `email`) VALUES
(1, 'admin', '9ef83c6bcdd14d6fb478b5e9e0115bfe9b96782c0720758fde78a7613cbdcff20a8c0395da4c2a6ec71ab84a48f7656f441d45eaaba545cf8ebd51f430955398', 'wCEprK5Cv8cd8XKWAIiRoFtFUyX5g6GzutjFUZsCrrSLqYpfNyOlzj7Rhoj8iZKEz95D+rwSL2exuk+hYSYrCw==', '', 1362419867, '', 1, '', ''),
(2, 'demo', '0baa41540b3b4fe5abaf39be2245904bc038a577ae21b5d325161efeb6ec8ce4664f31e791bbebdce50ab3485210ffb5c950dcbf2c866cc3ce85ef3e3bed76a2', 'd52iHYyObLWXT6Z2G46YLNYOQu5/uk14XK7ed7BfUrMXi6GeypL9MN0M7PpzKNS+MAg/AoI4tlJHLDGUgKo+Ow==', '', 1362419867, '', -2, '', ''),
(3, 'c.ehringfeld@t-onlin', '051a1dcb9ed33d56237ccd4af7cc0280057f68e83dfb0d78ddebc5fc9356461b1706f32456d1b27cb9c0d77bf3a332a7eab1b19160894073b79fa3ca3db360d6', 'Dplj8EpxwNZ9nitnT6dg+C6mydn9KlBSdsEMxtAUAP3/ol8pEWvl3SYXJuNt8TIHsaphKBwUjmLi53thPdWArg==', 'adf3a57ea8ca142981007a3c53426e59b19b7566f64d8e37b83e4683d6142020612932f852488b2dbe4c2183215c1cc89f2e716eba0b41adadfc8e82de9a9cc1', 1362500376, '', 1, '', ''),
(4, 'Demo_44398_0', '8156477cd03e09199b20e78492e6aa5d087be42648ca8b40ca917930acc36ea042146b961ca1340e2c1599a7daa30ebe804d60aefca8cdbd32c873ac0578a92e', '2shXD5D+ySzY0c/sSfH2iwfXV4NUuR5HELKBJuXYMWaFXHQW9jrZ1r/IdKN1HLjp681HJTeMKSWjYEAmE/fLzQ==', '', 1362502596, '', 1, '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_user_role_user` (`user_id`),
  KEY `fk_user_role_role1` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(2, 3),
(4, 1);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_parent_child1` FOREIGN KEY (`parent_child_id`) REFERENCES `parent_child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appointment_date1` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_user_role_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_role_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
