<?php
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
/* @var $model Appointment */
/* @var $form CActiveForm */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'appointment-form',
        ));
?>
<div class="row collapse">
    <div class="three columns">
        <span class="prefix"><?php echo Yii::t('app', 'Erziehungsberechtigte/r'); ?></span>
    </div>
    <div class="nine columns">
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'id' => 'appointment_parent',
            'name' => '',
            'value' => $parentLabel,
            'sourceUrl' => 'index.php?r=user/search&role=3',
            'options' => array(
                'minLength' => '1',
            ),
            'htmlOptions' => array(
                'placeholder' => Yii::t('app', 'Geben Sie einen Nachnamen ein'),
            ),
        ));
        echo $form->error($model, 'parent_child_id');
        ?>
    </div>
</div>
<div class="row collapse">
    <div class="three columns">
        <span class="prefix">Kind</span>
    </div>
    <div class="nine columns" id="appointment_parent_select">
        <?php
        echo $this->createSelectChildren($parentId, get_class($model), 'parent_child_id', $model->attributes['parent_child_id']);
        ?>
    </div>
</div>
<?php if ((Yii::app()->params['teacherAllowBlockTeacherApps'] && Yii::app()->user->isTeacher() && Yii::app()->params['allowTeachersToCreateAppointments']) || Yii::app()->user->checkAccess('1')) { ?>
    <div class="row collapse">
        <div class="three columns">
            <span class="prefix"><?php echo Yii::t('app', 'Lehrer'); ?></span>
        </div>
        <div class="nine columns">
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'id' => 'appointment_teacher',
                'name' => '',
                'value' => $teacherLabel,
                'sourceUrl' => 'index.php?r=user/search&role=2',
                'options' => array(
                    'minLength' => '1',
                ),
                'htmlOptions' => array(
                    'placeholder' => Yii::t('app', 'Geben Sie einen Nachnamen ein und wählen Sie einen Eintrag aus'),
                ),
            ));
            ?>
            <?php
            echo $form->error($model, 'user_id');
            echo $form->hiddenField($model, 'user_id', array('id' => 'appointment_teacher_id',
                'value' => $model->attributes['user_id']));
            ?>
        </div>
    </div>
<?php } ?>
<div class="row collapse">
        <div class="three columns">
        <span class="prefix"><?php echo $form->label($model, 'dateAndTime_id'); ?></span>
    </div>
    <div class="nine columns" id="appointment_dateAndTime_select">
        <?php
        echo $this->createSelectTeacherDates($model->attributes['user_id'], get_class($model), 'dateAndTime_id', $model->attributes['dateAndTime_id']);
        echo $form->error($model, 'dateAndTime_id');
        ?>
    </div>
</div>
<br>
<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Anlegen') : Yii::t('app', 'Speichern'), array('class' => 'small button')); ?>
<?php $this->endWidget(); ?>