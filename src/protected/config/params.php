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
$arr = unserialize(base64_decode(file_get_contents(dirname(__FILE__) . '/params.inc')));
$array2 = array(
    'installed' => false,
    'appName' => 'Elternsprechtag',
    'adminEmail' => '', //Administrator E-Mail Adresse
    'pepper' => 'e9HOiJFfDhyvcBMin5G8CBTR98wK', //der Applikationssalt sollte mindestens 30 Zeichen lang sein und nur aus alphanumerischen Zeichen bestehen 
    'hashCost' => 13,
    'dateTimeFormat' => 'd.m.Y H:i', //Datumsformat -  muss nicht geändert werden
    'emailHost' => 'localhost', //Sofern der SMTP Server auf dem selben Server läuft einfach localhost
    'fromMailHost' => '', //Absender der Mails wird wohl später dann EST@bws-hofheim.de
    'fromMail' => 'ESTA', //Der Absendername bsp. BWS-Hofhei,
    'teacherMail' => 'schuldomain.de',
    'schoolName' => 'Schulname',
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
    'schoolCity' => 'PLZ Ort',
    'schoolTele' => 'Telefonnummer',
    'schoolFax' => 'Faxnummer',
    'schoolEmail' => 'office@schuldomain.de',
    'useSchoolEmailForContactForm' => true,
    'lockRegistration' => false,
    'allowGroups' => false,
    'databaseHost' => 'localhost',
    'databaseName' => 'estdb',
    'databaseUsername' => 'estdb',
    'databasePassword' => '',
    'databasePort' => '3306',
    'databaseManagementSystem' => 'mysql',
    'logoPath' => '/img/logo.png',
    'smtpAuth' => false,
    'smtpPort' => 25,
    'smtpSecure' => '',
    'smtpPassword' => '',
    'textHeader' => 'der',
    'language' => 'de',
    'allowParentsToManageChilds' => true,
);
if (!is_array($arr) || empty($arr)) {
    return $array2;
} else {
    return CMap::mergeArray($array2, $arr);
}
?>
