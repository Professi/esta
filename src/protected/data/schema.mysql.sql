-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. Mrz 2013 um 18:30
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
  `date_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_child_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
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
  `durationPerAppointment` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `parent_child`
--

CREATE TABLE IF NOT EXISTS `parent_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `timestamp`, `lastname`, `firstname`, `email`) VALUES
(1, 1, '2013-03-04 17:57:47', 'admin', 'admin', 'webmaster@example.com'),
(2, 2, '2013-03-04 17:57:47', 'demo', 'demo', 'demo@example.com'),
(3, 3, '0000-00-00 00:00:00', 'Ehringfeld', 'Christian', 'c.ehringfeld@t-online.de'),
(4, 4, '0000-00-00 00:00:00', 'Demo_44398_0', 'Demo_44398_0', 'e@mail.de');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profile_field`
--

CREATE TABLE IF NOT EXISTS `profile_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `hint` text NOT NULL,
  `field_type` varchar(50) NOT NULL DEFAULT '',
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(255) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  `related_field_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `profile_field`
--

INSERT INTO `profile_field` (`id`, `varname`, `title`, `hint`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `position`, `visible`, `related_field_name`) VALUES
(1, 'email', 'E-Mail', '', 'VARCHAR', 255, 0, 1, '', '', '', 'CEmailValidator', '', 0, 3, ''),
(2, 'firstname', 'First name', '', 'VARCHAR', 255, 0, 1, '', '', '', '', '', 0, 3, ''),
(3, 'lastname', 'Last name', '', 'VARCHAR', 255, 0, 1, '', '', '', '', '', 0, 3, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `membership_priority` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL COMMENT 'Price (when using membership module)',
  `duration` int(11) DEFAULT NULL COMMENT 'How long a membership is valid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`id`, `title`, `description`, `membership_priority`, `price`, `duration`) VALUES
(0, 'Administration', 'Administration', NULL, NULL, NULL),
(1, 'Verwaltung', 'Verwaltung', NULL, NULL, NULL),
(2, 'Eltern', 'Eltern', NULL, NULL, NULL),
(3, 'Lehrer', 'Lehrkräfte', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `translation`
--

CREATE TABLE IF NOT EXISTS `translation` (
  `message` varbinary(255) NOT NULL,
  `translation` varchar(255) NOT NULL,
  `language` varchar(5) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`message`,`language`,`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `translation`
--

