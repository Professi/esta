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

    const mysql = 'mysql';

    public $adminEmail;
    public $dateTimeFormat;
    public $smtpAuth;
    public $smtpPassword;
    public $fromMailHost;
    public $fromMail;
    public $emailHost;
    public $smtpLocal;
    public $schoolName;
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
    public $pepper;
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
    public $logoPath;
    public $textHeader;
    public $appName;
    public $language;
    public $smtpSecure;
    public $smtpPort;
    public $allowParentsToManageChilds;
    public $hashCost;
    public $tanSize;
    public $teacherAllowBlockTeacherApps;
    public $schoolWebsiteLink;
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
            array('adminEmail,dateTimeFormat,emailHost,fromMail' .
                ',schoolName,mailsActivated,maxChild,'
                . 'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,' .
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,' .
                'durationTempBans,maxAttemptsForLogin,timeFormat,dateFormat,' .
                'allowBlockingAppointments,appointmentBlocksPerDate,' .
                'lengthReasonAppointmentBlocked,schoolStreet,schoolCity,' .
                'schoolTele,schoolFax,schoolEmail,allowBlockingOnlyForManagement,' .
                'lockRegistration,allowGroups,databasePort,allowParentsToManageChilds,' .
                'logoPath,textHeader,language,appName,hashCost,' .
                'teacherAllowBlockTeacherApps,smtpPort,smtpLocal,tanSize,schoolWebsiteLink', 'required'),
            array('adminEmail,schoolEmail', 'email'),
            array('language', 'length', 'min' => 2),
            array('emailHost,fromMail,dateFormat,appName', 'length', 'min' => 3),
            array('dateTimeFormat', 'length', 'min' => 5),
            array('defaultTeacherPassword', 'length', 'min' => 5),
            array('pepper', 'length', 'min' => 16, 'max' => 255),
            array('mailsActivated,randomTeacherPassword,banUsers,allowBlockingAppointments,' .
                'useSchoolEmailForContactForm,allowBlockingOnlyForManagement,lockRegistration,' .
                'allowParentsToManageChilds,allowGroups,teacherAllowBlockTeacherApps,smtpAuth,smtpLocal',
                'boolean'),
            array('maxChild,maxAppointmentsPerChild,minLengthPerAppointment,'
                . 'durationTempBans,maxAttemptsForLogin,appointmentBlocksPerDate,'
                . 'lengthReasonAppointmentBlocked,databasePort,smtpPort,maxTanGen,tanSize',
                'numerical', 'integerOnly' => true, 'min' => 1),
            array('hashCost', 'numerical', 'integerOnly' => true, 'min' => 13),
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail' .
                ',schoolName,mailsActivated,maxChild,'
                . 'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,' .
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,' .
                'durationTempBans,maxAttemptsForLogin,salt,installed,dateFormat,timeFormat,' .
                'allowBlockingAppointments,appointmentBlocksPerDate,' .
                'lengthReasonAppointmentBlocked,smtpAuth,smtpSecure,smtpPort,smtpLocal,smtpPassword,tanSize,schoolWebsiteLink', 'safe'),
        );
    }

    /**
     * attributeLabels
     * @return array
     */
    public function attributeLabels() {
        return array(
            'adminEmail' => Yii::t('app', 'Administrator E-Mail Adresse'),
            'dateTimeFormat' => Yii::t('app', 'Datums und Zeitformat (z.B. d.m.Y H:i)'),
            'fromMailHost' => Yii::t('app', 'Versender E-Mailadresse (z.B. esta)'),
            'fromMail' => Yii::t('app', 'Absendername (z.B. ESTA-School)'),
            'emailHost' => Yii::t('app', 'Domainname des SMTP Servers (z.B. schoolxyz.de)'),
            'schoolName' => Yii::t('app', 'Schulname (z.B. Schule XYZ)'),
            'mailsActivated' => Yii::t('app', 'E-Mails versenden?'),
            'maxChild' => Yii::t('app', 'Maximale Anzahl an Kindern pro Eltern'),
            'maxAppointmentsPerChild' => Yii::t('app', 'Maximale Anzahl an Terminen pro Kind'),
            'randomTeacherPassword' => Yii::t('app', 'Lehrerpasswörter bei deren Erstellung zufällig generieren?'),
            'defaultTeacherPassword' => Yii::t('app', 'Standardpasswort wenn die vorherige Option deaktiviert ist'),
            'minLengthPerAppointment' => Yii::t('app', 'Mindestlänge eines Termins bei einem neuzuerstellenden Elternsprechtag'),
            'banUsers' => Yii::t('app', 'Temporäres Sperren eines Nutzers bei zu vielen fehlgeschlagenen Loginversuchen'),
            'durationTempBans' => Yii::t('app', 'Dauer der Sperre in Minuten'),
            'maxAttemptsForLogin' => Yii::t('app', 'Maximalanzahl an fehlgeschlagenen Loginversuchen bis zur Sperrung eines Kontos'),
            'pepper' => Yii::t('app', 'Pfeffer für Passwörter'),
            'hashCost' => Yii::t('app', 'Rechenaufwand für das Hashen der Passwörter'),
            'dateFormat' => Yii::t('app', 'Datumsformat (z.B. d.m.Y)'),
            'timeFormat' => Yii::t('app', 'Zeitformat (z.B. H:i)'),
            'allowBlockingAppointments' => Yii::t('app', 'Blockieren von Terminen erlauben?'),
            'appointmentBlocksPerDate' => Yii::t('app', 'Anzahl der Termine die blockiert werden dürfen'),
            'lengthReasonAppointmentBlocked' => Yii::t('app', 'Minimallänge eines Grundes um einen Termin zu blocken'),
            'schoolStreet' => Yii::t('app', 'Straße'),
            'schoolCity' => Yii::t('app', 'Postleitzahl, Ort'),
            'schoolTele' => Yii::t('app', 'Telefonnummer'),
            'schoolFax' => Yii::t('app', 'Faxnummer'),
            'schoolEmail' => Yii::t('app', 'E-Mail Adresse der Schule'),
            'smtpAuth' => Yii::t('app', 'SMTP Authentifizierung?'),
            'smtpPassword' => Yii::t('app', 'SMTP Passwort'),
            'useSchoolEmailForContactForm' => Yii::t('app', 'E-Mail Adresse der Schule für das Kontaktformular verwenden?'),
            'allowBlockingOnlyForManagement' => Yii::t('app', 'Nur Verwaltung und Administration dürfen Termine blockieren?'),
            'lockRegistration' => Yii::t('app', 'Registrierung sperren?'),
            'allowGroups' => Yii::t('app', 'Gruppen erlauben?'),
            'logoPath' => Yii::t('app', 'Pfad des Schullogos in der Anwendung'),
            'textHeader' => Yii::t('app', 'Headertext zwischen Anwendungslogo und Schullogo'),
            'language' => Yii::t('app', 'Sprache'),
            'appName' => Yii::t('app', 'Anwendungsname'),
            'databasePort' => Yii::t('app', 'Datenbankport'),
            'smtpSecure' => Yii::t('app', 'SMTP- Sicherheit(z.B. ssl oder tls), kann leer gelassen werden'),
            'smtpPort' => Yii::t('app', 'SMTP- Port'),
            'smtpLocal' => Yii::t('app', 'Lokaler SMTP Server?'),
            'maxTanGen' => Yii::t('app', 'Maximal Anzahl generierte TAN\'s'),
            'tanSize' => Yii::t('app', 'Länge einer TAN'),
            'allowParentsToManageChilds' => Yii::t('app', 'Sollen Eltern die Daten über Ihre Kinder verwalten können?'),
            'teacherAllowBlockTeacherApps' => Yii::t('app', 'Dürfen Lehrer Termine anderer Lehrer blockieren?'),
            'schoolWebsiteLink' => Yii::t('app', 'Schullink')
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
        $command->createTable('configs', array(
            'key' => 'string pk NOT NULL',
            'value' => 'string NOT NULL',
        ));
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
     * mysql charset for columns with case sensitives char collation
     * @return string
     */
    private function mysqlCSColumnCharset() {
        return 'CHARACTER SET utf8 COLLATE utf8_bin';
    }

    /**
     * returns collation for database
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param boolean $column
     * @return string
     */
    public function getCollation($column = false) {
        return $column ? $this->mysqlCSColumnCharset() : $this->mysqlCharset();
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
        $command->createIndex('idx_appointment_2', 'appointment', 'parent_child_id,user_id,dateAndTime_id', true);
        $command->createIndex('idx_date_has_group1', 'date_has_group', 'date_id,group_id', true);
        $command->createIndex('idx_user_has_group1', 'user_has_group', 'user_id,group_id', true);
        $command->createIndex('idx_dateAndTime_date_id_time', 'dateAndTime', 'time,date_id', true);
        $command->createIndex('idx_user_username', 'user', 'username', true);
        $command->createIndex('idx_parentChild_unq1', 'parent_child', 'user_id,child_id', true);
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
            'title' => Yii::t('app', 'Administration'),
        ));
        $command->insert('role', array(
            'id' => 1,
            'title' => Yii::t('app', 'Verwaltung')
        ));
        $command->insert('role', array(
            'id' => 2,
            'title' => Yii::t('app', 'Lehrer'),
        ));
        $command->insert('role', array(
            'id' => 3,
            'title' => Yii::t('app', 'Eltern'),
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
                $this->createConfig($command);
            } catch (CException $e) {
                Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Die Datenbanktabellen konnten nicht angelegt werden. Entweder sind diese schon vorhanden oder es trat ein Fehler auf.'));
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'application.models.configForm');
                $rc = true;
            }
        } else {
            $this->addError('databaseHost', Yii::t('app', 'Zur Datenbank konnte keine Verbindung hergestellt werden.'));
            $rc = false;
        }
        return $rc;
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

    public function createConfig($command) {
        $config = $this->getInitConfig();
        foreach ($config as $key => $value) {
            $command->insert('configs', array(
                'key' => $key, 'value' => $value));
        }
    }

    public function getInitConfig() {
        return array(
            'appName' => Yii::t('app', 'Elternsprechtag'),
            'adminEmail' => 'test@test.de', //Administrator E-Mail Adresse
            'hashCost' => 13,
            'dateTimeFormat' => 'd.m.Y H:i', //Datumsformat -  muss nicht geändert werden
            'emailHost' => 'localhost', //Sofern der SMTP Server auf dem selben Server läuft einfach localhost
            'fromMailHost' => '', //Absender der Mails wird wohl später dann EST@school.de
            'fromMail' => 'ESTA', //Der Absendername bsp. BWS-Hofheim,
            'schoolName' => Yii::t('app', 'Schulname'),
            'mailsActivated' => true, //ob Mails versendet werden solen
            'maxChild' => 3, //Maximal Anzahl von eintragbaren Kindern pro Benutzer mit Elternrolle
            'tanSize' => 6, //Länge der Tans
            'maxTanGen' => 100, //Maximal auf einmal generierbare Anzahl an TANs
            'maxAppointmentsPerChild' => 5, //Maximal Anzahl an Terminen pro Kind
            'defaultTeacherPassword' => 'DONNERSTAG01', //Standardlehrerpasswort sofern randomTeacherPassword false ist sollte dieses gesetzt werden
            'randomTeacherPassword' => 0, //true or false
            'minLengthPerAppointment' => 5, //Minimallänge eines Termins bei Elternsprechtagserstellung
            'banUsers' => true, //Automatische Usersperrung bei n-Versuchen , true Aktiviert - False Deaktiviert
            'durationTempBans' => 5, //Dauer die ein Account gesperrt wird bei 3-facher Fehleingabe des Passworts
            'maxAttemptsForLogin' => 5, //Maximalanzahl von Loginversuchen bis zur Sperrung
            'timeFormat' => 'H:i',
            'dateFormat' => 'd.m.Y',
            'allowBlockingAppointments' => true,
            'allowBlockingOnlyForManagement' => true,
            'appointmentBlocksPerDate' => 2,
            'lengthReasonAppointmentBlocked' => 5,
            'schoolStreet' => '',
            'schoolCity' => Yii::t('app', 'PLZ Ort'),
            'schoolTele' => Yii::t('app', 'Telefonnummer'),
            'schoolFax' => Yii::t('app', 'Faxnummer'),
            'schoolEmail' => 'office@schuldomain.de',
            'useSchoolEmailForContactForm' => true,
            'lockRegistration' => false,
            'allowGroups' => false,
            'logoPath' => '/img/logo.png',
            'schoolWebsiteLink' => 'schooldomain.de',
            'smtpAuth' => false,
            'smtpLocal' => true,
            'smtpPort' => 25,
            'smtpSecure' => '',
            'smtpPassword' => '',
            'textHeader' => Yii::t('der'),
            'language' => 'de',
            'allowParentsToManageChilds' => true);
    }

    /**
     * sets connection
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return \CDbConnection
     */
    public function getConnection() {
        $connection = new CDbConnection('mysql:host=' . $this->getParam('databaseHost') . ';dbname=' . $this->getParam('databaseName'), $this->getParam('databaseUsername'), $this->getParam('databasePassword'));
        try {
            $connection->setActive(true);
        } catch (CException $ex) {
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR, 'application.models.configForm');
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Zur Datenbank konnte keine Verbindung hergestellt werden.') . '<br>' . $ex->getMessage());
        }
        return $connection;
    }

}

?>
