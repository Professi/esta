<?php
/**
 * FAQ
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
/* @var $this SiteController */
/* @var $error array */
$this->setPageTitle(Yii::t('app', 'FAQ'));
$this->breadcrumbs = array(
    'FAQ',
);
?>
<div class="row">
    <div class="small-12 columns">
        <h2 class="subheader"><?php echo Yii::t('app', 'Fragen'); ?></h2>
        <hr>
        <ul class="faq-ul">
            <li><a href="#Q1"><?php echo Yii::t('app', 'Wie registriere ich mich?'); ?></a></li>
            <li><a href="#Q2"><?php echo Yii::t('app', 'Was mache ich, wenn ich mein Passwort vergessen habe?'); ?></a></li>
            <li><a href="#Q3"><?php echo Yii::t('app', 'Wie kann ich Schüler hinzufügen?'); ?></a></li>
            <li><a href="#Q4"><?php echo Yii::t('app', 'Wie kann ich meine Benutzerdaten ändern?'); ?></a></li>
            <li><a href="#Q5"><?php echo Yii::t('app', 'Wie kann ich einen Termin vereinbaren?'); ?></a></li>
            <?php if (Yii::app()->user->checkAccess('3') || Yii::app()->user->isGuest()) { ?>
                <li><a href="#Q6"><?php echo Yii::t('app', 'Wie kann ich einen Termin löschen?'); ?></a></li>
            <?php } else { ?>
                <li><a href="#Q7"><?php echo Yii::t('app', 'Wie kann ich einen Termin löschen?'); ?></a></li>
            <?php } ?>
            <li><a href="#Q8"><?php echo Yii::t('app', 'Wie kann ich meine Termine drucken?'); ?></a></li>
            <li><a href="#Q9"><?php echo Yii::t('app', 'Wie kann ich die Schule kontaktieren?'); ?></a></li>
        </ul>
        <h2 class="subheader"><?php echo Yii::t('app', 'Antworten'); ?></h2>
        <hr>
        <div class="push-faq" id="Q1"></div>
        <h4 class="small subheader"><?php echo Yii::t('app', 'Wie registriere ich mich?'); ?></h4>
        <p>
            <?php echo Yii::t('app', 'Sie können sich registrieren, indem Sie auf der Hauptseite den Schriftzug „Benötigen Sie einen Zugang? Klicken Sie hier.“ anklicken. Auf dieser Seite müssen Sie alle Felder ausfüllen. Bei der Angabe der E-Mail-Adresse ist es wichtig, eine gültige Adresse einzutragen, da über diese ein Aktivierungslink verschickt wird. Das Passwort muss dabei mindestens acht Zeichen umfassen und einmal wiederholt werden. Vom Klassenlehrer Ihres Kindes erhalten Sie eine TAN (Kennziffer), die aus sechs Zahlen besteht.'); ?>
            <?php echo Yii::t('app', 'Nachdem Sie alle Felder ausgefüllt haben, müssen Sie auf den Button mit der Aufschrift „Registrieren“ klicken. Danach erhalten Sie eine E-Mail, die einen Registrierungslink beinhaltet. Wenn diese E-Mail eingetroffen ist, müssen Sie den mitgeschickten Link anklicken, um den Account zu aktivieren. Anschließend können Sie sich mit Ihrer E-Mailadresse und dem von Ihnen festgelegten Passwort auf der Hauptseite einloggen.'); ?>
        </p>
        <div class="push-faq" id="Q2"></div>
        <h4 class="small subheader"><?php echo Yii::t('app', 'Was mache ich, wenn ich mein Passwort vergessen habe?'); ?></h4>
        <p>
            <?php echo Yii::t('app', 'Wenn Sie Ihr Passwort vergessen haben, müssen Sie auf der Startseite den Schriftzug „Passwort vergessen?“ anklicken. Daraufhin erscheint eine Seite, bei der Sie Ihre E-Mail-Adresse und den angezeigten Sicherheitscode eingeben müssen. Wenn beide Felder ausgefüllt wurden, müssen Sie auf „Absenden“ klicken. Danach erhalten Sie erneut eine E-Mail, die einen Link enthält, den Sie anklicken müssen. Anschließend werden Sie auf eine Seite weitergeleitet, auf der Sie ein neues Passwort festgelegen können. Danach können Sie sich wieder auf der Hauptseite mit Ihrer E-Mailadresse und dem neuen Passwort einloggen.'); ?>
        </p>
        <div class="push-faq" id="Q3"></div>
        <h4 class="small subheader"><?php echo Yii::t('app', 'Wie kann ich Schüler hinzufügen?'); ?></h4>
        <p>
            <?php echo Yii::t('app', 'Klicken Sie den Menübutton „Ihre Kinder“, danach auf den Button „Kind hinzufügen“. Anschließend müssen Sie den Vor- und Nachnamen Ihres Kindes eingeben und auf „Anlegen“ klicken.'); ?>
        </p>
        <div class="push-faq" id="Q4"></div>
        <h4 class="small subheader"><?php echo Yii::t('app', 'Wie kann ich meine Benutzerdaten ändern?'); ?></h4>
        <p>
            <?php echo Yii::t('app', 'Um Ihre Benutzerdaten zu ändern, klicken Sie zunächst im Menü auf „Ihr Account“ und danach auf den Button „Benutzer bearbeiten“. Anschließend können Sie Ihre Benutzerdaten ändern. Um die Änderungen zu speichern, müssen Sie auf den Button „Speichern“ klicken.'); ?>
        </p>
        <div class="push-faq" id="Q5"></div>
        <h4 class="small subheader"><?php echo Yii::t('app', 'Wie kann ich einen Termin vereinbaren?'); ?></h4>
        <p>
            <?php echo Yii::t('app', 'Um einen Termin auszumachen, müssen Sie auf den Menübutton „Termin festlegen“ klicken. Um sich Lehrer mit einem bestimmten Anfangsbuchstaben anzeigen zu lassen, klicken Sie dann auf diesen Buchstaben. Danach können Sie den Lehrer in der erscheinenden Liste direkt auswählen, indem Sie auf das kleine Weckersymbol klicken. Alternativ können Sie in dem Textfeld die Anfangsbuchstaben des gewünschten Lehrers eingeben und diesen im sich öffnendem Menü anklicken. Wenn Sie einen Lehrer ausgewählt haben, erscheint dessen Zeitplan. In diesem sind die Termine entweder als „VERFÜGBAR“ oder „BELEGT“ gekennzeichnet. Durch das Klicken auf einen Termin, der als „VERFÜGBAR“ gekennzeichnet ist, werden für Sie automatisch das Datum und die Uhrzeit des angeklickten Termins in die untenstehenden Felder eingetragen. Falls mehr als ein Kind die Schule besucht, müssen Sie den Namen des jeweiligen Kindes auswählen. Zum Schluss müssen Sie auf den Button „Bestätigen“ klicken, um den Termin zu reservieren.'); ?>
        </p>
        <?php if (Yii::app()->user->checkAccess('3') || Yii::app()->user->isGuest()) { ?>
            <div class="push-faq" id="Q6"></div>
            <h4 class="small subheader"><?php echo Yii::t('app', 'Wie kann ich einen Termin löschen?'); ?></h4>
            <p>
                <?php echo Yii::t('app', 'Sie können Termine löschen, indem Sie im Menü auf den Button „Ihre Termine“ klicken. Außerdem ist die Seite „Ihre Termine“ auch nach dem Login direkt geöffnet. Ein Termin kann gelöscht werden, indem Sie auf den Button „Termin löschen“ klicken.'); ?>
            </p>
        <?php } else { ?>
            <div class="push-faq" id="Q7"></div>
            <h4 class="small subheader"><?php echo Yii::t('app', 'Wie kann ich einen Termin löschen?'); ?></h4>
            <p>
                <?php echo Yii::t('app', 'Sie können Termine löschen, indem Sie im Menü auf den Button „Ihre Termine“ klicken. Außerdem ist die Seite „Ihre Termine“ auch nach dem Login direkt geöffnet. Ein Termin kann gelöscht werden, indem Sie auf das kleine Mülleimersymbol klicken und die Sicherheitsfrage mit „OK“ bestätigen.'); ?>
            </p>
        <?php } ?>
        <div class="push-faq" id="Q8"></div>
        <h4 class="small subheader"><?php echo Yii::t('app', 'Wie kann ich meine Termine drucken?'); ?></h4>
        <p>
            <?php echo Yii::t('app', 'Zum Drucken müssen Sie im Menü auf „Ihre Termine“ klicken, um die entsprechende Seite aufzurufen. Außerdem wird die Seite direkt nach dem Login angezeigt. Wenn Sie auf den Button mit der Aufschrift „Drucken“ klicken, erscheint ein weiteres Fenster, bei dem Sie Drucker auszuwählen müssen. Danach müssen Sie in dem neuen Fenster auf den Button „Drucken“ klicken, um die Terminliste auszudrucken.'); ?>
        </p>
        <div class="push-faq" id="Q9"></div>
        <h4 class="small subheader"><?php echo Yii::t('app', 'Wie kann ich die Schule kontaktieren?'); ?></h4>
        <p>
            <?php echo Yii::t('app', 'Falls Fragen zu der Elternsprechtags-Software bestehen sollten, können Sie auf der Startseite den Link „Kontakt“ anklicken. Danach erscheint eine Seite, bei der Sie die Ihren Namen, Ihre E-Mailadresse und einen Betreff eingeben müssen. Außerdem muss eine Nachricht geschrieben werden, in der Sie Ihr Anliegen darlegen können. Wenn Sie alle Felder ausgefüllt haben, müssen Sie abschließend den Sicherheitscode eingeben und auf „Absenden“ klicken.'); ?>
        </p>
        <p class="text-center">
            <?php
            echo CHtml::link('<b>' . Yii::t('app', 'Zurück zur Startseite') . '</b>', Yii::app()->user->checkAccess('1') == TRUE ? 'index.php' :
                            'index.php?r=Appointment/index');
            ?> 
        </p>
    </div>
</div>

