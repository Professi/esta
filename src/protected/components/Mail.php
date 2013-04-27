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
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
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
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param type $email E-Mail des Empfängers
     * @param type $activationKey Aktivierungsschlüssel
     */
    public function sendChangePasswordMail($email, $activationKey) {
        $body = "<html><head><title></title></head><body>\n";
        $body .= "<p>Bitte klicken Sie auf folgenden Link um ein neues Passwort für Ihr Benutzerkonto zu setzen</p>\n";
        $body .= "<p><a href=\"" . "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/NewPw&activationKey=" . $activationKey . "\">Link f&uuml;r die Passwortwahl</a></p>\n";
        $body .= "<p>Sollten Sie Probleme beim Aufrufen der Aktivierung haben kopieren Sie bitte den folgenden Link in die Adressleiste ihres Browser.</p>\n";
        $body .= "<p>http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/NewPw&activationKey=" . $activationKey . "</p>\n";
        $body .= "<p>Falls Sie kein neues Passwort angefordert haben, ignorieren Sie bitte diese Nachricht.</p>\n";
        $this->addInfo($body);
        $body .= "</body></html>\n";
        $this->send("Ihre Passwortzurücksetzung bei der " . Yii::app()->name, $body, $email);
    }

    /**
     * Sendet ein Aktivierungslink
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param type $email E-Mail des Empfängers
     * @param type $activationKey  Aktivierungsschlüssel
     */
    public function sendActivationLinkMail($email, $activationKey) {
        $body = "<html><head><title></title></head>";
        $body .= "<body><p>Vielen Dank f&uuml;r Ihre Registrierung bei der " . Yii::app()->name . ".</p>";
        $body .= "<p>Ihr Benutzername lautet:" . $email . "</p>";
        $body .= "<p>Um Ihre Registrierung abzuschlie&szlig;en und die Anwendung in Anspruch nehmen zu k&ouml;nnen klicken Sie bitte auf den folgenden Link.</p>";
        $body .= "<p><a href=\"" . "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/activate&activationKey=" . $activationKey . "\">Link f&uuml;r die Aktivierung</a></p>";
        $body .= "<p>Sollten Sie Probleme beim Aufrufen der Aktivierung haben kopieren Sie bitte den folgenden Link in die Adressleiste ihres Browser.</p>";
        $body .= "<p>http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/NewPw&activationKey=" . $activationKey . "</p>";
        $this->addInfo($body);
        $body .= "</body></html>";
        $this->send("Ihre Registrierung bei der " . Yii::app()->name, $body, $email);
    }

    /**
     * Sendet eine Benachrichtungsemail dass ein Termin gelöscht wurde.
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param type $email E-Mail Adresse des zu Informierenden
     * @param type $user Lehrer
     * @param type $time Uhrzeit
     * @param type $child Kind
     * @param type $date Datum
     */
    public function sendAppointmentDeleted($email, $teacher, $time, $child, $date) {
        $body = "<html><head><title></title></head>";
        $body .= "<body><p>Hallo,</p><p>leider m&uuml;ssen wir Sie dar&uuml;ber informieren, dass Ihr Termin am <b>" . date('d.m.Y', strtotime($date)) . " um  " . date('H:i', strtotime($time)) . "</b><br>";
        $body .= " bei <b>" . $teacher->title . " " . $teacher->firstname . " " . $teacher->lastname . "</b><br>";
        $body .= "mit ihrem Kind <b>" . $child->firstname . " " . $child->lastname . "</b> <br>abgesagt wurde.</p>";
        $this->addInfo($body);
        $body .= "</body></html>";
        $this->send("Einer Ihrer Termine bei der " . Yii::app()->name . " wurde gel&oeml;scht", $body, $email);
    }

    public function sendRandomUserPassword($email, $password, $isTeacher = true) {
        $body = "<html><head><title></title></head>";
        if ($isTeacher) {
            $body .= "<body><p>Sie wurden bei der " . Yii::app()->name . " als Lehrer registriert.</p>";
        } else {
            $body .= "<body><p>Sie wurden bei der " . Yii::app()->name . " registriert.</p>";
        }
        $body .= "<p>Ihr Benutzername lautet:" . $email . "</p>";
        $body .= "<p>Ihr Passwort lautet: \"";
        $body .= $password . "\"</p>";
        $body .= "<p>Bitte &auml;ndern Sie dieses Passwort <b>SOFORT</b> nach der ersten Anmeldung unter \"Ihr Benutzerkonto->Meine Daten aktualisieren\"</p>";
        $this->addInfo($body);
        $body .= "</body></html>";
        $this->send('Willkommen bei der ' . Yii::app()->name, $body, $email);
    }

    /**
     * Fuegt einen Infotext an
     * @param string &$body Inhalt einer E-Mail
     */
    private function addInfo(&$body) {
        $body .= "<p>Sollten Sie noch Fragen oder Anregungen haben, benutzen Sie bitte das Kontaktformular auf der Webseite.</p>";
        $body .= "<p>Das Team der Elternsprechtagsanwendung w&uuml;nscht Ihnen weiterhin ein gutes Gelingen.</p>";
        $body .= "<p>(Dies ist eine automatisch versendete E-Mail. Bitte antworten Sie nicht auf diese Nachricht, da die E-Mail-Adresse nur zum Versenden, nicht aber zum Empfang von E-Mails eingerichtet ist.)</p>";
    }

    private function send($subject, &$body, $email) {
        Yii::trace($body, 'application.components.mail');
        $this->sendMail($subject, $body, $email, Yii::app()->params['fromMailHost'], Yii::app()->params['fromMail']);
        Yii::trace('Subject:' . Yii::app()->params['fromMail'] . $subject . ' to:' . $email . ' fromMailHost:' . Yii::app()->params['fromMailHost'] . ' fromMail:' . Yii::app()->params['fromMail'], 'application.components.mail');
    }

}

?>