INSERT INTO `translation` (`message`, `translation`, `language`, `category`) VALUES
('About', 'Über', 'de', 'yum'),
('Access control', 'Zugangskontrolle', 'de', 'yum'),
('Action', 'Aktion', 'de', 'yum'),
('Actions', 'Aktionen', 'de', 'yum'),
('Activated', 'erstmalig Aktiviert', 'de', 'yum'),
('Active', 'Aktiv', 'de', 'yum'),
('Active - First visit', 'Aktiv - erster Besuch', 'de', 'yum'),
('Active users', 'Aktive Benutzer', 'de', 'yum'),
('Activities', 'Aktivitäten', 'de', 'yum'),
('Add as a friend', 'Zur Kontaktliste hinzufügen', 'de', 'yum'),
('Admin inbox', 'Administratorposteingang', 'de', 'yum'),
('Admin sent messages', 'Gesendete Nachrichten des Administrators', 'de', 'yum'),
('Admin users', 'Administratoren', 'de', 'yum'),
('Admin users can not be deleted!', 'Administratoren können nicht gelöscht werden', 'de', 'yum'),
('All', 'Alle', 'de', 'yum'),
('Allow profile comments', 'Profilkommentare erlauben', 'de', 'yum'),
('Allowed are lowercase letters and digits.', 'Erlaubt sind Kleinbuchstaben und Ziffern.', 'de', 'yum'),
('Allowed roles', 'Erlaubte Rollen', 'de', 'yum'),
('Allowed users', 'Erlaubte Benutzer', 'de', 'yum'),
('Already exists.', 'Existiert bereits.', 'de', 'yum'),
('An error occured while saving your changes', 'Es ist ein Fehler aufgetreten.', 'de', 'yum'),
('An error occured while uploading your avatar image', 'Ein Fehler ist beim hochladen ihres Profilbildes aufgetreten', 'de', 'yum'),
('Answer', 'Antworten', 'de', 'yum'),
('Appear in search', 'In der Suche erscheinen', 'de', 'yum'),
('Are you really sure you want to delete your Account?', 'Sind Sie Sicher, dass Sie Ihren Zugang löschen wollen?', 'de', 'yum'),
('Are you sure to delete this item?', 'Sind Sie sicher, dass Sie dieses Element wirklich löschen wollen? ', 'de', 'yum'),
('Are you sure to remove this comment from your profile?', 'Sind Sie sicher, dass sie diesen Kommentar entfernen wollen?', 'de', 'yum'),
('Are you sure you want to remove this friend?', 'Sind Sie sicher, dass Sie diesen Kontakt aus ihrer Liste entfernen wollen?', 'de', 'yum'),
('Assign this role to new users automatically', 'Rolle automatisch an neue Benutzer zuweisen', 'de', 'yum'),
('Automatically extend subscription', 'Mitgliedschaft automatisch verlängern', 'de', 'yum'),
('Avatar image', 'Profilbild', 'de', 'yum'),
('Back', 'Zurück', 'de', 'yum'),
('Back to inbox', 'Zurück zum Posteingang', 'de', 'yum'),
('Back to my Profile', 'Zurück zu meinem Profil', 'de', 'yum'),
('Back to profile', 'Zurück zum Profil', 'de', 'yum'),
('Banned', 'Verbannt', 'de', 'yum'),
('Banned users', 'Gesperrte Benuter', 'de', 'yum'),
('Browse', 'Durchsuchen', 'de', 'yum'),
('Browse logged user activities', 'Benutzeraktivitäten', 'de', 'yum'),
('Browse memberships', 'Mitgliedschaften kaufen', 'de', 'yum'),
('Browse user activities', 'Tätigkeitenhistorie', 'de', 'yum'),
('Browse user groups', 'Benutzergruppen durchsuchen', 'de', 'yum'),
('Browse usergroups', 'Gruppen durchsuchen', 'de', 'yum'),
('Browse users', 'Benutzer durchsuchen', 'de', 'yum'),
('Cancel', 'Abbrechen', 'de', 'yum'),
('Cancel deletion', 'Löschvorgang abbrechen', 'de', 'yum'),
('Cancel request', 'Anfrage zurückziehen', 'de', 'yum'),
('Cancel subscription', 'Mitgliedschaft beenden', 'de', 'yum'),
('Category', 'Kategorie', 'de', 'yum'),
('Change admin Password', 'Administratorpasswort ändern', 'de', 'yum'),
('Change password', 'Passwort ändern', 'de', 'yum'),
('Changes', 'Änderungen', 'de', 'yum'),
('Changes are saved', 'Änderungen wurden gespeichert.', 'de', 'yum'),
('Changes is saved.', 'Änderungen wurde gespeichert.', 'de', 'yum'),
('Choose All', 'Alle auswählen', 'de', 'yum'),
('City', 'Stadt', 'de', 'yum'),
('Click here to respond to {username}', 'Klicke hier, um {username} zu antworten', 'de', 'yum'),
('Column Field type in the database.', 'Spaltentyp in der Datenbank', 'de', 'yum'),
('Comment', 'Kommentar', 'de', 'yum'),
('Compose', 'Nachricht schreiben', 'de', 'yum'),
('Compose new message', 'Nachricht schreiben', 'de', 'yum'),
('Composing new message', 'Nachricht schreiben', 'de', 'yum'),
('Confirm', 'Bestätigen', 'de', 'yum'),
('Confirm deletion', 'Löschvorgang bestätigen', 'de', 'yum'),
('Confirmation pending', 'Bestätigung ausstehend', 'de', 'yum'),
('Content', 'Inhalt', 'de', 'yum'),
('Create', 'Anlegen', 'de', 'yum'),
('Create Profile Field', 'Profilfeld anlegen', 'de', 'yum'),
('Create Role', 'Rolle anlegen', 'de', 'yum'),
('Create User', 'Benutzer anlegen', 'de', 'yum'),
('Create Usergroup', 'Neue Gruppe erstellen', 'de', 'yum'),
('Create my profile', 'Mein Profil anlegen', 'de', 'yum'),
('Create new Translation', 'Neue Übersetzung erstellen', 'de', 'yum'),
('Create new User', 'Neuen Benutzer anlegen', 'de', 'yum'),
('Create new Usergroup', 'Neue Gruppe erstellen', 'de', 'yum'),
('Create new action', 'Neue Aktion', 'de', 'yum'),
('Create new field group', 'Neue Feldgruppe erstellen', 'de', 'yum'),
('Create new payment type', 'Neue Zahlungsart hinzufügen', 'de', 'yum'),
('Create new role', 'Neue Rolle anlegen', 'de', 'yum'),
('Create new settings profile', 'Neues Einstellungsprofil erstellen', 'de', 'yum'),
('Create new usergroup', 'Neue Gruppe erstellen', 'de', 'yum'),
('Create payment type', 'Zahlungsart anlegen', 'de', 'yum'),
('Create profile field', 'Ein neues Profilfeld erstellen', 'de', 'yum'),
('Create role', 'Neue Rolle anlegen', 'de', 'yum'),
('Create user', 'Benutzer anlegen', 'de', 'yum'),
('Date', 'Datum', 'de', 'yum'),
('Default', 'Default', 'de', 'yum'),
('Delete Account', 'Zugang löschen', 'de', 'yum'),
('Delete User', 'Benutzer löschen', 'de', 'yum'),
('Delete account', 'Zugang löschen', 'de', 'yum'),
('Delete message', 'Nachricht löschen', 'de', 'yum'),
('Deleted', 'Gelöscht', 'de', 'yum'),
('Deny', 'Ablehnen', 'de', 'yum'),
('Description', 'Beschreibung', 'de', 'yum'),
('Different users logged in today', 'Anzahl der heute angemeldeten Benutzer', 'de', 'yum'),
('Different viewn Profiles', 'Insgesamt betrachtete Profile', 'de', 'yum'),
('Display order of fields.', 'Reihenfolgenposition, in der das Feld angezeigt wird', 'de', 'yum'),
('Display order of group.', 'Anzeigereihenfolge der Gruppe.', 'de', 'yum'),
('Do not appear in search', 'Nicht in der Suche erscheinen', 'de', 'yum'),
('Do not show my online status', 'Status verstecken', 'de', 'yum'),
('Do not show the owner of a profile when i visit him', 'Niemandem zeigen, wen ich besucht habe', 'de', 'yum'),
('Downgrade to {role}', 'Wechsle auf {role}', 'de', 'yum'),
('Duration in days', 'Gültigkeitsdauer in Tagen', 'de', 'yum'),
('E-Mail address', 'E-Mail Adresse', 'de', 'yum'),
('E-mail', 'E-mail', 'de', 'yum'),
('Edit', 'Bearbeiten', 'de', 'yum'),
('Edit personal data', 'Persönliche Daten bearbeiten', 'de', 'yum'),
('Edit profile', 'Profil bearbeiten', 'de', 'yum'),
('Edit profile field', 'Profilfeld bearbeiten', 'de', 'yum'),
('Edit this role', 'Diese Rolle bearbeiten', 'de', 'yum'),
('Email is incorrect.', 'E-Mail ist nicht korrekt.', 'de', 'yum'),
('Enable Captcha', 'Captcha Überprüfung aktivieren', 'de', 'yum'),
('Enable Email Activation', 'Aktivierung per E-Mail einschalten', 'de', 'yum'),
('Enable Profile History', 'Profilhistorie einschalten', 'de', 'yum'),
('Enable Recovery', 'Wiederherstellung einschalten', 'de', 'yum'),
('Enable Registration', 'Registrierung einschalten', 'de', 'yum'),
('End date', 'Enddatum', 'de', 'yum'),
('Ends at', 'Endet am', 'de', 'yum'),
('Error Message', 'Fehlermeldung', 'de', 'yum'),
('Error message when Validation fails.', 'Fehlermeldung falls die Validierung fehlschlägt', 'de', 'yum'),
('Error while processing new avatar image : {error_message}; File was uploaded without resizing', 'Das Bild konnte nicht richtig skaliert werden: {error_message}. Es wurde trotzdem erfolgreich hochgeladen und in ihrem Profil aktiviert.', 'de', 'yum'),
('Expired', 'Abgelaufen', 'de', 'yum'),
('Field', 'Feld', 'de', 'yum'),
('Field Size', 'Feldgröße', 'de', 'yum'),
('Field Size min', 'min Feldgröße', 'de', 'yum'),
('Field Type', 'Feldtyp', 'de', 'yum'),
('Field group', 'Feldgruppe', 'de', 'yum'),
('Field name on the language of "sourceLanguage".', 'Feldname in der Ursprungssprache', 'de', 'yum'),
('Field size', 'Feldgröße', 'de', 'yum'),
('Field size in the database.', 'Feldgröße in der Datenbank', 'de', 'yum'),
('Field type', 'Feldtyp', 'de', 'yum'),
('Fields with <span class="required">*</span> are required.', 'Felder mit <span class="required">*</span> sind Pflichtfelder.', 'de', 'yum'),
('First name', 'Vorname', 'de', 'yum'),
('For all', 'Für alle', 'de', 'yum'),
('Friends', 'Kontakte', 'de', 'yum'),
('Friends of {username}', 'Kontakte von {username}', 'de', 'yum'),
('Friendship', 'Kontakt', 'de', 'yum'),
('Friendship confirmed', 'Freundschaft bestätigt', 'de', 'yum'),
('Friendship rejected', 'Kontaktanfrage abgelehnt', 'de', 'yum'),
('Friendship request already sent', 'Kontaktbestätigung ausstehend', 'de', 'yum'),
('Friendship request for {username} has been sent', 'Kontaktanfrage an {username} gesendet', 'de', 'yum'),
('Friendship request has been rejected', 'Kontaktanfrage zurückgewiesen', 'de', 'yum'),
('From', 'Von', 'de', 'yum'),
('General', 'Allgemein', 'de', 'yum'),
('Generate Demo Data', 'Zufallsbenutzer erzeugen', 'de', 'yum'),
('Go to profile of {username}', 'Zum Profil von {username}', 'de', 'yum'),
('Grant permission', 'Berechtigung zuweisen', 'de', 'yum'),
('Group Name', 'Gruppenname', 'de', 'yum'),
('Group name on the language of "sourceLanguage".', 'Gruppenname in der Basissprache.', 'de', 'yum'),
('Group owner', 'Gruppeneigentümer', 'de', 'yum'),
('Group title', 'Titel der Gruppe', 'de', 'yum'),
('Having', 'Anzeigen', 'de', 'yum'),
('Hidden', 'Verstecken', 'de', 'yum'),
('How expensive is a membership?', 'Preis der Mitgliedschaft', 'de', 'yum'),
('How many days will the membership be valid after payment?', 'Wie viele Tage ist die Mitgliedschaft nach Zahlungseingang gültig?', 'de', 'yum'),
('Ignore', 'Ignorieren', 'de', 'yum'),
('Ignored users', 'Ignorierliste', 'de', 'yum'),
('Inactive users', 'Inaktive Benutzer', 'de', 'yum'),
('Incorrect activation URL.', 'Falsche Aktivierungs URL.', 'de', 'yum'),
('Incorrect password (minimal length 4 symbols).', 'Falsches Passwort (minimale Länge 4 Zeichen).', 'de', 'yum'),
('Incorrect recovery link.', 'Recovery link ist falsch.', 'de', 'yum'),
('Incorrect symbol''s. (A-z0-9)', 'Im Benutzernamen sind nur Buchstaben und Zahlen erlaubt.', 'de', 'yum'),
('Incorrect username (length between 3 and 20 characters).', 'Falscher Benutzername (Länge zwischen 3 und 20 Zeichen).', 'de', 'yum'),
('Instructions have been sent to you. Please check your email.', 'Weitere Anweisungen wurden an ihr E-Mail Postfach geschickt. Bitte prüfen Sie ihre E-Mails', 'de', 'yum'),
('Invalid recovery key', 'Fehlerhafter Wiederherstellungsschlüssel', 'de', 'yum'),
('Invitation', 'Einladung', 'de', 'yum'),
('Is membership possible', 'Mitgliedschaft möglich?', 'de', 'yum'),
('Join group', 'Beitreten', 'de', 'yum'),
('Jump to profile', 'Zum Profil', 'de', 'yum'),
('Language', 'Sprache', 'de', 'yum'),
('Last name', 'Nachname', 'de', 'yum'),
('Last visit', 'Letzter Besuch', 'de', 'yum'),
('Leave group', 'Gruppe verlassen', 'de', 'yum'),
('Let me appear in the search', 'Ich möchte in der Suche erscheinen', 'de', 'yum'),
('Let the user choose in privacy settings', 'Den Benutzer entscheiden lassen', 'de', 'yum'),
('Letters are not case-sensitive.', 'Zwischen Groß-und Kleinschreibung wird nicht unterschieden.', 'de', 'yum'),
('List roles', 'Rollen anzeigen', 'de', 'yum'),
('List user', 'Benutzer auflisten', 'de', 'yum'),
('List users', 'Benutzer anzeigen', 'de', 'yum'),
('Log profile visits', 'Meine Profilbesuche anzeigen', 'de', 'yum'),
('Logged in as', 'Angemeldet als', 'de', 'yum'),
('Login', 'Anmeldung', 'de', 'yum'),
('Login Type', 'Anmeldungsart', 'de', 'yum'),
('Login allowed by Email and Username', 'Anmeldung per Benutzername oder E-Mail adresse', 'de', 'yum'),
('Login allowed only by Email', 'Anmeldung nur per E-Mail adresse', 'de', 'yum'),
('Login allowed only by Username', 'Anmeldung nur per Benutzername', 'de', 'yum'),
('Login is not possible with the given credentials', 'Anmeldung mit den angegebenen Werten nicht möglich', 'de', 'yum'),
('Logout', 'Abmelden', 'de', 'yum'),
('Lost password?', 'Passwort vergessen?', 'de', 'yum'),
('Mail send method', 'Nachrichtenversandmethode', 'de', 'yum'),
('Make {field} public available', 'Das Feld {field} öffentlich machen', 'de', 'yum'),
('Manage', 'Verwalten', 'de', 'yum'),
('Manage Profile Field', 'Profilfeld verwalten', 'de', 'yum'),
('Manage Profile Fields', 'Profilfelder verwalten', 'de', 'yum'),
('Manage Profiles', 'Profile verwalten', 'de', 'yum'),
('Manage Roles', 'Rollenverwaltung', 'de', 'yum'),
('Manage User', 'Benutzerverwaltung', 'de', 'yum'),
('Manage Users', 'Benutzerverwaltung', 'de', 'yum'),
('Manage field groups', 'Feldgruppen verwalten', 'de', 'yum'),
('Manage friends', 'Freundschaftsverwaltung', 'de', 'yum'),
('Manage my users', 'Meine Benutzer verwalten', 'de', 'yum'),
('Manage payments', 'Zahlungsarten verwalten', 'de', 'yum'),
('Manage permissions', 'Berechtigungen verwalten', 'de', 'yum'),
('Manage profile Fields', 'Profilfelder verwalten', 'de', 'yum'),
('Manage profile fields', 'Profilfelder verwalten', 'de', 'yum'),
('Manage profiles', 'Profile verwalten', 'de', 'yum'),
('Manage roles', 'Rollen verwalten', 'de', 'yum'),
('Manage text settings', 'Texteinstellungen', 'de', 'yum'),
('Manage this profile', 'dieses Profil bearbeiten', 'de', 'yum'),
('Manage user Groups', 'Benutzergruppen verwalten', 'de', 'yum'),
('Manage users', 'Benutzer verwalten', 'de', 'yum'),
('Mange Profile Field', 'Mange Profil Field', 'de', 'yum'),
('Mark as read', 'Als gelesen markieren', 'de', 'yum'),
('Match', 'Treffer', 'de', 'yum'),
('Membership', 'Mitgliedschaft', 'de', 'yum'),
('Membership ends at: {date}', 'Mitgliedschaft endet am: {date}', 'de', 'yum'),
('Membership has not been payed yet', 'Zahlungseingang noch nicht erfolgt', 'de', 'yum'),
('Membership payed at: {date}', 'Zahlungseingang erfolgt am: {date}', 'de', 'yum'),
('Memberships', 'Mitgliedschaften', 'de', 'yum'),
('Message', 'Nachricht', 'de', 'yum'),
('Message "{message}" has been sent to {to}', 'Nachricht "{message}" wurde an {to} gesendet', 'de', 'yum'),
('Message "{message}" was marked as read', 'Nachricht "{message}" wurde als gelesen markiert.', 'de', 'yum'),
('Message count', 'Anzahl Nachrichten', 'de', 'yum'),
('Message from', 'Nachricht von', 'de', 'yum'),
('Message from ', 'Nachricht von ', 'de', 'yum'),
('Messages', 'Nachrichten', 'de', 'yum'),
('Messaging system', 'Nachrichtensystem', 'de', 'yum'),
('Minimal password length 4 symbols.', 'Minimale Länge des Passworts 4 Zeichen.', 'de', 'yum'),
('Module settings', 'Moduleinstellungen', 'de', 'yum'),
('My Inbox', 'Posteingang', 'de', 'yum'),
('My friends', 'Meine Kontakte', 'de', 'yum'),
('My groups', 'Meine Gruppen', 'de', 'yum'),
('My inbox', 'Mein Posteingang', 'de', 'yum'),
('My memberships', 'Meine Mitgliedschaften', 'de', 'yum'),
('My profile', 'Mein Profil', 'de', 'yum'),
('New friendship request from {username}', 'neue Kontaktanfrage von {username}', 'de', 'yum'),
('New friendship requests', 'Neue Freundschaftsanfragen', 'de', 'yum'),
('New message from {from}: {subject}', 'Neue Nachricht von {from}: {subject}', 'de', 'yum'),
('New messages', 'Neue Nachrichten', 'de', 'yum'),
('New password', 'Neues Passwort', 'de', 'yum'),
('New password is saved.', 'Neues Passwort wird gespeichert.', 'de', 'yum'),
('New profile comment from {username}', 'Neuer Profilkommentar von {username}', 'de', 'yum'),
('New settings profile', 'Neues Einstellungsprofil', 'de', 'yum'),
('New translation', 'Neue Übersetzung', 'de', 'yum'),
('New value', 'Neuer Wert', 'de', 'yum'),
('No', 'Nein', 'de', 'yum'),
('No friendship requested', 'Keine Freundschaft angefragt', 'de', 'yum'),
('No new messages', 'Keine neuen Nachrichten', 'de', 'yum'),
('No profile changes were made', 'Keine Profiländerungen stattgefunden', 'de', 'yum'),
('No, but show on registration form', 'Ja, und auf Registrierungsseite anzeigen', 'de', 'yum'),
('Nobody has commented your profile yet', 'Bisher hat niemand mein Profil kommentiert', 'de', 'yum'),
('Nobody has visited your profile yet', 'Bisher hat noch niemand ihr Profil angesehen', 'de', 'yum'),
('None', 'Keine', 'de', 'yum'),
('Not active', 'Nicht aktiv', 'de', 'yum'),
('Not assigned', 'Nicht zugewiesen', 'de', 'yum'),
('Not yet payed', 'Noch nicht bezahlt', 'de', 'yum'),
('Ok', 'Ok', 'de', 'yum'),
('Old value', 'Alter Wert', 'de', 'yum'),
('One of the recipients ({username}) has ignored you. Message will not be sent!', 'Einer der gewählten Benutzer ({username}) hat Sie auf seiner Ignorier-Liste. Die Nachricht wird nicht gesendet!', 'de', 'yum'),
('Only owner', 'Nur Besitzer', 'de', 'yum'),
('Only your friends are shown here', 'Nur ihre Kontakte werden hier angezeigt', 'de', 'yum'),
('Order confirmed', 'Bestellbestätigung', 'de', 'yum'),
('Order date', 'Bestelldatum', 'de', 'yum'),
('Order membership', 'Mitgliedschaft bestellen', 'de', 'yum'),
('Order number', 'Bestellnummer', 'de', 'yum'),
('Ordered at', 'Bestellt am', 'de', 'yum'),
('Ordered memberships', 'Bestellte Mitgliedschaften', 'de', 'yum'),
('Other', 'Verschiedenes', 'de', 'yum'),
('Participant count', 'Anzahl Teilnehmer', 'de', 'yum'),
('Participants', 'Teilnehmer', 'de', 'yum'),
('Password', 'Passwort', 'de', 'yum'),
('Password Expiration Time', 'Ablaufzeit von Passwörtern', 'de', 'yum'),
('Password is incorrect.', 'Passwort ist falsch.', 'de', 'yum'),
('Password recovery', 'Passwort wiederherstellen', 'de', 'yum'),
('Payment', 'Zahlungsmethode', 'de', 'yum'),
('Payment arrived', 'Zahlungseingang bestätigt', 'de', 'yum'),
('Payment date', 'Bezahlt am', 'de', 'yum'),
('Payment type', 'Zahlungstyp', 'de', 'yum'),
('Payment types', 'Zahlungsarten', 'de', 'yum'),
('Payments', 'Zahlungsarten', 'de', 'yum'),
('Permissions', 'Berechtigungen', 'de', 'yum'),
('Please check your email. An instructions was sent to your email address.', 'Bitte überprüfen Sie Ihre E-Mails. Eine Anleitung wurde an Ihre E-Mail-Adresse geschickt.', 'de', 'yum'),
('Please check your email. Instructions have been sent to your email address.', 'Bitte schauen Sie in Ihr Postfach. Weitere Anweisungen wurden per E-Mail geschickt.', 'de', 'yum'),
('Please enter a request Message up to 255 characters', 'Bitte geben Sie eine Nachricht bis zu 255 Zeichen an, die dem Benutzer bei der Kontaktanfrage mitgegeben wird', 'de', 'yum'),
('Please enter the letters as they are shown in the image above.', 'Bitte geben Sie die, oben im Bild angezeigten, Buchstaben ein.', 'de', 'yum'),
('Please enter your login or email address.', 'Bitte geben Sie Ihren Benutzernamen oder E-Mail-Adresse ein.', 'de', 'yum'),
('Please enter your password to confirm deletion:', 'Bitte geben Sie Ihr Passwort ein, um den Löschvorgang zu bestätigen:', 'de', 'yum'),
('Please enter your user name or email address.', 'Bitte geben Sie Ihren Benutzernamen oder E-mail Adresse ein', 'de', 'yum'),
('Please fill out the following form with your login credentials:', 'Bitte geben Sie ihre Login-Daten ein:', 'de', 'yum'),
('Position', 'Position', 'de', 'yum'),
('Predefined values (example: 1, 2, 3, 4, 5;).', 'Vordefinierter Bereich (z.B. 1, 2, 3, 4, 5),', 'de', 'yum'),
('Preseve Profiles', 'Profile aufbewahren', 'de', 'yum'),
('Price', 'Preis', 'de', 'yum'),
('Privacy', 'Privatsphäre', 'de', 'yum'),
('Privacy settings', 'Privatsphäre', 'de', 'yum'),
('Privacy settings for {username}', 'Privatsphäreneinstellungen für {username}', 'de', 'yum'),
('Privacysettings', 'Privatsphäre', 'de', 'yum'),
('Profile', 'Profil', 'de', 'yum'),
('Profile Comments', 'Pinnwand', 'de', 'yum'),
('Profile Fields', 'Profilfelder', 'de', 'yum'),
('Profile field groups', 'Profilfeldgruppen', 'de', 'yum'),
('Profile field public options', 'Einstellungen der Profilfelder', 'de', 'yum'),
('Profile field {fieldname}', 'Profilfeld {fieldname}', 'de', 'yum'),
('Profile fields', 'Profilfeldverwaltung', 'de', 'yum'),
('Profile fields groups', 'Profilfeldgruppen', 'de', 'yum'),
('Profile history', 'Profilverlauf', 'de', 'yum'),
('Profile number', 'Profilnummer: ', 'de', 'yum'),
('Profile of ', 'Profil von ', 'de', 'yum'),
('Profile visits', 'Profilbesuche', 'de', 'yum'),
('Profiles', 'Profile', 'de', 'yum'),
('Range', 'Bereich', 'de', 'yum'),
('Read Only Profiles', 'Nur-Lese Profile', 'de', 'yum'),
('Receive a Email for new Friendship request', 'E-Mail Benachrichtigung bei neuer Kontaktanfrage', 'de', 'yum'),
('Receive a Email when a new profile comment was made', 'E-Mail Benachrichtigung bei Profilkommentar', 'de', 'yum'),
('Receive a Email when new Message arrives', 'E-Mail Benachrichtigung bei neuer interner Nachricht', 'de', 'yum'),
('Registered users', 'Registrierte Benutzer', 'de', 'yum'),
('Registration', 'Registrierung', 'de', 'yum'),
('Registration date', 'Anmeldedatum', 'de', 'yum'),
('Regular expression (example: ''/^[A-Za-z0-9s,]+$/u'').', 'Regulärer Ausdruck (z. B.: ''/^[A-Za-z0-9s,]+$/u'')', 'de', 'yum'),
('Remember me next time', 'Angemeldet bleiben', 'de', 'yum'),
('Remove', 'Entfernen', 'de', 'yum'),
('Remove Avatar', 'Profilbild entfernen', 'de', 'yum'),
('Remove comment', 'Kommentar entfernen', 'de', 'yum'),
('Remove friend', 'Freundschaft kündigen', 'de', 'yum'),
('Reply', 'Antwort', 'de', 'yum'),
('Reply to Message', 'auf diese Nachricht antworten', 'de', 'yum'),
('Request friendship for user {username}', 'Kontaktanfrage für {username}', 'de', 'yum'),
('Required', 'Benötigt', 'de', 'yum'),
('Restore', 'Wiederherstellen', 'de', 'yum'),
('Retype password', 'Passwort wiederholen', 'de', 'yum'),
('Retype password is incorrect.', 'Wiederholtes Passwort ist falsch.', 'de', 'yum'),
('Retype your new password', 'Wiederholen Sie Ihr neues Passwort', 'de', 'yum'),
('Retyped password is incorrect', 'Wiederholtes Passwort ist nicht identisch', 'de', 'yum'),
('Role Administration', 'Rollenverwaltung', 'de', 'yum'),
('Roles', 'Rollen', 'de', 'yum'),
('Roles / Access control', 'Rollen / Zugangskontrolle', 'de', 'yum'),
('Save', 'Sichern', 'de', 'yum'),
('Save payment type', 'Zahlungsart speichern', 'de', 'yum'),
('Save profile changes', 'Profiländerungen speichern', 'de', 'yum'),
('Save role', 'Rolle speichern', 'de', 'yum'),
('Search for username', 'Suche nach Benutzer', 'de', 'yum'),
('Searchable', 'Suchbar', 'de', 'yum'),
('Select a month', 'Monatsauswahl', 'de', 'yum'),
('Select multiple recipients by holding the CTRL key', 'Wählen Sie mehrere Empfänger mit der STRG-Taste aus', 'de', 'yum'),
('Select the fields that should be public', 'Diese Felder sind öffentlich einsehbar', 'de', 'yum'),
('Selectable on registration', 'Während der Registrierung wählbar', 'de', 'yum'),
('Send', 'Senden', 'de', 'yum'),
('Send a message to this User', 'Diesem Benutzer eine Nachricht senden', 'de', 'yum'),
('Send invitation', 'Kontaktanfrage senden', 'de', 'yum'),
('Send message notifier emails', 'Benachrichtigungen schicken', 'de', 'yum'),
('Sent at', 'Gesendet am', 'de', 'yum'),
('Sent messages', 'Gesendete Nachrichten', 'de', 'yum'),
('Separate usernames with comma to ignore specified users', 'Benutzernamen mit Komma trennen, um sie zu ignorieren', 'de', 'yum'),
('Set payment date to today', 'Zahlungseingang bestätigen', 'de', 'yum'),
('Settings', 'Einstellungen', 'de', 'yum'),
('Settings profiles', 'Einstellungsprofile', 'de', 'yum'),
('Show activities', 'Zeige Aktivitäten', 'de', 'yum'),
('Show administration Hierarchy', 'Hierarchie', 'de', 'yum'),
('Show friends', 'Kontaktliste veröffentlichen', 'de', 'yum'),
('Show my online status to everyone', 'Meinen Online-Status veröffentlichen', 'de', 'yum'),
('Show online status', 'Online-Status anzeigen', 'de', 'yum'),
('Show permissions', 'Berechtigungen anzeigen', 'de', 'yum'),
('Show profile visits', 'Profilbesuche anzeigen', 'de', 'yum'),
('Show roles', 'Rollen anzeigen', 'de', 'yum'),
('Show the owner when i visit his profile', 'Dem Profileigentümer erkenntlich machen, wenn ich sein Profil besuche', 'de', 'yum'),
('Show users', 'Benutzer anzeigen', 'de', 'yum'),
('Statistics', 'Benutzerstatistik', 'de', 'yum'),
('Status', 'Status', 'de', 'yum'),
('Street', 'Straße', 'de', 'yum'),
('Subject', 'Titel', 'de', 'yum'),
('Success', 'Erfolgreich', 'de', 'yum'),
('Superuser', 'Superuser', 'de', 'yum'),
('Text Email Activation', 'Text Email Konto-Aktivierung', 'de', 'yum'),
('Text Email Recovery', 'Text E-Mail Passwort wiederherstellen', 'de', 'yum'),
('Text Email Registration', 'Text E-Mail Registrierung', 'de', 'yum'),
('Text Login Footer', 'Text im Login-footer', 'de', 'yum'),
('Text Login Header', 'Text im Login-header', 'de', 'yum'),
('Text Registration Footer', 'Text im Registrierung-footer', 'de', 'yum'),
('Text Registration Header', 'Text im Registrierung-header', 'de', 'yum'),
('Text for new friendship request', 'Text für eine neue Kontaktanfrage', 'de', 'yum'),
('Text for new profile comment', 'Text für neuen Profilkommentar', 'de', 'yum'),
('Text translations', 'Übersetzungstexte', 'de', 'yum'),
('Thank you for your registration. Please check your email or login.', 'Vielen Dank für Ihre Anmeldung. Bitte überprüfen Sie Ihre E-Mails oder loggen Sie sich ein.', 'de', 'yum'),
('Thank you for your registration. Please check your email.', 'Vielen Dank für Ihre Anmeldung. Bitte überprüfen Sie Ihre E-Mails.', 'de', 'yum'),
('The comment has been saved', 'Der Kommentar wurde gespeichert', 'de', 'yum'),
('The file "{file}" is not an image.', 'Die Datei {file} ist kein Bild.', 'de', 'yum'),
('The friendship request has been sent', 'Die Kontaktanfrage wurde gesendet', 'de', 'yum'),
('The image "{file}" height should be "{height}px".', 'Die Datei {file} muss genau {height}px hoch sein.', 'de', 'yum'),
('The image "{file}" width should be "{width}px".', 'Die Datei {file} muss genau {width}px breit sein.', 'de', 'yum'),
('The image has been resized to {max_pixel}px width successfully', 'Das Bild wurde beim hochladen automatisch auf eine Breite von {max_pixel} skaliert', 'de', 'yum'),
('The image should have at least 50px and a maximum of 200px in width and height. Supported filetypes are .jpg, .gif and .png', 'das Bild sollte mindestens 50px und maximal 200px in der Höhe und Breite betragen. Mögliche Dateitypen sind .jpg, .gif und .png', 'de', 'yum'),
('The image was uploaded successfully', 'Das Bild wurde erfolgreich hochgeladen', 'de', 'yum'),
('The minimum value of the field (form validator).', 'Minimalwert des Feldes (Form-Validierung', 'de', 'yum'),
('The new password has been saved', 'Das neue Passwort wurde gespeichert.', 'de', 'yum'),
('The value of the default field (database).', 'Standard-Wert für die Datenbank', 'de', 'yum'),
('There are a total of {messages} messages in your System.', 'Es gibt in ihrem System insgesamt {messages} Nachrichten.', 'de', 'yum'),
('There are {active_users} active and {inactive_users} inactive users in your System, from which {admin_users} are Administrators.', ' Es gibt {active_users} aktive und {inactive_users} inaktive Benutzer in ihrem System, von denen {admin_users} Benutzer Administratoren sind.', 'de', 'yum'),
('There are {profiles} profiles in your System. These consist of {profile_fields} profile fields in {profile_field_groups} profile field groups', 'Es gibt {profiles} Profile in ihren System. Diese bestehen aus {profile_fields} Profilfeldern, die sich in {profile_field_groups} Profilfeldgruppen aufteilen.', 'de', 'yum'),
('There are {roles} roles in your System.', 'Es gibt {roles} Rollen in ihrem System', 'de', 'yum'),
('There was an error saving the password', 'Fehler beim speichern des Passwortes', 'de', 'yum'),
('These users have a ordered memberships of this role', 'Diese Benutzer haben eine Mitgliedschaft in dieser Rolle', 'de', 'yum'),
('These users have been assigned to this Role', 'Diese Nutzer gehören dieser Rolle an: ', 'de', 'yum'),
('These users have been assigned to this role', 'Dieser Rolle gehören diese Benutzer an', 'de', 'yum'),
('These users have commented your profile recently', 'Diese Benutzer haben mein Profil kürzlich kommentiert', 'de', 'yum'),
('These users have visited my profile', 'Diese Benutzer haben mein Profil besucht', 'de', 'yum'),
('These users have visited your profile recently', 'Diese Benutzer haben kürzlich mein Profil besucht', 'de', 'yum'),
('This account is blocked.', 'Ihr Konto wurde blockiert.', 'de', 'yum'),
('This account is not activated.', 'Ihr Konto wurde nicht aktiviert.', 'de', 'yum'),
('This membership is still active {days} days', 'Die Mitgliedschaft ist noch {days} Tage aktiv', 'de', 'yum'),
('This message will be sent to {username}', 'Diese Nachricht wird an {username} versandt', 'de', 'yum'),
('This user belongs to these roles:', 'Benutzer gehört diesen Rollen an:', 'de', 'yum'),
('This user can administer this users', 'Dieser Benutzer kann diese Nutzer administrieren', 'de', 'yum'),
('This user can administer this users:', 'Benutzer kann diese Benutzer verwalten:', 'de', 'yum'),
('This user''s email adress already exists.', 'Der Benutzer E-Mail-Adresse existiert bereits.', 'de', 'yum'),
('This user''s name already exists.', 'Der Benutzer Name existiert bereits.', 'de', 'yum'),
('Time left', 'Zeit übrig', 'de', 'yum'),
('Time sent', 'Gesendet am', 'de', 'yum'),
('Title', 'Titel', 'de', 'yum'),
('To', 'An', 'de', 'yum'),
('Translation', 'Übersetzung', 'de', 'yum'),
('Translations have been saved', 'Die Übersetzungen wurden gespeichert', 'de', 'yum'),
('Try again', 'Erneut versuchen', 'de', 'yum'),
('Update', 'Bearbeiten', 'de', 'yum'),
('Update Profile Field', 'Profilfeld bearbeiten', 'de', 'yum'),
('Update User', 'Benutzer bearbeiten', 'de', 'yum'),
('Update my profile', 'Mein Profil bearbeiten', 'de', 'yum'),
('Update payment', 'Zahlungsart bearbeiten', 'de', 'yum'),
('Update role', 'Rolle bearbeiten', 'de', 'yum'),
('Update user', 'Benutzer bearbeiten', 'de', 'yum'),
('Upgrade to {role}', 'Wechsle auf {role}', 'de', 'yum'),
('Upload avatar', 'Profilbild hochladen', 'de', 'yum'),
('Upload avatar image', 'Profilbild hochladen', 'de', 'yum'),
('Use my Gravatar', 'Meinen Gravatar benutzen', 'de', 'yum'),
('User', 'Benutzer', 'de', 'yum'),
('User Administration', 'Benutzerverwaltung', 'de', 'yum'),
('User Management Home', 'Benutzerverwaltung Startseite', 'de', 'yum'),
('User Management settings configuration', 'Einstellungen', 'de', 'yum'),
('User Operations', 'Benutzeraktionen', 'de', 'yum'),
('User activation', 'User-Aktivierung', 'de', 'yum'),
('User administration Panel', 'Benutzerkontrollzentrum', 'de', 'yum'),
('User administration panel', 'Kontrollzentrum', 'de', 'yum'),
('User belongs to Roles', 'Benutzer gehört diesen Rollen an', 'de', 'yum'),
('User belongs to these roles', 'Benutzer gehört diesen Rollen an', 'de', 'yum'),
('User can not administer any users', 'Kann keine Benutzer verwalten', 'de', 'yum'),
('User can not administer any users of any role', 'Kann keine Rollen verwalten', 'de', 'yum'),
('User can not be found', 'Benutzer kann nicht gefunden werden', 'de', 'yum'),
('User is Online!', 'Benutzer ist Online!', 'de', 'yum'),
('User is not active', 'Benutzer ist nicht aktiv', 'de', 'yum'),
('User module settings', 'Moduleinstellungen', 'de', 'yum'),
('Usergroups', 'Benutzergruppen', 'de', 'yum'),
('Username', 'Benutzername', 'de', 'yum'),
('Username is incorrect.', 'Benutzername ist falsch.', 'de', 'yum'),
('Username or Email', 'Benutzername oder E-mail', 'de', 'yum'),
('Username or Password is incorrect', 'Benutzername oder Passwort ist falsch', 'de', 'yum'),
('Username or email', 'Benutzername oder E-Mail', 'de', 'yum'),
('Users: ', 'Benutzer: ', 'de', 'yum'),
('Variable name', 'Variablen name', 'de', 'yum'),
('Verification code', 'Verifizierung', 'de', 'yum'),
('View', 'Anzeigen', 'de', 'yum'),
('View Details', 'Zur Gruppe', 'de', 'yum'),
('View User', 'Benutzer anzeigen', 'de', 'yum'),
('View admin messages', 'Administratornachrichten anzeigen', 'de', 'yum'),
('View my messages', 'Meine Nachrichten ansehen', 'de', 'yum'),
('View user "{username}"', 'Benutzer "{username}"', 'de', 'yum'),
('View users', 'Benutzer anzeigen', 'de', 'yum'),
('Visible', 'Sichtbar', 'de', 'yum'),
('Visit profile', 'Profil besuchen', 'de', 'yum'),
('When selecting searchable, users of this role can be searched in the "user Browse" function', 'Wenn "suchbar" ausgewählt wird, kann man Nutzer dieser Rolle in der "Benutzer durchsuchen"-Funktion suchen', 'de', 'yum'),
('When the membership expires', 'Wenn die Mitgliedschaft abläuft', 'de', 'yum'),
('Write a comment', 'Kommentar hinterlassen', 'de', 'yum'),
('Write a message', 'Nachricht schreiben', 'de', 'yum'),
('Write a message to this User', 'Diesem Benutzer eine Nachricht schreiben', 'de', 'yum'),
('Write a message to {username}', 'Nachricht an {username} schreiben', 'de', 'yum'),
('Write another message', 'Eine weitere Nachricht schreiben', 'de', 'yum'),
('Write comment', 'Kommentar schreiben', 'de', 'yum'),
('Write message', 'Nachricht schreiben', 'de', 'yum'),
('Written at', 'Geschrieben am', 'de', 'yum'),
('Written from', 'Geschrieben von', 'de', 'yum'),
('Wrong password confirmation! Account was not deleted', 'Falsches Bestätigugspasswort! Zugang wurde nicht gelöscht', 'de', 'yum'),
('Yes', 'Ja', 'de', 'yum'),
('Yes and show on registration form', 'Ja, und auf Registrierungsseite anzeigen', 'de', 'yum'),
('Yii-user-management is already installed. Please remove it manually to continue', 'Yii-user-management ist bereits installiert. Bitte löschen Sie es manuell, um fortzufahren', 'de', 'yum'),
('You account is activated.', 'Ihr Konto wurde aktiviert.', 'de', 'yum'),
('You account is active.', 'Ihr Konto ist aktiv.', 'de', 'yum'),
('You already are friends', 'Ihr seid bereits Freunde', 'de', 'yum'),
('You are not allowed to view this profile.', 'Sie dürfen dieses Profil nicht ansehen.', 'de', 'yum'),
('You are running the Yii User Management Module {version} in Debug Mode!', 'Dies ist das Yii-User-Management Modul in Version {version} im Debug Modus!', 'de', 'yum'),
('You do not have any friends yet', 'Ihre Kontaktliste ist leer', 'de', 'yum'),
('You do not have set an avatar image yet', 'Es wurde noch kein Profilbild hochgeladen', 'de', 'yum'),
('You have joined this group', 'Sie sind dieser Gruppe beigetreten', 'de', 'yum'),
('You have left this group', 'Du hast diese Gruppe verlassen', 'de', 'yum'),
('You have new Messages !', 'Sie haben neue Nachrichten !', 'de', 'yum'),
('You have new messages!', 'Sie haben neue Nachrichten!', 'de', 'yum'),
('You have no messages yet', 'Sie haben bisher noch keine Nachrichten', 'de', 'yum'),
('You have {count} new Messages !', 'Sie haben {count} neue Nachricht(en)!', 'de', 'yum'),
('Your Account has been activated. Thank you for your registration', 'Ihr Zugang wurde aktiviert. Danke für die Registierung', 'de', 'yum'),
('Your Avatar image', 'Ihr Avatar-Bild', 'de', 'yum'),
('Your account has been activated. Thank you for your registration', 'Ihr Zugang wurde aktiviert. Danke für ihre Registrierung', 'de', 'yum'),
('Your account has been deleted.', 'Ihr Zugang wurde gelöscht', 'de', 'yum'),
('Your activation succeeded', 'Ihre Aktivierung war erfolgreich', 'de', 'yum'),
('Your changes have been saved', 'Ihre Änderungen wurden gespeichert', 'de', 'yum'),
('Your current password', 'Ihr aktuelles Passwort', 'de', 'yum'),
('Your current password is not correct', 'Ihr aktuelles Passwort ist nicht korrekt', 'de', 'yum'),
('Your friendship request has been accepted', 'Ihre Freundschaftsanfrage wurde akzeptiert', 'de', 'yum'),
('Your message has been sent', 'Ihre Nachricht wurde gesendet', 'de', 'yum'),
('Your new password has been saved.', 'Ihr Passwort wurde gespeichert.', 'de', 'yum'),
('Your password has expired. Please enter your new Password below:', 'Ihr Passwort ist abgelaufen. Bitte geben Sie ein neues Passwort an:', 'de', 'yum'),
('Your privacy settings have been saved', 'Ihre Privatsphären-einstellungen wurden gespeichert', 'de', 'yum'),
('Your profile', 'Ihr Profil', 'de', 'yum'),
('Your subscription setting has been saved', 'Ihre Einstellungen wurden gespeichert', 'de', 'yum'),
('activation key', 'Aktivierungsschlüssel', 'de', 'yum'),
('birthdate', 'Geburtstag', 'de', 'yum'),
('birthday', 'Geburtstag', 'de', 'yum'),
('change Password', 'Passwort ändern', 'de', 'yum'),
('change password', 'Passwort ändern', 'de', 'yum'),
('do not make my friends public', 'Meine Kontakte nicht veröffentlichen', 'de', 'yum'),
('email', 'E-Mail', 'de', 'yum'),
('firstname', 'Vorname', 'de', 'yum'),
('friends only', 'Nur Freunde', 'de', 'yum'),
('lastname', 'Nachname', 'de', 'yum'),
('make my friends public', 'Meine Kontakte veröffentlichen', 'de', 'yum'),
('no', 'Nein', 'de', 'yum'),
('of user', 'von Benutzer', 'de', 'yum'),
('only to my friends', 'Nur an meine Freunde veröffentlichen', 'de', 'yum'),
('password', 'Passwort', 'de', 'yum'),
('private', 'Privat', 'de', 'yum'),
('protected', 'Geschützt', 'de', 'yum'),
('public', 'Öffentlich', 'de', 'yum'),
('timestamp', 'Zeitstempel', 'de', 'yum'),
('username', 'Benutzername', 'de', 'yum'),
('username or email', 'Benutzername oder E-Mail Adresse', 'de', 'yum'),
('verifyPassword', 'Passwort wiederholen', 'de', 'yum'),
('yes', 'Ja, diese Daten veröffentlichen', 'de', 'yum'),
('zipcode', 'Postleitzahl', 'de', 'yum');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `activationKey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `lastvisit` int(11) NOT NULL DEFAULT '0',
  `lastaction` int(11) NOT NULL DEFAULT '0',
  `lastpasswordchange` int(11) NOT NULL DEFAULT '0',
  `failedloginattempts` int(11) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  `notifyType` enum('None','Digest','Instant','Threshold') DEFAULT 'Instant',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `activationKey`, `createtime`, `lastvisit`, `lastaction`, `lastpasswordchange`, `failedloginattempts`, `superuser`, `status`, `avatar`, `notifyType`) VALUES
(1, 'admin', '9ef83c6bcdd14d6fb478b5e9e0115bfe9b96782c0720758fde78a7613cbdcff20a8c0395da4c2a6ec71ab84a48f7656f441d45eaaba545cf8ebd51f430955398', 'wCEprK5Cv8cd8XKWAIiRoFtFUyX5g6GzutjFUZsCrrSLqYpfNyOlzj7Rhoj8iZKEz95D+rwSL2exuk+hYSYrCw==', '', 1362419867, 1362500385, 1362504036, 0, 0, 1, 1, NULL, 'Instant'),
(2, 'demo', '0baa41540b3b4fe5abaf39be2245904bc038a577ae21b5d325161efeb6ec8ce4664f31e791bbebdce50ab3485210ffb5c950dcbf2c866cc3ce85ef3e3bed76a2', 'd52iHYyObLWXT6Z2G46YLNYOQu5/uk14XK7ed7BfUrMXi6GeypL9MN0M7PpzKNS+MAg/AoI4tlJHLDGUgKo+Ow==', '', 1362419867, 0, 0, 0, 0, 0, -2, NULL, 'Instant'),
(3, 'c.ehringfeld@t-onlin', '051a1dcb9ed33d56237ccd4af7cc0280057f68e83dfb0d78ddebc5fc9356461b1706f32456d1b27cb9c0d77bf3a332a7eab1b19160894073b79fa3ca3db360d6', 'Dplj8EpxwNZ9nitnT6dg+C6mydn9KlBSdsEMxtAUAP3/ol8pEWvl3SYXJuNt8TIHsaphKBwUjmLi53thPdWArg==', 'adf3a57ea8ca142981007a3c53426e59b19b7566f64d8e37b83e4683d6142020612932f852488b2dbe4c2183215c1cc89f2e716eba0b41adadfc8e82de9a9cc1', 1362500376, 0, 0, 1362500376, 0, 0, 1, NULL, 'Instant'),
(4, 'Demo_44398_0', '8156477cd03e09199b20e78492e6aa5d087be42648ca8b40ca917930acc36ea042146b961ca1340e2c1599a7daa30ebe804d60aefca8cdbd32c873ac0578a92e', '2shXD5D+ySzY0c/sSfH2iwfXV4NUuR5HELKBJuXYMWaFXHQW9jrZ1r/IdKN1HLjp681HJTeMKSWjYEAmE/fLzQ==', '', 1362502596, 0, 0, 0, 0, 0, 1, NULL, 'Instant');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(2, 3),
(4, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
