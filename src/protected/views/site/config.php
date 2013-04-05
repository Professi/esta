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
        <?php echo $form->labelEx($model, 'adminEmail'); ?>
        <?php echo $form->textField($model, 'adminEmail'); ?>
        <?php echo $form->error($model, 'adminEmail'); ?>
        <?php echo $form->labelEx($model, 'dateTimeFormat'); ?>
        <?php echo $form->textField($model, 'dateTimeFormat'); ?>
        <?php echo $form->error($model, 'dateTimeFormat'); ?>
        <?php echo $form->labelEx($model, 'emailHost'); ?>
        <?php echo $form->textField($model, 'emailHost'); ?>
        <?php echo $form->error($model, 'emailHost'); ?>
        <?php echo $form->labelEx($model, 'fromMailHost'); ?>
        <?php echo $form->textField($model, 'fromMailHost'); ?>
        <?php echo $form->error($model, 'fromMailHost'); ?>
        <?php echo $form->labelEx($model, 'fromMail'); ?>
        <?php echo $form->textField($model, 'fromMail'); ?>
        <?php echo $form->error($model, 'fromMail'); ?>
        <?php echo $form->labelEx($model, 'teacherMail'); ?>
        <?php echo $form->textField($model, 'teacherMail'); ?>
        <?php echo $form->error($model, 'teacherMail'); ?>
        <?php echo $form->labelEx($model, 'schoolName'); ?>
        <?php echo $form->textField($model, 'schoolName'); ?>
        <?php echo $form->error($model, 'schoolName'); ?>
        <?php echo $form->labelEx($model, 'virtualHost'); ?>
        <?php echo $form->textField($model, 'virtualHost'); ?>
        <?php echo $form->error($model, 'virtualHost'); ?>
        <?php echo $form->labelEx($model, 'mailsActivated'); ?>
        <?php echo $form->textField($model, 'mailsActivated'); ?>
        <?php echo $form->error($model, 'mailsActivated'); ?>
        <?php echo $form->labelEx($model, 'maxChild'); ?>
        <?php echo $form->textField($model, 'maxChild'); ?>
        <?php echo $form->error($model, 'maxChild'); ?>
        <?php echo $form->labelEx($model, 'maxAppointmentsPerChild'); ?>
        <?php echo $form->textField($model, 'maxAppointmentsPerChild'); ?>
        <?php echo $form->error($model, 'maxAppointmentsPerChild'); ?>
        <?php echo $form->labelEx($model, 'randomTeacherPassword'); ?>
        <?php echo $form->textField($model, 'randomTeacherPassword'); ?>
        <?php echo $form->error($model, 'randomTeacherPassword'); ?>
        <?php echo $form->labelEx($model, 'defaultTeacherPassword'); ?>
        <?php echo $form->textField($model, 'defaultTeacherPassword'); ?>
        <?php echo $form->error($model, 'defaultTeacherPassword'); ?>
        <?php echo $form->labelEx($model, 'minLengthPerAppointment'); ?>
        <?php echo $form->textField($model, 'minLengthPerAppointment'); ?>
        <?php echo $form->error($model, 'minLengthPerAppointment'); ?>
        <?php echo $form->labelEx($model, 'banUsers'); ?>
        <?php echo $form->textField($model, 'banUsers'); ?>
        <?php echo $form->error($model, 'banUsers'); ?>
        <?php echo $form->labelEx($model, 'durationTempBans'); ?>
        <?php echo $form->textField($model, 'durationTempBans'); ?>
        <?php echo $form->error($model, 'durationTempBans'); ?>
        <?php echo $form->labelEx($model, 'maxAttemptsForLogin'); ?>
        <?php echo $form->textField($model, 'maxAttemptsForLogin'); ?>
        <?php echo $form->error($model, 'maxAttemptsForLogin'); ?>
        <?php if (!Yii::app()->params['installed']) { ?>
            <?php echo $form->labelEx($model, 'installed'); ?>
            <?php echo $form->textField($model, 'installed'); ?>
            <?php echo $form->error($model, 'installed'); ?>
            <?php echo $form->labelEx($model, 'salt'); ?>
            <?php echo $form->textField($model, 'salt'); ?>
            <?php echo $form->error($model, 'salt'); ?>

<?php } ?>        
    </div><!-- row -->
    <div class="row">
    </div><!-- row -->
    <div class="row buttons">
<?php echo CHtml::submitButton(Yii::t('app', 'Speichern')); ?>
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->