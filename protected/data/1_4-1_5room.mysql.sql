SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `room` (
`id` int(11) NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL UNIQUE KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `user_has_room` (
`id` int(11) NOT NULL PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
`date_id` int(11) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `room`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_has_room`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_has_room`
 ADD UNIQUE KEY `idx_user_has_room1` (`user_id`,`room_id`,`date_id`);

ALTER TABLE `user_has_room`
ADD CONSTRAINT `user_has_room_fk2` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `user_has_room_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `user_has_room_fk3` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;


INSERT INTO `configs` (`key`, `value`) VALUES ('allowTeachersToManageOwnRooms','1');


COMMIT;