<?php
/* @var $this AppointmentController */
/* @var $model Appointment */
/* @var $form CActiveForm */
/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appointment-form',
)); ?>
	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Termin</span>
            </div>
            <div class="ten columns">
		            <?php
                            if ($model->isNewRecord) {
                                $dateAndTime_value = '';
                                $parentChild_value = '';
                                $user_value = '';
                                $dateAndTime_label = '';
                                $parentChild_label = '';
                                $user_label = '';
                            } else {
                                $dateAndTime_value = $model->dateAndTime->id;
                                $parentChild_value = $model->parentChild->id;
                                $user_value = $model->user->id; //
                                $dateAndTime_label = date('d.m.Y',  strtotime($model->dateAndTime->date->date))." ".date('H:i', strtotime($model->dateAndTime->time)); 
                                $parentChild_label = $model->parentChild->user->firstname." ".$model->parentChild->user->lastname.";Kind: ".$model->parentChild->child->firstname." ".$model->parentChild->child->lastname;
                                $user_label = $model->user->title." ".$model->user->firstname." ".$model->user->lastname;
                            }
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'id' => 'appointment_dateAndTime_display',
                                'name'=>'',
                                'value' => $dateAndTime_label,
                                'sourceUrl'=>'index.php?r=date/search',
                                'options'=>array(
                                    'minLength'=>'1',
                                ),
                                'htmlOptions'=>array(
                                    'placeholder' => 'Geben Sie eine Stunde ein und wählen Sie einen Eintrag aus',
                                ),
                            ));
                            ?>
		<?php echo $form->error($model,'dateAndTime_id'); ?>
                <input type="hidden" id="appointment_dateAndTime_id" name="Appointment[dateAndTime_id]" value="<?php echo $dateAndTime_value ?>">
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Elternteil</span>
            </div>
            <div class="ten columns">
		            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'id' => 'appointment_parent_child_display',
                'name' => '',
                'value' => $parentChild_label,
                'sourceUrl' => 'index.php?r=ParentChild/search',
                'options' => array(
                    'minLength' => '1',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Geben Sie einen Nachnamen ein und wählen Sie einen Eintrag aus',
                ),
            ));
            ?>
		<?php echo $form->error($model,'parent_child_id'); ?>
                <input type="hidden" id="appointment_parent_child_id" name="Appointment[parent_child_id]" value="<?php echo $parentChild_value ?>">
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Lehrer</span>
            </div>
            <div class="ten columns">
                
		            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'id' => 'appointment_parent_user_display',
                                'name'=>'',
                                'value' => $user_label,
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
                <input type="hidden" id="appointment_parent_user_id" name="Appointment[user_id]" value="<?php echo $user_value ?>">
            </div>
	</div>
<br>

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern',  array('class' => 'small button')); ?>
	

<?php $this->endWidget(); ?>