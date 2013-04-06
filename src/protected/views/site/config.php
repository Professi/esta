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
Yii::app()->clientScript->registerPackage('jquery');
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
        <fieldset>
            <legend>Allgemein</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'adminEmail'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'adminEmail'); ?>
                    <?php echo $form->error($model, 'adminEmail'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'dateTimeFormat'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'dateTimeFormat'); ?>
                    <?php echo $form->error($model, 'dateTimeFormat'); ?>
                </div>
            </div>
                        <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'dateFormat'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'dateFormat'); ?>
                    <?php echo $form->error($model, 'dateFormat'); ?>
                </div>
            </div>
                        <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'timeFormat'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'timeFormat'); ?>
                    <?php echo $form->error($model, 'timeFormat'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'randomTeacherPassword'); ?></span>
                </div>
                <div class="four columns styled-select">
                    <?php echo $form->dropDownList($model, 'randomTeacherPassword', array('1' => 'Ja', '0' => 'Nein')); ?>
                    <?php echo $form->error($model, 'randomTeacherPassword'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'defaultTeacherPassword'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'defaultTeacherPassword'); ?>
                    <?php echo $form->error($model, 'defaultTeacherPassword'); ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>E-Mail</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'emailHost'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'emailHost'); ?>
                    <?php echo $form->error($model, 'emailHost'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'fromMailHost'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'fromMailHost'); ?>
                    <?php echo $form->error($model, 'fromMailHost'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'fromMail'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'fromMail'); ?>
                    <?php echo $form->error($model, 'fromMail'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'teacherMail'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'teacherMail'); ?>
                    <?php echo $form->error($model, 'teacherMail'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'schoolName'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'schoolName'); ?>
                    <?php echo $form->error($model, 'schoolName'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'virtualHost'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'virtualHost'); ?>
                    <?php echo $form->error($model, 'virtualHost'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'mailsActivated'); ?></span>
                </div>
                <div class="four columns styled-select">
                    <?php echo $form->dropDownList($model, 'mailsActivated', array('1' => 'Ja', '0' => 'Nein')); ?>
                    <?php echo $form->error($model, 'mailsActivated'); ?>
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
                    <?php echo $form->textField($model, 'maxChild'); ?>
                    <?php echo $form->error($model, 'maxChild'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'maxAppointmentsPerChild'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'maxAppointmentsPerChild'); ?>
                    <?php echo $form->error($model, 'maxAppointmentsPerChild'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'minLengthPerAppointment'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'minLengthPerAppointment'); ?>
                    <?php echo $form->error($model, 'minLengthPerAppointment'); ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Anti-Spam</legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'banUsers'); ?></span>
                </div>
                <div class="four columns styled-select">
                    <?php echo $form->dropDownList($model, 'banUsers', array('1' => 'Ja', '0' => 'Nein')); ?>
                    <?php echo $form->error($model, 'banUsers'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'durationTempBans'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'durationTempBans'); ?>
                    <?php echo $form->error($model, 'durationTempBans'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'maxAttemptsForLogin'); ?></span>
                </div>
                <div class="four columns">
                    <?php echo $form->textField($model, 'maxAttemptsForLogin'); ?>
                    <?php echo $form->error($model, 'maxAttemptsForLogin'); ?>
                </div>
            </div>
        </fieldset>
        
        <?php if (!Yii::app()->params['installed']) { ?>
        <div class="row collapse">
            <div class="eight columns">
                <span class="prefix"><?php echo $form->label($model, 'salt'); ?></span>
            </div>
            <div class="four columns">
                <?php echo $form->textField($model, 'salt'); ?>
                <?php echo $form->error($model, 'salt'); ?>
            </div>
        </div>
        <?php } ?>        
    </div><!-- row -->
    <div class="row">
        <div class="twelve columns">
            <?php echo CHtml::submitButton(Yii::t('app', 'Speichern'), array('class' => 'button')); ?>
        </div>
    </div>

    

<?php $this->endWidget(); ?>
</div><!-- form -->