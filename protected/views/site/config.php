<?php
/**
 * Konfigurationsseite
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
/**
 * @var $this SiteController 
 * @var $model ConfigForm 
 * @var $form CActiveForm 
 */
$this->setPageTitle(Yii::t('app', 'Konfiguration'));
?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'config-form',
        'enableAjaxValidation' => false,
        'errorMessageCssClass' => 'error',
        'skin' => false,
    ));
    ?>
    <div class="row">
        <div class="small-12 columns small-centered">
            <h2 class="text-center"><?php echo Yii::t('app', 'Konfiguration'); ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="panel">
            <div class="row">
                <div class="small-2 columns text-center">
                    <i class="fi-alert callout-icon"></i>
                </div>
                <div class="small-10 columns">
                    <?php
                    echo Yii::t('app', 'Bitte führen Sie auf dieser Seite nur Änderungen durch, wenn Sie sich absolut sicher sind.') . '<br>';
                    echo Yii::t('app', 'Die Änderungen haben Auswirkungen auf alle Benutzer im System und können sich negativ auf die Funktionalität der Software auswirken.');
                    ?>
                </div>
            </div>
        </div>
        <?php if ($model->hasErrors()) { ?>
            <div class="panel alert-box alert">
                <div class="row">
                    <div class="small-10 columns">
                        <?php
                        echo CHtml::errorSummary($model);
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Allgemein'); ?></legend>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix infofeld">
                        <?php echo $form->label($model, 'appName', array('class' => 'infolabel')); ?>
                    </span>
                    <div class="infotext">
                        <i class="fi-info"></i>
                        <?php echo Yii::t('app', 'Hier können Sie den Anwendungsnamen festlegen. Dieser ist unter anderem für die Seitentitel in der Browserstatusleiste relevant.'); ?>
                    </div>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'appName');
                    echo $form->error($model, 'appName');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix infofeld">
                        <?php echo $form->label($model, 'language', array('class' => 'infolabel')); ?>
                    </span>
                    <div class="infotext">
                        <i class="fi-info"></i>
                        <?php echo Yii::t('app', 'Länderkürzel z.B. de oder en'); ?>
                    </div>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'language');
                    echo $form->error($model, 'language');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'adminEmail'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'adminEmail');
                    echo $form->error($model, 'adminEmail');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'randomTeacherPassword'); ?></span>
                </div>
                <div class="small-4 columns ">
                    <?php
                    echo Select2::activeDropDownList($model, 'randomTeacherPassword', Controller::getYesOrNo(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'randomTeacherPassword');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'defaultTeacherPassword'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'defaultTeacherPassword');
                    echo $form->error($model, 'defaultTeacherPassword');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'lockRegistration'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'lockRegistration', Controller::getYesOrNo(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'lockRegistration');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix infofeld">
                        <?php echo $form->label($model, 'allowGroups', array('class' => 'infolabel')); ?>
                    </span>
                    <div class="infotext">
                        <i class="fi-info"></i>
                        <?php
                        echo Yii::t('app', 'Mit dieser Option können Sie Gruppen aktivieren.');
                        echo Yii::t('app', 'Für jeden Elternsprechtag und Benutzer können bestimmte Gruppen festgelegt werden.');
                        echo Yii::t('app', 'Damit kann der Zugriff von Benutzern auf Elternsprechtage beschränkt werden. Jeder TAN kann eine bestimmte Gruppe zugewiesen werden. Elternsprechtage ohne Gruppen sind frei zugänglich für registrierte Benutzer. Benutzer ohne Gruppe können an jedem Elternsprechtag Termine buchen.');
                        ?>
                    </div>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowGroups', Controller::getYesOrNo(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowGroups');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'logoPath'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'logoPath');
                    echo $form->error($model, 'logoPath');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'hashCost'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'hashCost');
                    echo $form->error($model, 'hashCost');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Kontaktinformationen'); ?></legend>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolName'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'schoolName');
                    echo $form->error($model, 'schoolName');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolStreet'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'schoolStreet');
                    echo $form->error($model, 'schoolStreet');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolCity'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'schoolCity');
                    echo $form->error($model, 'schoolCity');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolTele'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'schoolTele');
                    echo $form->error($model, 'schoolTele');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolFax'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'schoolFax');
                    echo $form->error($model, 'schoolFax');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolEmail'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'schoolEmail');
                    echo $form->error($model, 'schoolEmail');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'useSchoolEmailForContactForm'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'useSchoolEmailForContactForm', Controller::getYesOrNo(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'useSchoolEmailForContactForm');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolWebsiteLink'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'schoolWebsiteLink');
                    echo $form->error($model, 'schoolWebsiteLink');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Elternsprechtage'); ?></legend>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix infofeld"><?php echo $form->label($model, 'allowParentsToManageChilds', array('class' => 'infolabel')); ?></span>
                    <div class="infotext">
                        <i class="fi-info"></i>
                        <?php echo Yii::t('app', 'Wenn diese Option aktiviert ist, können Eltern ihre Kinder beliebig verwalten. Falls diese Option deaktiviert wurde, müssen bei der TAN Erstellung die Namen der Kinder angegeben werden. Eltern können weitere Kinder nur durch TAN\'s hinzufügen.'); ?>
                    </div>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowParentsToManageChilds', Controller::getYesOrNo(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowParentsToManageChilds');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix infofeld"><?php echo $form->label($model, 'maxChild', array('class' => 'infolabel')); ?></span>
                    <div class="infotext">
                        <i class="fi-info"></i>
                        <?php echo Yii::t('app', 'Wenn Eltern ihre Kinder selber verwalten dürfen, dürfen diese nur n Kinder hinzufügen.'); ?>
                    </div>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'maxChild');
                    echo $form->error($model, 'maxChild');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'maxAppointmentsPerChild'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'maxAppointmentsPerChild');
                    echo $form->error($model, 'maxAppointmentsPerChild');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'minLengthPerAppointment'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'minLengthPerAppointment');
                    echo $form->error($model, 'minLengthPerAppointment');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo Yii::t('app', 'E-Mail'); ?></legend>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'smtpAuth'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'smtpAuth', Controller::getYesOrNo());
                    echo $form->error($model, 'smtpAuth');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix infofeld">
                        <?php echo $form->label($model, 'emailHost', array('class' => 'infolabel')); ?>
                    </span>
                    <div class="infotext">
                        <span aria-hidden="true" data-icon="&#xe012;"></span>
                        <?php echo Yii::t('app', 'Sofern der Mailserver auf dem selben Host wie die Anwendung läuft, sollte in diesem Feld localhost eingetragen werden.'); ?>
                    </div>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'emailHost');
                    echo $form->error($model, 'emailHost');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'fromMail'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'fromMail');
                    echo $form->error($model, 'fromMail');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'fromMailHost'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'fromMailHost');
                    echo $form->error($model, 'fromMailHost');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'smtpPassword'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->passwordField($model, 'smtpPassword');
                    echo $form->error($model, 'smtpPassword');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'smtpSecure'); ?></span>
                </div>
                <div class="small-4 columns ">
                    <?php
                    echo Select2::activeDropDownList($model, 'smtpSecure', $model->mailConfigs(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'smtpSecure');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'smtpPort'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'smtpPort');
                    echo $form->error($model, 'smtpPort');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Anti-Spam'); ?></legend>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'banUsers'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'banUsers', Controller::getYesOrNo(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'banUsers');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'durationTempBans'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'durationTempBans', $optionsBans);
                    echo $form->error($model, 'durationTempBans');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'maxAttemptsForLogin'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'maxAttemptsForLogin', $optionsBans);
                    echo $form->error($model, 'maxAttemptsForLogin');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'maxTanGen'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'maxTanGen', $optionsBans);
                    echo $form->error($model, 'maxTanGen');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'tanSize'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'tanSize', $optionsBans);
                    echo $form->error($model, 'tanSize');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Terminblockierung'); ?></legend>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'allowBlockingAppointments'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowBlockingAppointments', Controller::getYesOrNo(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowBlockingAppointments');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'allowTeachersToCreateAppointments'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowTeachersToCreateAppointments', Controller::getYesOrNo(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowTeachersToCreateAppointments');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'allowBlockingOnlyForManagement'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'allowBlockingOnlyForManagement', Controller::getYesOrNo(), array($optionsBlocks, 'select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'allowBlockingOnlyForManagement');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'teacherAllowBlockTeacherApps'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'teacherAllowBlockTeacherApps', Controller::getYesOrNo(), array($optionsBlocks, 'select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'teacherAllowBlockTeacherApps');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'appointmentBlocksPerDate'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'appointmentBlocksPerDate', $optionsBlocks);
                    echo $form->error($model, 'appointmentBlocksPerDate');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'lengthReasonAppointmentBlocked'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'lengthReasonAppointmentBlocked', $optionsBlocks);
                    echo $form->error($model, 'lengthReasonAppointmentBlocked');
                    ?>
                </div>
            </div>            
        </fieldset>
    </div><!-- row -->
    <div class="row">
        <div class="small-12 columns">
            <?php echo CHtml::submitButton(Yii::t('app', 'Speichern'), array('class' => 'button')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
