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
$this->pageTitle = Yii::app()->name . ' - FAQ';
$this->breadcrumbs = array(
    'FAQ',
);
?>
<div class="row">
    <div class="twelve columns">
        <h2 class="subheader">Fragen</h2>
        <hr>
        <ul class="faq-ul">
            <li><a href="#Q1">Wie registriere ich mich?</a></li>
            <li><a href="#Q2">Was mache ich, wenn ich mein Passwort vergessen habe?</a></li>
            <li><a href="#Q3">Wie kann ich Schüler hinzufügen?</a></li>
            <li><a href="#Q4">Wie kann ich meine Benutzerdaten ändern?</a></li>
            <li><a href="#Q5">Wie kann ich einen Termin vereinbaren?</a></li>
            <?php if (Yii::app()->user->checkAccess('3') || Yii::app()->user->isGuest()) { ?>
                <li><a href="#Q6">Wie kann ich einen Termin löschen?</a></li>
            <?php } else { ?>
                <li><a href="#Q7">Wie kann ich einen Termin löschen?</a></li>
            <?php } ?>
            <li><a href="#Q8">Wie kann ich meine Termine drucken?</a></li>
            <li><a href="#Q9">Wie kann ich die Schule kontaktieren?</a></li>
        </ul>
        <h2 class="subheader">Antworten</h2>
        <hr>
        <h4 class="small subheader">Wie registriere ich mich?</h4>
        <p id="Q1">
            dadadadadada
        </p>
        <h4 class="small subheader">Was mache ich, wenn ich mein Passwort vergessen habe?</h4>
        <p id="Q2">
        </p>
        <h4 class="small subheader">Wie kann ich Schüler hinzufügen?</h4>
        <p id="Q3">
        </p>
        <h4 class="small subheader">Wie kann ich meine Benutzerdaten ändern?</h4>
        <p id="Q4">
        </p>
        <h4 class="small subheader">Wie kann ich einen Termin vereinbaren?</h4>
        <p id="Q5">
        </p>
        <?php if (Yii::app()->user->checkAccess('3') || Yii::app()->user->isGuest()) { ?>
            <h4 class="small subheader">Wie kann ich einen Termin löschen?</h4>
            <p id="Q6">
            </p>
        <?php } else { ?>
            <h4 class="small subheader">Wie kann ich einen Termin löschen?</h4>
            <p id="Q7">
            </p>
        <?php } ?>
        <h4 class="small subheader">Wie kann ich meine Termine drucken?</h4>
        <p id="Q8">
        </p>
        <h4 class="small subheader">Wie kann ich die Schule kontaktieren?</h4>
        <p id="Q9">
        </p>
        <p class="text-center">
            <?php
            echo CHtml::link('<b>Zurück zur Startseite</b>', Yii::app()->user->checkAccess('1') == TRUE ? 'index.php' :
                            'index.php?r=Appointment/index');
            ?> 
        </p>
    </div>
</div>

