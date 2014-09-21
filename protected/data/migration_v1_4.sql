SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DELETE FROM `configs` WHERE  `key` = "mailsActivated";
INSERT INTO `configs` (`key`, `value`) VALUES
('ldapHost','');
('ldapPort',''),
('ldapOu',''),
('ldapDc',''),
('adDomain','');





COMMIT;