<?php
/**
 * Mail ist eine Klasse um Mails zu versenden die die Extension EMailer verwendet
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class Mail {

    /**
     * Versendet eine E-Mail
     * @param string $subject Betreff einer E-Mail
     * @param string $message Nachricht einer E-Mail
     * @param string $to Empfänger der Nachricht
     * @param string $from Absender der Nachricht
     * @param string $fromName Absendername
     */
    public function sendMail($subject, $message, $to, $from, $fromName) {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->Host = Yii::app()->params['emailHost'];
        $mailer->IsSMTP();
        $mailer->From = $from;
        $mailer->AddAddress($to);
        $mailer->FromName = $fromName;
        $mailer->CharSet = 'UTF-8';
        $mailer->ContentType = 'text/html';
        $mailer->Subject = $subject;
        $mailer->Body = $message;
        $mailer->Send();
    }

    /**
     * Sendet einen Aktivierungslink um das Passwort zu ändern.
     * @param type $email E-Mail des Empfängers
     * @param type $activationKey Aktivierungsschlüssel
     */
    public function sendChangePasswordMail($email, $activationKey) {
        $body = "<html><head><title>Ihre Passwortzurücksetzung bei der " . Yii::app()->name . "</title><body>\n";
        $body .= "<p>Ihr Passwort wurde erfolgreich zurückgesetzt. Bitte klicken Sie auf folgenden Link um ein neues Passwort für Ihren Account zu setzen</p>\n";
        $body .= "<p><a href=\"" . "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/NewPw&activationKey=" . $activationKey . "\">Link f&uuml;r die Passwortwahl</a></p>\n";
        $body .= "<p>Sollten Sie Probleme beim Aufrufen der Aktivierung haben kopieren Sie bitte den folgenden Link in die Adressleiste ihres Browser.</p>\n";
        $body .= "<p>http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/NewPw&activationKey=" . $activationKey . "</p>\n";
        $body .= "<p>Falls Sie kein neues Passwort angefordert haben, ignorieren Sie bitte diese Nachricht.</p>\n";
        $body .= "<p>Sollten Sie noch Fragen oder Anregungen haben benutzen Sie das Kontaktformular auf der Webseite.</p>\n";
        $body .= "<p>Das Team der Elternsprechtagsapplikation w&uuml;nscht Ihnen weiterhin ein gutes Gelingen.</p>\n";
        $body .= "<p>(Dies ist eine automatisch versendete E-Mail. Bitte antworten Sie nicht auf dieses Schreiben, da die E-Mail-Adresse nur zum Versenden, nicht aber zum Empfang von E-Mails eingerichtet ist.)</p>\n";
        $body .= "</body></html>\n";
        $this->sendMail(Yii::app()->params['fromMail'] . ' Passwort ändern', $body, $email, Yii::app()->params['fromMailHost'], Yii::app()->params['fromMail']);
    }

    /**
     * Sendet ein Aktivierungslink
     * @param type $email E-Mail des Empfängers
     * @param type $activationKey  Aktivierungsschlüssel
     */
    public function sendActivationLinkMail($email, $activationKey) {
        $body = "<html><head><title>Ihre Registrierung bei der " . Yii::app()->name . "</title>";
        $body .= "<body><p>Vielen Dank f&uuml;r Ihre Registrierung bei der " . Yii::app()->name . ".</p>";
        $body .= "<p>Ihr Accountname lautet:" . $email . "</p>";
        $body .= "<p>Um Ihre Registrierung abzuschlie&szlig;en und die Applikation in Anspruch nehmen zu k&ouml;nnen klicken Sie bitte auf den folgenden Link.</p>";
        $body .= "<p><a href=\"" . "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/activate&activationKey=" . $activationKey . "\">Link f&uuml;r die Aktivierung</a></p>";
        $body .= "<p>Sollten Sie Probleme beim Aufrufen der Aktivierung haben kopieren Sie bitte den folgenden Link in die Adressleiste ihres Browser.</p>";
        $body .= "<p>http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/NewPw&activationKey=" . $activationKey . "</p>";
        $body .= "<p>Sollten Sie noch Fragen oder Anregungen haben benutzen Sie das Kontaktformular auf der Webseite.</p>";
        $body .= "<p>Das Team der Elternsprechtagsapplikation w&uuml;nscht Ihnen weiterhin ein gutes Gelingen.</p>";
        $body .= "<p>(Dies ist eine automatisch versendete E-Mail. Bitte antworten Sie nicht auf dieses Schreiben, da die E-Mail-Adresse nur zum Versenden, nicht aber zum Empfang von E-Mails eingerichtet ist.)</p>";
        $body .= "</body></html>";
        $this->sendMail(Yii::app()->params['fromMail'] . ' Accountaktivierung', $body, $email, Yii::app()->params['fromMailHost'], Yii::app()->params['fromMail']);
    }

    /**
     * Sendet eine Benachrichtungsemail dass ein Termin gelöscht wurde.
     * @param type $email E-Mail Adresse des zu Informierenden
     * @param type $user Lehrer
     * @param type $time Uhrzeit
     * @param type $child Kind
     * @param type $date Datum
     */
    public function sendAppointmentDeleted($email, $teacher, $time, $child, $date) {
        $body = "<html><head><title>Einer Ihrer Termine bei der Elternsprechtagsapplikation der " . Yii::app()->name . "</title>";
        $body .= "<body><p>Leider müssen wir Sie dar&uuml;ber informieren, dass einer Ihrer Termine gel&ouml;scht wurde.</p>";
        $body .= "<p>Termin</p>";
        $body .= "<p>Am " . date('d.m.Y', strtotime($date)) . " um  " . date('H:i', strtotime($time)) . "</p>";
        $body .= "<p>Bei " . $teacher->title . " " . $teacher->firstname . " " . $teacher->lastname . "</p>";
        $body .= "<p>Mit ihrem Kind " . $child->firstname . " " . $child->lastname . "</p>";
        $body .= "<p>Sollten Sie noch Fragen oder Anregungen haben benutzen Sie das Kontaktformular auf der Webseite.</p>";
        $body .= "<p>Das Team der Elternsprechtagsapplikation w&uuml;nscht Ihnen weiterhin ein gutes Gelingen.</p>";
        $body .= "<p>(Dies ist eine automatisch versendete E-Mail. Bitte antworten Sie nicht auf diese Nachricht, da die E-Mail-Adresse nur zum Versenden, nicht aber zum Empfang von E-Mails eingerichtet ist.)</p>";
        $body .= "</body></html>";
        $this->sendMail(Yii::app()->params['fromMail'] . ' Termin gel&ouml;scht', $body, $email, Yii::app()->params['fromMailHost'], Yii::app()->params['fromMail']);
    }

}

?>
