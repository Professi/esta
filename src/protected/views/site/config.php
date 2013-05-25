<?php
/**
 * Konfigurationsseite
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
/* @var $model ConfigForm */
/* @var $form CActiveForm */
$this->setPageTitle('Konfiguration');
$this->registerAdminScripts(true);
?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'config-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="row">
        <div class="twelve columns centered">
            <h2 class="text-center">Konfiguration</h2>
        </div>
    </div>
    <div class="row">
        <div class="panel">
            <div class="row">
                <div class="two columns text-center">
                    <span aria-hidden="true" data-icon="&#xe011;" style="font-size:2.5em;"></span>
                </div>
                <div class="ten columns">
                    <?php if (!Yii::app()->user->isGuest()) { ?>
                        Bitte führen Sie auf dieser Seite keine Änderungen durch, wenn Sie sich nicht absolut sicher sind.
                        <br> Die Änderungen haben Auswirkungen auf alle Benutzer im System und können sich negativ auf die Funktionalität der Software auswirken.
                    <?php } else { ?>
                        Bitte passen Sie die nachfolgenden Felder entsprechend Ihrer Bed&uuml;fnisse an.
                    <?php } ?>
                </div>
            </div>
        </div>
        <fieldset>
            <legend>Allgemein</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix infofeld">
                        <?php echo $form->label($model, 'appName', array('class' => 'infolabel')); ?>
                    </span>
                    <div class="infotext">
                        <span aria-hidden="true" data-icon="&#xe012;"></span>
                        Hier können Sie den Anwendungsnamen festlegen. Dieser ist unter anderem für die Seitentitel in der Browserstatusleiste relevant.
                    </div>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'appName');
                    echo $form->error($model, 'appName');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix infofeld">
                        <?php echo $form->label($model, 'language', array('class' => 'infolabel')); ?>
                    </span>
                    <div class="infotext">
                        <span aria-hidden="true" data-icon="&#xe012;"></span>
                        Länderkürzel (bisher wurden noch keine Übersetzungen eingebaut)
                    </div>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'language');
                    echo $form->error($model, 'language');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'adminEmail'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'adminEmail');
                    echo $form->error($model, 'adminEmail');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'dateFormat'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'dateFormat');
                    echo $form->error($model, 'dateFormat');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'timeFormat'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'timeFormat');
                    echo $form->error($model, 'timeFormat');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'dateTimeFormat'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'dateTimeFormat', array('readonly' => 'readonly'));
                    echo $form->error($model, 'dateTimeFormat');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'randomTeacherPassword'); ?></span>
                </div>
                <div class="four columns ">
                    <?php
                    echo Select2::activeDropDownList($model, 'randomTeacherPassword', array('1' => 'Ja', '0' => 'Nein'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'randomTeacherPassword');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'defaultTeacherPassword'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'defaultTeacherPassword');
                    echo $form->error($model, 'defaultTeacherPassword');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'lockRegistration'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'lockRegistration', array('1' => 'Ja', '0' => 'Nein'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'lockRegistration');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix infofeld">
                        <?php echo $form->label($model, 'allowGroups', array('class' => 'infolabel')); ?>
                    </span>
                    <div class="infotext">
                        <span aria-hidden="true" data-icon="&#xe012;"></span>
                        Mit dieser Option können Sie Gruppen aktivieren. 
                        Für jeden Elternsprechtag und Benutzer können bestimmte Gruppen festgelegt werden.
                        Damit kann der Zugriff von Benutzern auf Elternsprechtage beschr&auml;nkt werden. Jeder TAN kann eine bestimmte Gruppe zugewiesen werden. Elternsprechtage ohne Gruppen sind frei zugänglich für registrierte Benutzer. Benutzer ohne Gruppe können an jedem Elternsprechtag Termine buchen.
                    </div>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowGroups', array('1' => 'Ja', '0' => 'Nein'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowGroups');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'logoPath'); ?></span>

                    <div class="infotext">
                        <span aria-hidden="true" data-icon="&#xe012;"></span>
                        Wenn diese Option aktiviert ist, können Eltern ihre Kinder beliebig verwalten. Falls diese Option deaktiviert wurde, müssen bei der TAN Erstellung die Namen der Kinder angegeben werden. Eltern können weitere Kinder nur durch TAN's hinzufügen.
                    </div>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'logoPath');
                    echo $form->error($model, 'logoPath');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'textHeader'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'textHeader');
                    echo $form->error($model, 'textHeader');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix infofeld"><?php echo $form->label($model, 'allowParentsToManageChilds'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowParentsToManageChilds', array('1' => 'Ja', '0' => 'Nein'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowParentsToManageChilds');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="eight columns centered panel text-center">
                    Für Datums- und Zeitformate siehe <a href="http://php.net/manual/de/function.date.php">http://php.net/manual/de/function.date.php</a>
                </div>
            </div>
        </fieldset>
                <?php if (!Yii::app()->params['installed'] && Yii::app()->user->isGuest()) { ?>
        <fieldset>
            <legend>Installierung</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'salt'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'salt');
                    echo $form->error($model, 'salt');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'hashCost'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'hashCost');
                    echo $form->error($model, 'hashCost');
                    ?>
                </div>
            </div>
        </fieldset>
        <?php } ?>  
        <fieldset>
            <legend>Datenbankinformationen</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'databaseManagementSystem'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'databaseManagementSystem', array('mysql' => 'MySQL',
                        'pgsql' => 'PostgreSQL(nicht getestet)',
                            ), array('select2Options' => array('minimumResultsForSearch' => 10))
                    );
                    echo $form->error($model, 'databaseManagementSystem');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'databaseHost'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'databaseHost');
                    echo $form->error($model, 'databaseHost');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'databasePort'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'databasePort');
                    echo $form->error($model, 'databasePort');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'databaseName'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'databaseName');
                    echo $form->error($model, 'databaseName');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'databaseUsername'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'databaseUsername');
                    echo $form->error($model, 'databaseUsername');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'databasePassword'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->passwordField($model, 'databasePassword');
                    echo $form->error($model, 'databasePassword');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Kontaktinformationen</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolName'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'schoolName');
                    echo $form->error($model, 'schoolName');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolStreet'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'schoolStreet');
                    echo $form->error($model, 'schoolStreet');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolCity'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'schoolCity');
                    echo $form->error($model, 'schoolCity');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolTele'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'schoolTele');
                    echo $form->error($model, 'schoolTele');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolFax'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'schoolFax');
                    echo $form->error($model, 'schoolFax');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolEmail'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'schoolEmail');
                    echo $form->error($model, 'schoolEmail');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'useSchoolEmailForContactForm'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'useSchoolEmailForContactForm', array('1' => 'Ja', '0' => 'Nein'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'useSchoolEmailForContactForm');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Elternsprechtage</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'maxChild'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'maxChild');
                    echo $form->error($model, 'maxChild');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'maxAppointmentsPerChild'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'maxAppointmentsPerChild');
                    echo $form->error($model, 'maxAppointmentsPerChild');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'minLengthPerAppointment'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'minLengthPerAppointment');
                    echo $form->error($model, 'minLengthPerAppointment');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>E-Mail</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'mailsActivated'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'mailsActivated', array('1' => 'Ja', '0' => 'Nein'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'mailsActivated');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'emailHost'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'emailHost', $optionsMails);
                    echo $form->error($model, 'emailHost');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'fromMailHost'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'fromMailHost', $optionsMails);
                    echo $form->error($model, 'fromMailHost');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'fromMail'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'fromMail', $optionsMails);
                    echo $form->error($model, 'fromMail');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'teacherMail'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'teacherMail', $optionsMails);
                    echo $form->error($model, 'teacherMail');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'virtualHost'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'virtualHost', $optionsMails);
                    echo $form->error($model, 'virtualHost');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Anti-Spam</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'banUsers'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'banUsers', array('1' => 'Ja', '0' => 'Nein'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'banUsers');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'durationTempBans'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'durationTempBans', $optionsBans);
                    echo $form->error($model, 'durationTempBans');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'maxAttemptsForLogin'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'maxAttemptsForLogin', $optionsBans);
                    echo $form->error($model, 'maxAttemptsForLogin');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Terminblockierung</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'allowBlockingAppointments'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowBlockingAppointments', array('1' => 'Ja', '0' => 'Nein'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowBlockingAppointments');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'allowBlockingOnlyForManagement'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowBlockingOnlyForManagement', array('1' => 'Ja', '0' => 'Nein'), array($optionsBlocks, 'select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowBlockingOnlyForManagement');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'appointmentBlocksPerDate'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'appointmentBlocksPerDate', $optionsBlocks);
                    echo $form->error($model, 'appointmentBlocksPerDate');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'lengthReasonAppointmentBlocked'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'lengthReasonAppointmentBlocked', $optionsBlocks);
                    echo $form->error($model, 'lengthReasonAppointmentBlocked');
                    ?>
                </div>
            </div>            
        </fieldset>
    </div><!-- row -->
    <div class="row">
        <div class="twelve columns">
            <?php echo CHtml::submitButton(Yii::t('App', 'Speichern'), array('class' => 'button')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->