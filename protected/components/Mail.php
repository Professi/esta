<?php

/* * Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
 * Mail ist eine Klasse um Mails zu versenden die die Extension EMailer verwendet
 */
class Mail
{

    /**
     * sends a mail
     * @param string $subject Betreff einer E-Mail
     * @param string $message Nachricht einer E-Mail
     * @param string $to Empfänger der Nachricht
     * @param string $from Absender der Nachricht
     * @param string $fromName Absendername
     */
    public function sendMail($subject, $message, $to, $from, $fromName)
    {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->isSMTP();
        $mailer->SMTPAuth = Yii::app()->params['smtpAuth'];
        //$mailer->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
        $mailer->Host = Yii::app()->params['emailHost'];
        if (Yii::app()->params['smtpAuth']) {
            $mailer->Username = Yii::app()->params['fromMailHost'];
            $mailer->Password = Yii::app()->params['smtpPassword'];
        }
        if (YII_DEBUG) {
            $mailer->SMTPDebug = 2;
            $mailer->Debugoutput = 'html';
        }
        $mailer->CharSet = "UTF-8";
        $mailer->SMTPSecure = Yii::app()->params['smtpSecure'];
        $mailer->Port = Yii::app()->params['smtpPort'];
        if(strpos($from,'@') === false) {
            $from .= '@' . Yii::app()->params['fromMailHost'];
        }
        $mailer->SetFrom($from, $fromName);
        $mailer->AddAddress($to);
        $mailer->Subject = $subject;
        $mailer->MsgHTML($message);
        $mailer->AltBody = Yii::t('app', 'Benutzen Sie bitte ein HTML kompatibles E-Mail Programm!');
        try {
            $mailer->send();
        } catch (phpmailerException $e) {
            throw new CException($e->errorMessage());
        } catch (Exception $e) {
            throw new CException($e->getMessage());
        }
    }

    /**
     * sends activation link to change password
     * @param type $email E-Mail des Empfängers
     * @param type $activationKey Aktivierungsschlüssel
     */
    public function sendChangePasswordMail($email, $activationKey)
    {
        $body = $this->mailHeader();
        $body .= '<p>' . Yii::t('app', 'Bitte klicken Sie auf folgenden Link um ein neues Passwort für Ihr Benutzerkonto zu setzen.') . '</p>';
        $body .= '<p><a href="' . $this->getScriptUrl() . "?r=/user/NewPw&activationKey=$activationKey&email=$email\">" . Yii::t('app', 'Link f&uuml;r die Passwortwahl') . '</a></p>';
        $body .= '<p>' . Yii::t('app', 'Sollten Sie Probleme beim Aufrufen der Aktivierung haben kopieren Sie bitte den folgenden Link in die Adressleiste ihres Browser:') . '</p>';
        $body .= "<p>" . $this->getScriptUrl() . "?r=/user/NewPw&activationKey=$activationKey&email=$email</p><br/>";
        $body .= '<p>' . Yii::t('app', 'Falls Sie kein neues Passwort angefordert haben, ignorieren Sie bitte diese Nachricht.') . '</p>';
        $this->addInfo($body);
        $body .= $this->mailFooter();
        $this->send(Yii::t('app', 'Ihre Passwortzurücksetzung bei der {appname}', array('{appname}' => Yii::app()->name)), $body, $email);
    }

    /**
     * sends testmail
     * @param type $email E-Mail des Empfängers
     */
    public function sendTestMail($email)
    {
        $body = $this->mailHeader();
        $body = '<p><b>' . Yii::t('app', 'Dies ist eine Testmail.') . '</b></p>';
        $body .= $this->mailFooter();
        $this->send(Yii::t('app', 'Testmail bei {appname}', array('{appname}' => Yii::app()->name)), $body, $email);
    }

    private function mailHeader($title = '')
    {
        return '<html><head><title>' . $title . '</title></head><body>';
    }

    private function mailFooter()
    {
        return '</body></html>';
    }

