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
                <span class="prefix">DatumUndZeit-ID</span>
            </div>
            <div class="ten columns">
		            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'id' => 'appointment_dateAndTime_display',
                                'name'=>'',
                                'sourceUrl'=>'index.php?r=date/search',
                                'options'=>array(
                                    'minLength'=>'1',
                                ),
                                'htmlOptions'=>array(
                                ),
                            ));
                            ?>
		<?php echo $form->error($model,'dateAndTime_id'); ?>
                <input type="hidden" id="appointment_dateAndTime_id" name="Appointment[dateAndTime_id]" value="">
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Verknüpfungs-ID</span>
            </div>
            <div class="ten columns">
		            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'name' => 'Appointment[parent_child_id]',
                'sourceUrl' => 'index.php?r=ParentChild/search',
                'options' => array(
                    'minLength' => '1',
                ),
                'htmlOptions' => array(
                ),
            ));
            ?>
		<?php echo $form->error($model,'parent_child_id'); ?>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Lehrer-ID</span>
            </div>
            <div class="ten columns">
                
		            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'name'=>'Appointment[user_id]',
                                'sourceUrl'=>'index.php?r=user/search&role=2',
                                'options'=>array(
                                    'minLength'=>'1',
                                ),
                                'htmlOptions'=>array(
                                ),
                            ));
                            ?>
		<?php echo $form->error($model,'user_id'); ?>
            </div>
	</div>
<br>

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern',  array('class' => 'small button')); ?>
	

<?php $this->endWidget(); ?>