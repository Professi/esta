SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `appointment` (
`id` int(11) NOT NULL,
  `parent_child_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dateAndTime_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `blockedAppointment`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `blockedAppointment` (
`id` int(11) NOT NULL,
  `reason` text,
  `dateAndTime_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `child`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `child` (
`id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `configs`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `configs` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `role`
--

INSERT INTO `configs` (`key`, `value`) VALUES
('appName','Elternsprechtag'),
('adminEmail','example@schooldomain.de'),
('allowTeachersToManageOwnRooms','1'),
('hashCost','13'),
('fromMail','ESTA-School'),
('schoolName','Schoolname'),
('maxChild','3'),
('tanSize','6'),
('maxTanGen','100'),
('maxAppointmentsPerChild','5'),
('defaultTeacherPassword','DONNERSTAG01'),
('randomTeacherPassword','0'),
('minLengthPerAppointment','5'),
('banUsers','1'),
('durationTempBans','5'),
('maxAttemptsForLogin','5'),
('allowBlockingAppointments','1'),
('allowBlockingOnlyForManagement','1'),
('appointmentBlocksPerDate','2'),
('lengthReasonAppointmentBlocked','5'),
('schoolStreet','Street'),
('schoolCity','PostalCode Place'),
('schoolTele','Phone'),
('schoolFax','Fax'),
('schoolEmail','office@schooldomain.de'),
('useSchoolEmailForContactForm','1'),
('lockRegistration','0'),
('allowGroups','0'),
('logoPath','/img/logo.png'),
('schoolWebsiteLink','schooldomain.de'),
('emailHost','exampleHost.de'),
('fromMailHost','esta'),
('smtpAuth','false'),
('smtpPort','25'),
('smtpSecure',''),
('smtpPassword','your_password'),
('language','de'),
('teacherAllowBlockTeacherApps', '0'),
('allowTeachersToCreateAppointments', '0'),
('allowParentsToManageChilds','1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `date`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE `date` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `begin` time NOT NULL,
  `end` time NOT NULL,
  `lockAt` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dateAndTime`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE `dateAndTime` (
  `id` int(11) NOT NULL,
  `time` time NOT NULL,
  `date_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `date_has_group`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `date_has_group` (
`id` int(11) NOT NULL,
  `date_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `group` (
`id` int(11) NOT NULL,
  `groupname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `parent_child`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `parent_child` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tan`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `tan` (
  `tan` varchar(255) NOT NULL,
  `used` tinyint(1) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `child_id` int(11) DEFAULT NULL,
  `used_by_user_id` int(11) DEFAULT NULL,
  `generatedOn` DATETIME NULL, 
  `generatedBy` int(11) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `activationKey` varchar(255) NOT NULL,
  `createtime` bigint(20) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `state` smallint(6) DEFAULT NULL,
  `lastLogin` bigint(20) DEFAULT '0',
  `role` smallint(6) NOT NULL,
  `badLogins` smallint(6) DEFAULT '0',
  `bannedUntil` bigint(20) DEFAULT '0',
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`,`role`,`email`, `activationKey`, `createtime`, `firstname`, `lastname`, `title`, `state`, `lastLogin`, `badLogins`, `bannedUntil`, `password`) VALUES
(0, 0,'admin', '9848a467b94293fcbdb5f08f36d68f5fd5544113', 0, 'Admin', 'Admin', NULL, 1, 0, 0, 0, '$2a$13$hwK.QA5hXUg94isY0kP6AuERtW7A5yJkjvh3IEXClunnLB.8GM.ju');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_has_group`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `user_has_group` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `YiiCache`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `YiiCache` (
  `id` varchar(255) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `value` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `YiiSession`
--
-- Erstellt am: 31. Jul 2014 um 15:56
--

CREATE TABLE IF NOT EXISTS `YiiSession` (
  `id` varchar(255) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_has_room` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `date_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_appointment_2` (`parent_child_id`,`user_id`,`dateAndTime_id`), ADD KEY `appointment_fk2` (`user_id`), ADD KEY `appointment_fk3` (`dateAndTime_id`);

--
-- Indexes for table `blockedAppointment`
--
ALTER TABLE `blockedAppointment`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_blockedAppointment` (`dateAndTime_id`,`user_id`), ADD KEY `blockedAppointment_fk2` (`user_id`);

--
-- Indexes for table `child`
--
ALTER TABLE `child`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
 ADD PRIMARY KEY (`key`);

--
-- Indexes for table `date`
--
ALTER TABLE `date`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dateAndTime`
--
ALTER TABLE `dateAndTime`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_dateAndTime_date_id_time` (`time`,`date_id`), ADD KEY `dateAndTime_fk1` (`date_id`);

--
-- Indexes for table `date_has_group`
--
ALTER TABLE `date_has_group`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_date_has_group1` (`date_id`,`group_id`), ADD KEY `date_has_group_fk2` (`group_id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_group_name` (`groupname`);

--
-- Indexes for table `parent_child`
--
ALTER TABLE `parent_child`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_parentChild_unq1` (`user_id`,`child_id`), ADD KEY `parent_child_fk1` (`child_id`);

ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tan`
--
ALTER TABLE `tan`
 ADD UNIQUE KEY `tan` (`tan`), ADD KEY `tan_fk1` (`group_id`), ADD KEY `tan_fk2` (`child_id`), ADD KEY `tan_fk3` (`used_by_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_user_email` (`email`);

--
-- Indexes for table `user_has_group`
--
ALTER TABLE `user_has_group`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_user_has_group1` (`user_id`,`group_id`), ADD KEY `user_has_group_fk2` (`group_id`);

ALTER TABLE `user_has_room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_user_has_room1` (`user_id`,`room_id`,`date_id`),
  ADD KEY `user_has_room_fk2` (`room_id`),
  ADD KEY `user_has_room_fk3` (`date_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blockedAppointment`
--
ALTER TABLE `blockedAppointment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `child`
--
ALTER TABLE `child`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `date`
--
ALTER TABLE `date`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dateAndTime`
--
ALTER TABLE `dateAndTime`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `date_has_group`
--
ALTER TABLE `date_has_group`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parent_child`
--
ALTER TABLE `parent_child`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_has_group`
--
ALTER TABLE `user_has_group`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_has_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


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
ADD CONSTRAINT `tan_fk3` FOREIGN KEY (`used_by_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
ADD CONSTRAINT `tan_fk1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
ADD CONSTRAINT `tan_fk2` FOREIGN KEY (`child_id`) REFERENCES `child` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
ADD CONSTRAINT `tan_fk4` FOREIGN KEY (`generatedBy_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `user_has_group`
--
ALTER TABLE `user_has_group`
ADD CONSTRAINT `user_has_group_fk2` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `user_has_group_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `user_has_room`
  ADD CONSTRAINT `user_has_room_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_has_room_fk2` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_has_room_fk3` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
