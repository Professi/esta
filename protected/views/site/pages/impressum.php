<?php
/**
 * Impressumsseite
 */
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
/* @var $this SiteController */
$this->setPageTitle(Yii::t('app', 'Impressum'));
$this->breadcrumbs = array(
    'Impressum',
);
?>
<div class="row">
    <div class="small-12 columns">
        <h2 class='subheader'><?php echo Yii::t('app', 'Impressum'); ?></h2>
        <hr>
        <p> <?php echo Yii::app()->params['schoolName']; ?><br>
            <?php echo Yii::app()->params['schoolStreet']; ?><br>
            <?php echo Yii::app()->params['schoolCity']; ?><br>
            <?php echo (Yii::t('app', 'Telefon') . ': ' . Yii::app()->params['schoolTele']); ?><br>
            <?php echo (Yii::t('app', 'Telefax') . ': ' . Yii::app()->params['schoolFax']); ?><br>
            <?php if (Yii::app()->params['useSchoolEmailForContactForm']) { ?>
                <?php echo Yii::t('app', 'E-Mail') . ':'; ?> <a href="mailto:<?php echo Yii::app()->params['schoolEmail']; ?>"><?php echo Yii::app()->params['schoolEmail']; ?></a>
            <?php } ?>
        </p>
        <p><?php echo Yii::t('app', 'Elternsprechtagsanwendung(ESTA) wurde im Rahmen eines Berufsschulprojektes für die Brühlwiesenschule Hofheim entwickelt und unter der GNU General Public License Version 3 (&nbsp;&nbsp;<a href="http://www.gnu.de/documents/gpl-3.0.en.html" ><i class="fi-page-export"></i>&nbsp;Link</a> ) lizensiert.'); ?>
            <br><?php echo Yii::t('app', 'Die Urheber sind:'); ?> <a href="mailto:c.ehringfeld{at}t-online.de">Christian Ehringfeld</a>, <a href="mailto:dumock{at}gmail.com">David Mock</a> <?php echo Yii::t('app', 'und')?> Matthias Unterbusch. </p>
        <p><?php echo Yii::t('app', 'Website'); ?>&nbsp;&nbsp;<a href="http://www.elternsprechtagsanwendung.de/"><i class="fi-page-export"></i>&nbsp;Link</a></p>
        <p><?php echo Yii::t('app', 'Diese Seite wurde mit Hilfe der folgenden Ressourcen entwickelt und erstellt:'); ?><br>
            PHP&nbsp;&nbsp;<a href="http://www.php.net"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            Yii Framework&nbsp;&nbsp;<a href="http://www.yiiframework.com" ><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            EMailer&nbsp;&nbsp;<a href="http://www.yiiframework.com/extension/mailer/"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            PHPMailer&nbsp;&nbsp;<a href="https://github.com/Synchro/PHPMailer"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            ZURB Foundation Framework&nbsp;&nbsp;<a href="http://foundation.zurb.com"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            IcoMoon Icon Fonts&nbsp;&nbsp;<a href="http://icomoon.io"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            Google Web Fonts&nbsp;&nbsp;<a href="http://www.google.com/webfonts"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            Subtle Patterns&nbsp;&nbsp;<a href="http://www.subtlepatterns.com"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            Yii-Select2&nbsp;&nbsp;<a href="   https://github.com/tonybolzan/yii-select2"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            Select2&nbsp;&nbsp;<a href="https://github.com/ivaynberg/select2"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
        </p>
        <?php if (Yii::app()->params['language'] == 'de') { ?>
            <p>
            <h3>Haftungsausschluss:</h3>
            Die <?php echo Yii::app()->params['schoolName']; ?> und die Entwickler dieser Anwendung, werden nachfolgend als "Der Autor" bezeichnet. <br>
            </p>
            <p>
                <b>1. Inhalt des Onlineangebotes</b> <br>
                Der Autor übernimmt keinerlei Gewähr für die Aktualität, Korrektheit, Vollständigkeit oder Qualität der bereitgestellten Informationen. Haftungsansprüche gegen den Autor, welche sich auf Schäden materieller oder ideeller Art beziehen, die durch die Nutzung oder Nichtnutzung der dargebotenen Informationen bzw. durch die Nutzung fehlerhafter und unvollständiger Informationen verursacht wurden, sind grundsätzlich ausgeschlossen, sofern seitens des Autors kein nachweislich vorsätzliches oder grob fahrlässiges Verschulden vorliegt. 
                Alle Angebote sind freibleibend und unverbindlich. Der Autor behält es sich ausdrücklich vor, Teile der Seiten oder das gesamte Angebot ohne gesonderte Ankündigung zu verändern, zu ergänzen, zu löschen oder die Veröffentlichung zeitweise oder endgültig einzustellen.
            </p>
            <p>
                <b>2. Verweise und Links</b> <br>
                Bei direkten oder indirekten Verweisen auf fremde Webseiten ("Hyperlinks"), die außerhalb des Verantwortungsbereiches des Autors liegen, würde eine Haftungsverpflichtung ausschließlich in dem Fall in Kraft treten, in dem der Autor von den Inhalten Kenntnis hat und es ihm technisch möglich und zumutbar wäre, die Nutzung im Falle rechtswidriger Inhalte zu verhindern. 
                Der Autor erklärt hiermit ausdrücklich, dass zum Zeitpunkt der Linksetzung keine illegalen Inhalte auf den zu verlinkenden Seiten erkennbar waren. Auf die aktuelle und zukünftige Gestaltung, die Inhalte oder die Urheberschaft der verlinkten/verknüpften Seiten hat der Autor keinerlei Einfluss. Deshalb distanziert er sich hiermit ausdrücklich von allen Inhalten aller verlinkten /verknüpften Seiten, die nach der Linksetzung verändert wurden. Diese Feststellung gilt für alle innerhalb des eigenen Internetangebotes gesetzten Links und Verweise sowie für Fremdeinträge in vom Autor eingerichteten Gästebüchern, Diskussionsforen, Linkverzeichnissen, Mailinglisten und in allen anderen Formen von Datenbanken, auf deren Inhalt externe Schreibzugriffe möglich sind. Für illegale, fehlerhafte oder unvollständige Inhalte und insbesondere für Schäden, die aus der Nutzung oder Nichtnutzung solcherart dargebotener Informationen entstehen, haftet allein der Anbieter der Seite, auf welche verwiesen wurde, nicht derjenige, der über Links auf die jeweilige Veröffentlichung lediglich verweist.
            </p>
            <p>
                <b>3. Urheber- und Kennzeichenrecht</b> <br>
                Der Autor ist bestrebt, in allen Publikationen die Urheberrechte der verwendeten Bilder, Grafiken, Tondokumente, Videosequenzen und Texte zu beachten, von ihm selbst erstellte Bilder, Grafiken, Tondokumente, Videosequenzen und Texte zu nutzen oder auf lizenzfreie Grafiken, Tondokumente, Videosequenzen und Texte zurückzugreifen. 
                Alle innerhalb des Internetangebotes genannten und ggf. durch Dritte geschützten Marken- und Warenzeichen unterliegen uneingeschränkt den Bestimmungen des jeweils gültigen Kennzeichenrechts und den Besitzrechten der jeweiligen eingetragenen Eigentümer. Allein aufgrund der bloßen Nennung ist nicht der Schluss zu ziehen, dass Markenzeichen nicht durch Rechte Dritter geschützt sind! 
                Das Copyright für veröffentlichte, vom Autor selbst erstellte Objekte bleibt allein beim Autor der Seiten. Eine Vervielfältigung oder Verwendung solcher Grafiken, Tondokumente, Videosequenzen und Texte in anderen elektronischen oder gedruckten Publikationen ist ohne ausdrückliche Zustimmung des Autors nicht gestattet.
            </p>
            <p>
                <b>4. Datenschutz</b> <br>
                Sofern innerhalb des Internetangebotes die Möglichkeit zur Eingabe persönlicher oder geschäftlicher Daten (Emailadressen, Namen, Anschriften) besteht, so erfolgt die Preisgabe dieser Daten seitens des Nutzers auf ausdrücklich freiwilliger Basis. Die Inanspruchnahme und Bezahlung aller angebotenen Dienste ist - soweit technisch möglich und zumutbar - auch ohne Angabe solcher Daten bzw. unter Angabe anonymisierter Daten oder eines Pseudonyms gestattet. Die Nutzung der im Rahmen des Impressums oder vergleichbarer Angaben veröffentlichten Kontaktdaten wie Postanschriften, Telefon- und Faxnummern sowie Emailadressen durch Dritte zur Übersendung von nicht ausdrücklich angeforderten Informationen ist nicht gestattet. Rechtliche Schritte gegen die Versender von sogenannten Spam-Mails bei Verstössen gegen dieses Verbot sind ausdrücklich vorbehalten.
            </p>
            <p>
                <b>5. Rechtswirksamkeit dieses Haftungsausschlusses</b> <br>
                Dieser Haftungsausschluss ist als Teil des Internetangebotes zu betrachten, von dem aus auf diese Seite verwiesen wurde. Sofern Teile oder einzelne Formulierungen dieses Textes der geltenden Rechtslage nicht, nicht mehr oder nicht vollständig entsprechen sollten, bleiben die übrigen Teile des Dokumentes in ihrem Inhalt und ihrer Gültigkeit davon unberührt. 
            </p>
        <?php } ?>
        <p class="text-center"><?php echo CHtml::link('<b>' . Yii::t('app', 'Zurück zur Startseite') . '</b>', 'index.php'); ?> </p>
    </div>
</div>
