<?php

/** Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class ConfigForm extends CFormModel {

    public $adminEmail;
    public $dateTimeFormat;
    public $emailHost;
    public $fromMailHost;
    public $fromMail;
    public $teacherMail;
    public $schoolName;
    public $virtualHost;
    public $mailsActivated;
    public $maxChild;
    public $maxTanGen;
    public $maxAppointmentsPerChild;
    public $randomTeacherPassword;
    public $defaultTeacherPassword;
    public $minLengthPerAppointment;
    public $banUsers;
    public $durationTempBans;
    public $maxAttemptsForLogin;
    public $salt;
    public $installed;
    public $timeFormat;
    public $dateFormat;
    public $allowBlockingAppointments;
    public $appointmentBlocksPerDate;
    public $lengthReasonAppointmentBlocked;
    public $schoolStreet;
    public $schoolCity;
    public $schoolTele;
    public $schoolFax;
    public $schoolEmail;
    public $useSchoolEmailForContactForm;
    public $allowBlockingOnlyForManagement;
    public $lockRegistration;
    public $allowGroups;
    public $databaseHost;
    public $databaseName;
    public $databaseUsername;
    public $databasePassword;
    public $databaseManagementSystem;

    public function init() {
        $this->attributes = Yii::app()->params->toArray();
    }

    public function rules() {
        return array(
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail' .
                ',teacherMail,schoolName,virtualHost,mailsActivated,maxChild,'
                . 'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,' .
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,' .
                'durationTempBans,maxAttemptsForLogin,timeFormat,dateFormat,' .
                'allowBlockingAppointments,appointmentBlocksPerDate,' .
                'lengthReasonAppointmentBlocked,schoolStreet,schoolCity,' .
                'schoolTele,schoolFax,schoolEmail,allowBlockingOnlyForManagement,lockRegistration,allowGroups,' .
                'databaseHost,databaseName,databaseUsername,databasePassword,databaseManagementSystem'
                , 'required'),
            array('fromMailHost,adminEmail,schoolEmail', 'email'),
            array('databaseManagementSystem', 'length', 'min' => 3),
            array('emailHost,fromMail,dateFormat', 'length', 'min' => 4),
            array('dateTimeFormat', 'length', 'min' => 5),
            array('defaultTeacherPassword,databasePassword', 'length', 'min' => 8),
            array('salt', 'length', 'min' => 16, 'max' => 64),
            array('mailsActivated,randomTeacherPassword,banUsers,allowBlockingAppointments,' .
                'useSchoolEmailForContactForm,allowBlockingOnlyForManagement,lockRegistration,allowGroups',
                'boolean'),
            array('maxChild,maxAppointmentsPerChild,minLengthPerAppointment,'
                . 'durationTempBans,maxAttemptsForLogin,appointmentBlocksPerDate,'
                . 'lengthReasonAppointmentBlocked',
                'numerical', 'integerOnly' => true),
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail' .
                ',teacherMail,schoolName,virtualHost,mailsActivated,maxChild,'
                . 'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,' .
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,' .
                'durationTempBans,maxAttemptsForLogin,salt,installed,dateFormat,timeFormat,' .
                'allowBlockingAppointments,appointmentBlocksPerDate,' .
                'lengthReasonAppointmentBlocked', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'adminEmail' => 'Administrator E-Mail Adresse',
            'dateTimeFormat' => 'Datums und Zeitformat (z.B. d.m.Y H:i)', //
            'emailHost' => 'Hostname des SMTP Servers (z.B. localhost)',
            'fromMailHost' => 'Versender E-Mailadresse (z.B. xyz@schoolxyz.de)',
            'fromMail' => 'Absendername (z.B. ESTA-School)',
            'teacherMail' => 'Domainname des SMTP Servers (z.B. schoolxyz)',
            'schoolName' => 'Schulname (z.B. Schule XYZ)',
            'virtualHost' => 'Virtualhost des Servers - Pfad unter dem die Anwendung erreichbar ist (z.B. /est/)',
            'mailsActivated' => 'E-Mails versenden?',
            'maxChild' => 'Maximal Anzahl an Kindern pro Eltern',
            'maxAppointmentsPerChild' => 'Maximal Anzahl an Terminen pro Kinder',
            'randomTeacherPassword' => 'Lehrerpasswörter bei deren Erstellung zufällig generieren?',
            'defaultTeacherPassword' => 'Standardpasswort wenn die vorherige Option deaktiviert ist',
            'minLengthPerAppointment' => 'Mindestlänge eines Termins bei einem neuzuerstellenden Elternsprechtag',
            'banUsers' => 'Temporäres Sperren eines Nutzers bei zu vielen fehlgeschlagenen Loginversuchen',
            'durationTempBans' => 'Dauer der Sperre in Minuten',
            'maxAttemptsForLogin' => 'Maximalanzahl an fehlgeschlagenen Loginversuchen bis zur Sperrung eines Kontos',
            'salt' => 'Salz für Passwörter',
            'dateFormat' => 'Datumsformat (z.B. d.m.Y)',
            'timeFormat' => 'Zeitformat (z.B. H:i)',
            'allowBlockingAppointments' => 'Blockieren von Terminen erlauben?',
            'appointmentBlocksPerDate' => 'Anzahl der Termine die blockiert werden dürfen',
            'lengthReasonAppointmentBlocked' => 'Minimallänge eines Grundes um einen Termin zu blocken',
            'schoolStreet' => 'Straße',
            'schoolCity' => 'Postleitzahl, Ort',
            'schoolTele' => 'Telefonnummer',
            'schoolFax' => 'Faxnummer',
            'schoolEmail' => 'E-Mail Adresse der Schule',
            'useSchoolEmailForContactForm' => 'E-Mail Adresse der Schule für das Kontaktformular verwenden?',
            'allowBlockingOnlyForManagement' => 'Nur Verwaltung und Administration dürfen Termine blockieren?',
            'lockRegistration' => 'Registrierung sperren?',
            'allowGroups' => 'Gruppen erlauben?',
            'databaseHost' => 'Datenbankhost',
            'databaseName' => 'Name der Tabelle in der Datenbank',
            'databaseUsername' => 'Datenbankbenutzername',
            'databasePassword' => 'Datenbankbenutzerpasswort',
            'databaseManagementSystem' => 'Datenbankmanagementsystem',
        );
    }

    private function createTables($command) {

        $command->createTable("child", array(
            'id' => 'pk',
            'firstname' => 'string NOT NULL',
            'lastname' => 'string NOT NULL',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable("YiiSession", array(
            'id' => 'string NOT NULL',
            'expire' => 'integer',
            'data' => 'longblob',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable("YiiCache", array(
            'id' => 'string NOT NULL',
            'expire' => 'integer',
            'value' => 'longblob',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('group', array(
            'id' => 'pk',
            'groupname' => 'string NOT NULL'
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('role', array(
            'id' => 'integer PRIMARY KEY',
            'title' => 'string NOT NULL',
            'description' => 'string',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('user', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'email' => 'string',
            'activationKey' => 'string NOT NULL',
            'createtime' => 'timestamp',
            'firstname' => 'string NOT NULL',
            'lastname' => 'string CHARACTER SET utf8 COLLATE utf8_bin NOT NULL',
            'title' => 'string',
            'state' => 'tinyint(3)',
            'lastLogin' => 'bigint DEFAULT "0"',
            'badLogins' => 'tinyint(4)',
            'bannedUntil' => 'bigint DEFAULT "0"', //maybe Int
            'password' => 'string',
            'group_id' => 'integer',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('user_role', array(
            'id' => 'pk',
            'role_id' => 'integer NOT NULL',
            'user_id' => 'integer NOT NULL',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('tan', array(
            'tan' => 'integer UNIQUE',
            'used' => 'boolean',
            'group_id' => 'integer NULL',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('parent_child', array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL',
            'child_id' => 'integer NOT NULL',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('date', array(
            'id' => 'pk',
            'title' => 'string NULL',
            'date' => 'date NOT NULL',
            'begin' => 'time NOT NULL',
            'end' => 'time NOT NULL',
            'lockAt' => 'integer NOT NULL',
            'durationPerAppointment' => 'int(3)',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('date_has_group', array(
            'id' => 'pk',
            'date_id' => 'integer',
            'group_id' => 'integer',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('dateAndTime', array(
            'id' => 'pk',
            'time' => 'time NOT NULL',
            'date_id' => 'integer',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('appointment', array(
            'id' => 'pk',
            'parent_child_id' => 'integer',
            'user_id' => 'integer',
            'dateAndTime_id' => 'integer',
                ), 'DEFAULT CHARSET=utf8');
        $command->createTable('blockedAppointment', array(
            'id' => 'pk',
            'reason' => 'text',
            'dateAndTime_id' => 'integer',
            'user_id' => 'integer',
                ), 'DEFAULT CHARSET=utf8');
    }

    private function createIndices($command) {
        $command->createIndex('idx_group_name', 'group', 'groupname', true);
        $command->createIndex('idx_role_title', 'role', 'title', true);
        $command->createIndex('idx_date_has_group', 'date_has_group', 'date_id,group_id', true);
        $command->createIndex('idx_blockedAppointment', 'blockedAppointment', 'dateAndTime_id,user_id', true);
        $command->createIndex('idx_user_id', 'user', 'id');
        $command->createIndex('idx_role_id', 'role', 'id');
        $command->createIndex('idx_user_role_id', 'user_role', 'id');
        $command->createIndex('idx_group_id', 'group', 'id');
        $command->createIndex('idx_child_id', 'child', 'id');
        $command->createIndex('idx_ parent_child_id', 'parent_child', 'id');
        $command->createIndex('idx_date_has_group_id', 'date_has_group', 'id');
        $command->createIndex('idx_date_id', 'date', 'id');
        $command->createIndex('idx_dateAndTime_date_id_time', 'dateAndTime', 'time,date_id', true);
        $command->createIndex('idx_dateAndTime_id', 'dateAndTime', 'id');
        $command->createIndex('idx_appointment_id', 'appointment', 'id');
        $command->createIndex('idx_blockedAppointment_id', 'blockedAppointment', 'id');
    }

    private function addForeignKeys($command) {
        $command->addForeignKey('user_fk1', 'user', 'group_id', 'group', 'id', 'SET NULL', 'CASCADE');
        $command->addForeignKey('user_role_fk1', 'user_role', 'role_id', 'role', 'id', 'NO ACTION', 'NO ACTION');
        $command->addForeignKey('user_role_fk2', 'user_role', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('tan_fk1', 'tan', 'group_id', 'group', 'id', 'SET NULL', 'NO ACTION');
        $command->addForeignKey('parent_child_fk1', 'parent_child', 'child_id', 'child', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('parent_child_fk2', 'parent_child', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('date_has_group_fk1', 'date_has_group', 'date_id', 'date', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('date_has_group_fk2', 'date_has_group', 'group_id', 'group', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('dateAndTime_fk1', 'dateAndTime', 'date_id', 'date', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('appointment_fk1', 'appointment', 'parent_child_id', 'parent_child', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('appointment_fk2', 'appointment', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('appointment_fk3', 'appointment', 'dateAndTime_id', 'dateAndTime', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('blockedAppointment_fk1', 'blockedAppointment', 'dateAndTime_id', 'dateAndTime', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('blockedAppointment_fk2', 'blockedAppointment', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
    }

    private function fillTable($command) {
        $command->insert('role', array(
            'id' => 0,
            'title' => 'Administration',
        ));
        $command->insert('role', array(
            'id' => 1,
            'title' => 'Verwaltung'
        ));
        $command->insert('role', array(
            'id' => 2,
            'title' => 'Lehrer',
        ));
        $command->insert('role', array(
            'id' => 3,
            'title' => 'Eltern'
        ));
    }

    public function tables() {
        $rc = true;
        $connection = $this->getConnection();
        if ($connection->active) {
            $command = $connection->createCommand();
            $this->createTables($command);
            $this->addForeignKeys($command);
            $this->createIndices($command);
            $this->fillTable($command);
        } else {
            $this->addError('databaseHost', 'Die Datenbankverbindung konnte nicht hergestellt werden.');
            $rc = false;
        }
        return $rc;
    }

    public function getConnection() {
        $connection = new CDbConnection(Yii::app()->params['databaseManagementSystem'] . ':host=' . Yii::app()->params['databaseHost'] . ';dbname=' . Yii::app()->params['databaseName'], Yii::app()->params['databaseUsername'], Yii::app()->params['databasePassword']);
        $connection->setActive(true);
        return $connection;
    }

}

?>
