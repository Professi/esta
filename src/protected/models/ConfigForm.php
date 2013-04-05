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
    
    public function init() {
       $this->attributes = Yii::app()->params->toArray();
    }
    
    public function rules() {
        return array(
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail'.
                ',teacherMail,schoolName,virtualHost,mailsActivated,maxChild,'
                .'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,'.
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,'.
                'durationTempBans,maxAttemptsForLogin','required'),
            array('fromMailHost,adminEmail','email'),
            array('emailHost,fromMail','length','min'=>4),
            array('dateTimeFormat','length','min'=>5),
            array('defaultTeacherPassword','length','min'=>8),
            array('salt','length','min'=>16, 'max'=>64),
            array('mailsActivated,randomTeacherPassword,banUsers','boolean'),
            array('maxChild,maxAppointmentsPerChild,minLengthPerAppointment,durationTempBans,maxAttemptsForLogin','numerical', 'integerOnly'=>true),
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail'.
                ',teacherMail,schoolName,virtualHost,mailsActivated,maxChild,'
                .'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,'.
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,'.
                'durationTempBans,maxAttemptsForLogin,salt,installed', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'adminEmail'=>'Administrator E-Mail Adresse',
            'dateTimeFormat'=>'Datumsformat (z.B. d.m.Y H:i, siehe http://php.net/manual/de/function.date.php)', //
            'emailHost'=>'Hostname des SMTP Servers (z.B. localhost)',
            'fromMailHost'=>'Versender E-Mailadresse (z.B. xyz@schoolxyz.de)',
            'fromMail'=>'Absendername (z.B. ESTA-School)',
            'teacherMail'=>'Domainname des SMTP Servers (z.B. schoolxyz)',
            'schoolName'=>'Schulname (z.B. Schule XYZ)',
            'virtualHost'=>'Virtualhost-Pfad unter dem die Anwendung erreichbar ist (z.B. /est/)',
            'mailsActivated'=>'E-Mails versenden? true|false',
            'maxChild'=>'Maximal Anzahl an Kindern pro Eltern',
            'maxAppointmentsPerChild'=>'Maximal Anzahl an Terminen pro Kinder',
            'randomTeacherPassword'=>'Lehrerpasswörter bei deren Erstellung zufällig generieren? true|false',
            'defaultTeacherPassword'=>'Standardpasswort wenn die vorherige Option deaktiviert ist',
            'minLengthPerAppointment'=>'Mindestlänge eines Termins bei einem neuzuerstellenden Elternsprechtags',
            'banUsers'=>'Antispam-Mechanismus, temporäres Sperren eines Nutzers bei zu vielen fehlgeschlagenen Loginversuchen in Minuten',
            'durationTempBans'=>'Dauer dieser Maßnahme',
            'maxAttemptsForLogin'=>'Maximalanzahl an fehlgeschlagenen Loginversuchen',
            'salt'=>'Salz für Passwörter',
            );
    }
    
    
}

?>
