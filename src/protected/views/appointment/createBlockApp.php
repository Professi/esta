<?php
/**
 * Appointment blockieren
 */
/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/* @var $this AppointmentController */
/* @var $model BlockedAppointment */
/* @var $form CActiveForm */
?>



<?php
$this->breadcrumbs = array(
    'Appointments' => array('index'),
    'BlockApp',
);

$this->menu = array(
    array('label' => 'Termine verwalten', 'url' => array('admin')),
);
?>

<div class="row">
    <div class="twelve columns centered">
        <fieldset>
            <legend>Termin blockieren</legend>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'blockAppointment-form',
            ));
            if (!Yii::app()->user->checkAccessRole('2','-1')) {
            ?>
            <div class="row collapse">
                <div class="two columns">
                    <span class="prefix"><?php echo $form->label($model, 'user_id'); ?> </span>
                </div>
                <div class="ten columns">
                    
<?php  
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'id' => 'appointmentBlock_teacher',
    'name' => '',
    'value' => $teacherLabel,
    'sourceUrl' => 'index.php?r=user/search&role=2',
    'options' => array(
        'minLength' => '1',
    ),
    'htmlOptions' => array(
        'placeholder' => 'Geben Sie einen Nachnamen ein und wählen Sie einen Eintrag aus',
    ),
));
?>
                    <?php echo $form->hiddenField($model, 'user_id', array('id' => 'appointmentBlock_teacher_id', 'value' => $model->attributes['user_id'])); ?>
                    <?php echo $form->error($model, 'user_id'); ?>
                </div>
            </div>
            <?php } // if: User kein Lehrer ?>
            <div class="row collapse">
                <div class="two columns">
                    <span class="prefix"><?php echo $form->label($model, 'dateAndTime_id'); ?> </span>
                </div>
                <div class="ten columns styled-select" id="appointment_dateAndTime_select"> 
<?php echo $this->createSelectTeacherDates($model->attributes['user_id'],get_class($model),'dateAndTime_id', $model->attributes['dateAndTime_id']); ?>
<?php echo $form->error($model, 'dateAndTime_id'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="two columns">
                    <span class="prefix"><?php echo $form->label($model, 'reason'); ?> </span>
                </div>
                <div class="ten columns">
<?php echo $form->textField($model, 'reason'); ?>                
<?php echo $form->error($model, 'reason'); ?>
                </div>
            </div>
            <br>

<?php echo CHtml::submitButton('Anlegen', array('class' => 'small button')); ?>
<?php $this->endWidget(); ?>
        </fieldset>
    </div>
</div>
