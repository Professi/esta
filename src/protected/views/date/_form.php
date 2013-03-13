<?php
/* @var $this DateController */
/* @var $model Date */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'date-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Datum</span>
            </div>
            <div class="eight columns">
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
            </div>
            <div class="two columns">
                <span class="postfix">YYYY-MM-DD</span>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Anfang</span>
            </div>
            <div class="eight columns">
		<?php echo $form->textField($model,'begin'); ?>
		<?php echo $form->error($model,'begin'); ?>
            </div>
            <div class="two columns">
                <span class="postfix">HH:MM</span>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Ende</span>
            </div>
            <div class="eight columns">
		<?php echo $form->textField($model,'end'); ?>
		<?php echo $form->error($model,'end'); ?>
            </div>
            <div class="two columns">
                <span class="postfix">HH:MM</span>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Dauer eines Termins</span>
            </div>
            <div class="eight columns">
		<?php echo $form->textField($model,'durationPerAppointment'); ?>
		<?php echo $form->error($model,'durationPerAppointment'); ?>
            </div>
            <div class="two columns">
                <span class="postfix">MM</span>
            </div>
	</div>
<br>

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern', array('class' => 'small button')); ?>



<?php $this->endWidget(); ?>

