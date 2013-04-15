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
                'schoolTele,schoolFax,schoolEmail', 'required'),
            array('fromMailHost,adminEmail,schoolEmail', 'email'),
            array('emailHost,fromMail,dateFormat', 'length', 'min' => 4),
            array('dateTimeFormat', 'length', 'min' => 5),
            array('defaultTeacherPassword', 'length', 'min' => 8),
            array('salt', 'length', 'min' => 16, 'max' => 64),
            array('mailsActivated,randomTeacherPassword,banUsers,allowBlockingAppointments,useSchoolEmailForContactForm',
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
            'virtualHost' => 'Virtualhost-Pfad unter dem die Anwendung erreichbar ist (z.B. /est/)',
            'mailsActivated' => 'E-Mails versenden?',
            'maxChild' => 'Maximal Anzahl an Kindern pro Eltern',
            'maxAppointmentsPerChild' => 'Maximal Anzahl an Terminen pro Kinder',
            'randomTeacherPassword' => 'Lehrerpasswörter bei deren Erstellung zufällig generieren?',
            'defaultTeacherPassword' => 'Standardpasswort wenn die vorherige Option deaktiviert ist',
            'minLengthPerAppointment' => 'Mindestlänge eines Termins bei einem neuzuerstellenden Elternsprechtag',
            'banUsers' => 'Temporäres Sperren eines Nutzers bei zu vielen fehlgeschlagenen Loginversuchen',
            'durationTempBans' => 'Dauer dieser Maßnahme',
            'maxAttemptsForLogin' => 'Maximalanzahl an fehlgeschlagenen Loginversuchen',
            'salt' => 'Salz für Passwörter',
            'dateFormat' => 'Datumsformat (z.B. d.m.Y)',
            'timeFormat' => 'Zeitformat (z.B. H:i)',
            'allowBlockingAppointments'=>'Blockieren von Terminen erlauben',
            'appointmentBlocksPerDate'=>'Anzahl der Termine die blockiert werden dürfen',
            'lengthReasonAppointmentBlocked'=>'Minimallänge eines Grundes um einen Termin zu blocken',
            'schoolStreet'=>'Straße',
            'schoolCity'=>'Postleitzahl, Ort',
            'schoolTele'=>'Telefonnummer',
            'schoolFax'=>'Faxnummer',
            'schoolEmail'=>'E-Mail Adresse der Schule',
            'useSchoolEmailForContactForm'=>'E-Mail Adresse der Schule für das Kontaktformular verwenden',
            );
    }
}
?>