    /**
     * sends a mail to recipient that a parent teacher day has changed.
     * @param type $email E-Mail des Empfängers
     */
    public function sendDateChangeMail($email, $oldDate, $date)
    {
        $body = $this->mailHeader();
        $body .= '<p>' . Yii::t('app', 'Hallo,') . '</p>';
        $body .= '<p>' . Yii::t('app', 'wir müssen Ihnen mitteilen, dass der Elternsprechtag vom {oldDate} auf den {date} verschoben wurde.', array(
                    '{oldDate}' => '<b>' . Yii::app()->dateFormatter->formatDateTime($oldDate, 'short', null) . '</b>',
                    '{date}' => '<b>' . Yii::app()->dateFormatter->formatDateTime($date, 'short', null) . '</b>'));
        $body .= '<p>' . Yii::t('app', 'Für mehr Informationen, sollten Sie die Schulwebseite besuchen.') . '<br/>';
        $body .= "<a href=\"" . "http://" . Yii::app()->params['schoolWebsiteLink'] . "\">" . Yii::t('app', "Webseite der Schule") . "</a></p>";
        $this->addInfo($body);
        $this->mailFooter();
        $this->send(Yii::t('app', 'Das Datum eines Elternsprechtags bei {appname} wurde geändert!', array('{appname}' => Yii::app()->name)), $body, $email);
    }

    /**
     * sends activation link
     * @param type $email E-Mail des Empfängers
     * @param type $activationKey  Aktivierungsschlüssel
     */
    public function sendActivationLinkMail($email, $activationKey)
    {
        $body = $this->mailHeader();
        $body .= "<p>" . Yii::t('app', "Vielen Dank für Ihre Registrierung bei {appname}", array('{appname}' => Yii::app()->name)) . ".</p>";
        $body .= "<p>" . Yii::t('app', "Ihr Benutzername lautet:") . " <b>" . $email . "</b></p>";
        $body .= "<p>" . Yii::t('app', "Um Ihre Registrierung abzuschließen und die Anwendung verwenden zu können, klicken Sie bitte auf den folgenden Link.") . "</p>";
        $body .= "<p><a href=\"" . $this->getScriptUrl() . "?r=/User/activate&activationKey=" . $activationKey . "\">" . Yii::t('app', "Link für die Aktivierung") . "</a></p>";
        $body .= "<p>" . Yii::t('app', "Sollten Sie Probleme beim Aufrufen der Aktivierung haben, kopieren Sie bitte den folgenden Link in die Adressleiste Ihres Browser:") . "</p>";
        $body .= "<p>" . $this->getScriptUrl() . "?r=/User/activate&activationKey=" . $activationKey . "</p>";
        $this->addInfo($body);
        $body .= $this->mailFooter();
        $this->send(Yii::t('app', "Ihre Registrierung bei {appname}", array('{appname}' => Yii::app()->name)), $body, $email);
    }

    private function getScriptUrl()
    {
        return Yii::app()->getBaseUrl(true) . '/index.php';
    }

    /**
     * Sendet eine Benachrichtungsemail dass ein Termin gelöscht wurde.
     * sends a notification mail that a appointment were deleted
     * @param type $email E-Mail Adresse des zu Informierenden
     * @param type $teacher Lehrer
     * @param type $time Uhrzeit
     * @param type $child Kind
     * @param type $date Datum
     */
    public function sendAppointmentDeleted($email, $teacher, $time, $child, $date)
    {
        $body = $this->mailHeader();
        $body .= "<body><p>" . Yii::t('app', "Hallo,") . "</p><p>" . Yii::t('app', "leider müssen wir Sie darüber informieren, dass Ihr Termin am {date} um {time} ", array('{date}' => "<b>" . Yii::app()->dateFormatter->formatDateTime($date, 'short', null), '{time}' => Yii::app()->dateFormatter->formatDateTime($time, null, 'medium'))) . "</b><br>";
        $body .= " " . Yii::t('app', "bei") . " <b>" . $teacher->title . " " . $teacher->firstname . " " . $teacher->lastname . "</b><br>";
        $body .= Yii::t('app', "mit ihrem Kind") . " <b>" . $child->firstname . " " . $child->lastname . "</b> <br/>" . Yii::t('app', "abgesagt wurde.") . "</p>";
        $this->addInfo($body);
        $body .= $this->mailFooter();
        $this->send(Yii::t('app', "Einer Ihrer Termine bei {appname} wurde gelöscht", array('{appname}' => Yii::app()->name)), $body, $email);
    }
    
