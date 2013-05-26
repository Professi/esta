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

/**
 * model class for configurations view
 * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
 */
class ConfigForm extends CFormModel {

    const pgsql = 'pgsql';
    const mysql = 'mysql';
    const mssql = 'mssql';

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
    public $databasePort;
    public $databaseName;
    public $databaseUsername;
    public $databasePassword;
    public $databaseManagementSystem;
    public $logoPath;
    public $textHeader;
    public $appName;
    public $language;
    public $allowParentsToManageChilds;
    public $hashCost;
    private $firstRead = true;
    private $params;

    /**
     * setting all attributes
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function init() {
        $this->attributes = Yii::app()->params->toArray();
    }

    /**
     * validation rules
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array
     */
    public function rules() {
        return array(
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail' .
                ',teacherMail,schoolName,virtualHost,mailsActivated,maxChild,'
                . 'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,' .
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,' .
                'durationTempBans,maxAttemptsForLogin,timeFormat,dateFormat,' .
                'allowBlockingAppointments,appointmentBlocksPerDate,' .
                'lengthReasonAppointmentBlocked,schoolStreet,schoolCity,' .
                'schoolTele,schoolFax,schoolEmail,allowBlockingOnlyForManagement,' .
                'lockRegistration,allowGroups,databasePort,allowParentsToManageChilds,' .
                'databaseHost,databaseName,databaseUsername,databasePassword,databaseManagementSystem,logoPath,textHeader,language,appName,hashCost'
                , 'required'),
            array('fromMailHost,adminEmail,schoolEmail', 'email'),
            array('language', 'length', 'min' => 2),
            array('databaseManagementSystem', 'length', 'min' => 3),
            array('emailHost,fromMail,dateFormat,appName', 'length', 'min' => 4),
            array('dateTimeFormat', 'length', 'min' => 5),
            array('defaultTeacherPassword,databasePassword', 'length', 'min' => 8),
            array('salt', 'length', 'min' => 16, 'max' => 255),
            array('mailsActivated,randomTeacherPassword,banUsers,allowBlockingAppointments,' .
                'useSchoolEmailForContactForm,allowBlockingOnlyForManagement,lockRegistration,' .
                'allowParentsToManageChilds,allowGroups',
                'boolean'),
            array('maxChild,maxAppointmentsPerChild,minLengthPerAppointment,'
                . 'durationTempBans,maxAttemptsForLogin,appointmentBlocksPerDate,'
                . 'lengthReasonAppointmentBlocked,databasePort',
                'numerical', 'integerOnly' => true, 'min' => 1),
            array('hashCost', 'numerical', 'integerOnly' => true, 'min' => 13),
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail' .
                ',teacherMail,schoolName,virtualHost,mailsActivated,maxChild,'
                . 'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,' .
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,' .
                'durationTempBans,maxAttemptsForLogin,salt,installed,dateFormat,timeFormat,' .
                'allowBlockingAppointments,appointmentBlocksPerDate,' .
                'lengthReasonAppointmentBlocked', 'safe'),
        );
    }

    /**
     * attributeLabels
     * @return array
     */
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
            'hashCost' => 'Rechenaufwand für das Hashen der Passwörter',
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
            'logoPath' => 'Pfad des Schullogos in der Anwendung',
            'textHeader' => 'Headertext zwischen Anwendungslogo und Schullogo',
            'language' => 'Sprache',
            'appName' => 'Anwendungsname',
            'databasePort' => 'Datenbankport',
            'allowParentsToManageChilds' => 'Sollen Eltern die Daten über Ihre Kinder verwalten können?'
        );
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * creates all database tables
     * @param CdbCommand $command
     */
    private function createTables($command) {
        $command->createTable('child', array(
            'id' => 'pk',
            'firstname' => 'string NOT NULL',
            'lastname' => 'string NOT NULL',
                ), $this->getCollation());
        $command->createTable('YiiSession', array(
            'id' => 'string NOT NULL',
            'expire' => 'integer',
            'data' => 'binary',
                ), $this->getCollation());
        $command->createTable('YiiCache', array(
            'id' => 'string NOT NULL',
            'expire' => 'integer',
            'value' => 'binary',
                ), $this->getCollation());
        $command->createTable('group', array(
            'id' => 'pk',
            'groupname' => 'string NOT NULL'
                ), $this->getCollation());
        $command->createTable('role', array(
            'id' => 'integer PRIMARY KEY',
            'title' => 'string NOT NULL',
            'description' => 'string',
                ), $this->getCollation());
        $command->createTable('user', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'email' => 'string',
            'activationKey' => 'string NOT NULL',
            'createtime' => 'bigint',
            'firstname' => 'string NOT NULL',
            'lastname' => 'string ' . $this->getCollation(true) . ' NOT NULL',
            'title' => 'string',
            'state' => 'smallint',
            'lastLogin' => 'bigint DEFAULT 0',
            'badLogins' => 'smallint DEFAULT 0',
            'bannedUntil' => 'bigint DEFAULT 0',
            'password' => 'string',
                ), $this->getCollation());
        $command->createTable('user_role', array(
            'id' => 'pk',
            'role_id' => 'integer NOT NULL',
            'user_id' => 'integer NOT NULL',
                ), $this->getCollation());
        $command->createTable('tan', array(
            'tan' => 'string UNIQUE NOT NULL',
            'used' => 'boolean',
            'group_id' => 'integer NULL',
            'child_id' => 'integer NULL',
            'used_by_user_id' => 'integer NULL'
                ), $this->getCollation());
        $command->createTable('parent_child', array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL',
            'child_id' => 'integer NOT NULL',
                ), $this->getCollation());
        $command->createTable('date', array(
            'id' => 'pk',
            'title' => 'string NULL',
            'date' => 'date NOT NULL',
            'begin' => 'time NOT NULL',
            'end' => 'time NOT NULL',
            'lockAt' => 'bigint NOT NULL',
            'durationPerAppointment' => 'smallint NOT NULL',
                ), $this->getCollation());
        $command->createTable('date_has_group', array(
            'id' => 'pk',
            'date_id' => 'integer NOT NULL',
            'group_id' => 'integer NOT NULL',
                ), $this->getCollation());
        $command->createTable('user_has_group', array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL',
            'group_id' => 'integer NOT NULL',
                ), $this->getCollation());
        $command->createTable('dateAndTime', array(
            'id' => 'pk',
            'time' => 'time NOT NULL',
            'date_id' => 'integer NOT NULL',
                ), $this->getCollation());
        $command->createTable('appointment', array(
            'id' => 'pk',
            'parent_child_id' => 'integer NOT NULL',
            'user_id' => 'integer NOT NULL',
            'dateAndTime_id' => 'integer NOT NULL',
                ), $this->getCollation());
        $command->createTable('blockedAppointment', array(
            'id' => 'pk',
            'reason' => 'text',
            'dateAndTime_id' => 'integer NOT NULL',
            'user_id' => 'integer NOT NULL',
                ), $this->getCollation());
    }

    /**
     * default charset for mysql Databases
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string
     */
    private function mysqlCharset() {
        return 'DEFAULT CHARSET=utf8';
    }

    /**
     * default charset for postgresql databases
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string
     */
    private function pgsqlCharset() {
        return 'ENCODING \'UTF8\'';
    }

    /**
     * mysql charset for columns with case sensitives char collation
     * @return string
     */
    private function mysqlCSColumnCharset() {
        return 'CHARACTER SET utf8 COLLATE utf8_bin';
    }

    /**
     * postgre sql charset for columns with case sensitive char collation
     * @return string
     */
    private function pgsqlCSColumnCharset() {
        return 'COLLATE "' . strtolower($this->getParam('language')) . '_' . strtoupper($this->getParam('language') . '"');
    }

    /**
     * returns collation for database
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param boolean $column
     * @return string
     */
    public function getCollation($column = false) {
        $rc = '';
        switch ($this->getDBMS()) {
            case ConfigForm::mysql:
                $rc = $column ? $this->mysqlCSColumnCharset() : $this->mysqlCharset();
                break;
            case ConfigForm::pgsql:
                // $rc = $column ? $this->pgsqlCSColumnCharset() : $this->pgsqlCharset();
                $rc = '';
                break;
        }
        return $rc;
    }

    /**
     * creates database indices
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param CdbCommand $command
     */
    private function createIndices($command) {
        $command->createIndex('idx_group_name', 'group', 'groupname', true);
        $command->createIndex('idx_role_title', 'role', 'title', true);
        $command->createIndex('idx_blockedAppointment', 'blockedAppointment', 'dateAndTime_id,user_id', true);
        $command->createIndex('idx_date_has_group1', 'date_has_group', 'date_id,group_id', true);
        $command->createIndex('idx_user_has_group1', 'user_has_group', 'user_id,group_id', true);
        $command->createIndex('idx_dateAndTime_date_id_time', 'dateAndTime', 'time,date_id', true);
    }

    /**
     * sets foreign keys 
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param cdbCommand $command
     */
    private function addForeignKeys($command) {
        $command->addForeignKey('user_role_fk1', 'user_role', 'role_id', 'role', 'id', 'NO ACTION', 'NO ACTION');
        $command->addForeignKey('user_role_fk2', 'user_role', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('tan_fk1', 'tan', 'group_id', 'group', 'id', 'SET NULL', 'NO ACTION');
        $command->addForeignKey('tan_fk2', 'tan', 'child_id', 'child', 'id', 'SET NULL', 'NO ACTION');
        $command->addForeignKey('tan_fk3', 'tan', 'used_by_user_id', 'user', 'id', 'SET NULL', 'NO ACTION');
        $command->addForeignKey('parent_child_fk1', 'parent_child', 'child_id', 'child', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('parent_child_fk2', 'parent_child', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('date_has_group_fk1', 'date_has_group', 'date_id', 'date', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('date_has_group_fk2', 'date_has_group', 'group_id', 'group', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('user_has_group_fk1', 'user_has_group', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('user_has_group_fk2', 'user_has_group', 'group_id', 'group', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('dateAndTime_fk1', 'dateAndTime', 'date_id', 'date', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('appointment_fk1', 'appointment', 'parent_child_id', 'parent_child', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('appointment_fk2', 'appointment', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('appointment_fk3', 'appointment', 'dateAndTime_id', 'dateAndTime', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('blockedAppointment_fk1', 'blockedAppointment', 'dateAndTime_id', 'dateAndTime', 'id', 'CASCADE', 'NO ACTION');
        $command->addForeignKey('blockedAppointment_fk2', 'blockedAppointment', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * fills role Table
     * @param CdbCommand $command
     */
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

    /**
     * creates all database stuff which is important for this application
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function tables() {
        $rc = true;
        $connection = $this->getConnection();
        if ($connection->active) {
            try {
                $command = $connection->createCommand();
                $this->createTables($command);
                $this->addForeignKeys($command);
                $this->createIndices($command);
                $this->fillTable($command);
            } catch (CException $e) {
                Yii::app()->user->setFlash('failMsg', 'Die Datenbanktabellen konnten nicht angelegt werden. Entweder sind diese schon vorhanden oder es trat ein Fehler auf.');
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'application.models.configForm');
                $rc = true;
            }
        } else {
            $this->addError('databaseHost', 'Die Datenbankverbindung konnte nicht hergestellt werden.');
            $rc = false;
        }

        return $rc;
    }

    /**
     * returns database Management System
     * @return string
     */
    public function getDBMS() {
        return $this->getParam('databaseManagementSystem');
    }

    /**
     * returns param from params.php / params.inc
     * @param string $param
     * @return string
     */
    public function getParam($param) {
        $params = $this->getParams();
        return $params[$param];
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * gets all params from /config/params.php
     * @return array 
     */
    public function getParams() {
        if ($this->firstRead) {
            $this->firstRead = false;
            $this->params = require (__DIR__ . '/../config/params.php');
        }
        return $this->params;
    }

    /**
     * sets connection
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return \CDbConnection
     */
    public function getConnection() {
        $connection = new CDbConnection($this->getDBMS() . ':host=' . $this->getParam('databaseHost') . ';dbname=' . $this->getParam('databaseName'), $this->getParam('databaseUsername'), $this->getParam('databasePassword'));
        try {
            $connection->setActive(true);
        } catch (CException $ex) {
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR, 'application.models.configForm');
            Yii::app()->user->setFlash('failMsg', 'Verbindung zur Datenbank konnte nicht hergestellt werden. <br>' . $ex->getMessage());
        }
        return $connection;
    }

}

?>
