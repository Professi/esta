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
                'schoolTele,schoolFax,schoolEmail,allowBlockingOnlyForManagement,lockRegistration,allowGroups', 'required'),
            array('fromMailHost,adminEmail,schoolEmail', 'email'),
            array('emailHost,fromMail,dateFormat', 'length', 'min' => 4),
            array('dateTimeFormat', 'length', 'min' => 5),
            array('defaultTeacherPassword', 'length', 'min' => 8),
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
            'allowBlockingAppointments'=>'Blockieren von Terminen erlauben?',
            'appointmentBlocksPerDate'=>'Anzahl der Termine die blockiert werden dürfen',
            'lengthReasonAppointmentBlocked'=>'Minimallänge eines Grundes um einen Termin zu blocken',
            'schoolStreet'=>'Straße',
            'schoolCity'=>'Postleitzahl, Ort',
            'schoolTele'=>'Telefonnummer',
            'schoolFax'=>'Faxnummer',
            'schoolEmail'=>'E-Mail Adresse der Schule',
            'useSchoolEmailForContactForm'=>'E-Mail Adresse der Schule für das Kontaktformular verwenden?',
            'allowBlockingOnlyForManagement'=>'Nur Verwaltung und Administration dürfen Termine blockieren?',
            'lockRegistration'=>'Registrierung sperren?',
            'allowGroups'=>'Gruppen erlauben?'
            );
    }
    
    public function createTables() {
        $command = Yii::app()->db->createCommand();
        $command->createTable("child", array(
            'id'=>'pk',
            'firstname' =>'string NOT NULL',
            'lastname'=>'string NOT NULL',
        ));
        $command->createTable("YiiSession", array(
            'id'=>'string NOT NULL',
            'expire'=>'integer',
            'data'=>'binary',
        ));
        $command->createTable("YiiCache", array(
            'id'=>'string NOT NULL',
            'expire'=>'integer',
            'value'=>'blob',
        ));
        $command->createTable('group', array(
            'id'=>'pk',
            'groupname'=>'string NOT NULL'
        ));
        $command->createIndex('idx_group_name', 'group', 'groupname', true);
        $command->createTable('role', array(
            'id'=>'pk',
            'title'=>'string NOT NULL',
            'description'=>'string',
        ));
        $command->createIndex('idx_role_title', 'role','title',true);
        $role = new Role();
        $role->id = 0;
        $role->title = 'Administration';
        $role->insert();
        $role->id = 1;
        $role->title = 'Verwaltung';
        $role->insert();
        $role->id = 2;
        $role->title = 'Lehrer';
        $role->id = 3;
        $role->title = 'Eltern';
        $command->createTable('user', array(
            'id'=>'pk',
            'username'=>'string NOT NULL',
            'email'=>'string',
            'activationKey'=>'string NOT NULL',
            'createtime'=>'timestamp',
            'firstname'=>'string NOT NULLL',
            'lastname'=>'string NOT NULL',
            'title'=>'string',
            'state'=>'tinyint(3)',
            'lastLogin'=>'timestamp',
            'badLogins'=>'tinyInt(4)',
            'bannedUntil'=>'timestamp',
            'password'=>'string',
        ));
    }
    
}
?>
