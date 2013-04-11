<?php
/* @var $this AppointmentController */
/* @var $model Appointment */
/* @var $form CActiveForm */
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
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appointment-form',
));
?>
<div><pre><?php         print_r($model->attributes); ?></pre></div>

        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Elternteil</span>
            </div>
            <div class="ten columns">
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
                    'placeholder' => 'Geben Sie einen Nachnamen ein',
                ),
            ));
            ?>
            </div>
	</div>


        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Kind</span>
            </div>
            <div class="ten columns styled-select" id="appointment_parent_select">
                <?php echo $this->createSelectChildren($parentId, get_class($model), 'parent_child_id', $model->attributes['parent_child_id'])  ?>
                <?php echo $form->error($model,'parent_child_id'); ?>
            </div>
        </div>
 

	

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Lehrer</span>
            </div>
            <div class="ten columns">
                
		            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'id' => 'appointment_teacher',
                                'name'=>'',
                                'value' => $teacherLabel,
                                'sourceUrl'=>'index.php?r=user/search&role=2',
                                'options'=>array(
                                    'minLength'=>'1',
                                ),
                                'htmlOptions'=>array(
                                    'placeholder' => 'Geben Sie einen Nachnamen ein und wählen Sie einen Eintrag aus',
                                ),
                            ));
                            ?>
		<?php echo $form->error($model,'user_id'); ?>
                <?php echo $form->hiddenField($model, 'user_id', array('id' => 'appointment_teacher_id', 'value' => $model->attributes['user_id'])); ?>
            </div>
	</div>
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Termin</span>
            </div>
            <div class="ten columns styled-select" id="appointment_dateAndTime_select">
                <?php echo $this->createSelectTeacherDates($model->attributes['user_id'],get_class($model),'dateAndTime_id', $model->attributes['dateAndTime_id']); ?>                
		<?php echo $form->error($model,'dateAndTime_id'); ?>
                
            </div>
	</div>
<br>

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern',  array('class' => 'small button')); ?>
	

<?php $this->endWidget(); ?>