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

    public $adminEmail;
    public $dateTimeFormat;
    public $smtpAuth;
    public $smtpPassword;
    public $fromMailHost;
    public $fromMail;
    public $emailHost;
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
                'lockRegistration,allowGroups,allowParentsToManageChilds,' .
                'logoPath,textHeader,language,appName,hashCost,' .
                'teacherAllowBlockTeacherApps,smtpPort,tanSize,schoolWebsiteLink', 'required'),
            array('adminEmail,schoolEmail', 'email'),
            array('language', 'length', 'min' => 2),
            array('emailHost,fromMail,dateFormat,appName', 'length', 'min' => 3),
            array('dateTimeFormat', 'length', 'min' => 5),
            array('defaultTeacherPassword', 'length', 'min' => 5),
            array('mailsActivated,randomTeacherPassword,banUsers,allowBlockingAppointments,' .
                'useSchoolEmailForContactForm,allowBlockingOnlyForManagement,lockRegistration,' .
                'allowParentsToManageChilds,allowGroups,teacherAllowBlockTeacherApps,smtpAuth',
                'boolean'),
            array('maxChild,maxAppointmentsPerChild,minLengthPerAppointment,'
                . 'durationTempBans,maxAttemptsForLogin,appointmentBlocksPerDate,'
                . 'lengthReasonAppointmentBlocked,smtpPort,maxTanGen,tanSize',
                'numerical', 'integerOnly' => true, 'min' => 1),
            array('hashCost', 'numerical', 'integerOnly' => true, 'min' => 13),
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail' .
                ',schoolName,mailsActivated,maxChild,'
                . 'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,' .
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,' .
                'durationTempBans,maxAttemptsForLogin,salt,installed,dateFormat,timeFormat,' .
                'allowBlockingAppointments,appointmentBlocksPerDate,hashCost,' .
                'lengthReasonAppointmentBlocked,smtpAuth,smtpSecure,smtpPort,smtpPassword,tanSize,schoolWebsiteLink', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'adminEmail' => Yii::t('app', 'Administrator E-Mail Adresse'),
            'dateTimeFormat' => Yii::t('app', 'Datums und Zeitformat (z.B. d.m.Y H:i)'),
            'fromMailHost' => Yii::t('app', 'SMTP Benutzername'),
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
            'smtpSecure' => Yii::t('app', 'SMTP Sicherheit(z.B. ssl oder tls), kann leer gelassen werden'),
            'smtpPort' => Yii::t('app', 'SMTP Port'),
            'maxTanGen' => Yii::t('app', 'Maximal Anzahl generierte TAN\'s'),
            'tanSize' => Yii::t('app', 'Länge einer TAN'),
            'allowParentsToManageChilds' => Yii::t('app', 'Sollen Eltern die Daten über Ihre Kinder verwalten können?'),
            'teacherAllowBlockTeacherApps' => Yii::t('app', 'Dürfen Lehrer Termine anderer Lehrer blockieren?'),
            'schoolWebsiteLink' => Yii::t('app', 'Schullink')
        );
    }

    public function config(&$reflectionClass) {
        if ($this->validate()) {
            $properties = $reflectionClass->getProperties();
            foreach ($properties as $prop) {
                $entry = ConfigEntry::model()->findByPk($prop->getName());
                $entry->value = $prop->getValue($this);
                $entry->update();
            }
            Yii::app()->user->setFlash('success', Yii::t('app', 'Konfiguration aktualisiert.'));
        }
    }

}

?>