        /**
     * Sendet eine Benachrichtungsemail dass ein Termin gebucht wurde.
     * sends a notification mail that a appointment was booked
     * @param type $email E-Mail Adresse des zu Informierenden
     * @param type $time Uhrzeit
     * @param type $child Kind
     * @param type $date Datum
     */
    public function sendAppointmentBooked($email, $parent, $time, $child, $date)
    {
        $body = $this->mailHeader();
        $body .= "<body><p>" . Yii::t('app', "Hallo,") . "</p><p>" . Yii::t('app', "hiermit informieren wir Sie darüber, dass ein Termin am {date} um {time} ", array('{date}' => "<b>" . Yii::app()->dateFormatter->formatDateTime($date, 'short', null), '{time}' => Yii::app()->dateFormatter->formatDateTime($time, null, 'medium'))) . "</b><br>";
        $body .= " " . Yii::t('app', "bei Ihnen von ") . " <b>" . $parent->title . " " . $parent->firstname . " " . $parent->lastname . "</b><br>";
        $body .= Yii::t('app', "mit dem Kind") . " <b>" . $child->firstname . " " . $child->lastname . "</b> <br/>" . Yii::t('app', "bei Ihnen gebucht wurde.") . "</p>";
        $this->addInfo($body);
        $body .= $this->mailFooter();
        $this->send(Yii::t('app', "Termin bei {appname} wurde gebucht", array('{appname}' => Yii::app()->name)), $body, $email);
    }
    
    
    

    /**
     * sends random user password
     * @param string $email
     * @param string $password
     * @param boolean $isTeacher
     */
    public function sendRandomUserPassword($email, $password, $isTeacher = true)
    {
        $body = $this->mailHeader();
        if ($isTeacher) {
            $body .= "<body><p>" . Yii::t('app', "Sie wurden bei {appname} als Lehrer registriert.", array('{appname}' => Yii::app()->name)) . "</p>";
        } else {
            $body .= "<body><p>" . Yii::t('app', "Sie wurden bei {appname} registriert.", array('{appname}' => Yii::app()->name)) . "</p>";
        }
        $body .= "<p>" . Yii::t('app', "Ihr Benutzername lautet:") . " <b>" . $email . "</b></p>";
        $body .= "<p>" . Yii::t('app', "Ihr Passwort lautet:") . " <b>";
        $body .= $password . "</b></p>";
        $body .= "<p>" . Yii::t('app', "Bitte ändern Sie dieses Passwort <b>direkt</b> nach der ersten Anmeldung unter \"Ihr Benutzerkonto->Meine Daten aktualisieren\"") . "</p>";
        $this->addInfo($body);
        $body .= $this->mailFooter();
        $this->send(Yii::t('app', 'Willkommen bei {appname}', array('{appname}' => Yii::app()->name)), $body, $email);
    }

    /**
     * inserts infotext to $body
     * @param string &$body Inhalt einer E-Mail
     */
    private function addInfo(&$body)
    {
        $body .= "<p>" . Yii::t('app', "Sollten Sie noch Fragen oder Anregungen haben, benutzen Sie bitte das Kontaktformular auf der Webseite.") . "</p><br/>";
        $body .= "<p>" . Yii::t('app', "Das Team der Elternsprechtagsanwendung wünscht Ihnen weiterhin ein gutes Gelingen.") . "</p>";
        $body .= "<p>" . Yii::t('app', "(Dies ist eine automatisch versendete E-Mail. Bitte antworten Sie nicht auf diese Nachricht, da die E-Mail-Adresse nur zum Versenden, nicht aber zum Empfang von E-Mails eingerichtet ist.)") . "</p>";
    }

    /**
     * sends mail
     * @param string $subject
     * @param string $body
     * @param string $email
     */
    private function send($subject, &$body, $email)
    {
        $this->sendMail($subject, $body, $email, Yii::app()->params['fromMailHost'], Yii::app()->params['fromMail']);
    }
}
