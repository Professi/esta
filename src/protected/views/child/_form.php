<?php
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
/* @var $this ChildController */
/* @var $model Child */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'child-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Vorname</span>
            </div>
            <div class="ten columns">
                <?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firstname'); ?>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Nachname</span>
            </div>
            <div class="ten columns">
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lastname'); ?>
            </div>
	</div>
        <br>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern', array('class' => 'small button')); ?>
	

<?php $this->endWidget(); ?>