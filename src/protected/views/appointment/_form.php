<?php
/* @var $this AppointmentController */
/* @var $model Appointment */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appointment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Zeit</span>
            </div>
            <div class="eight columns">
		<?php echo $form->textField($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
            </div>
            <div class="two columns">
                <span class="postfix">HH:MM</span>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Datum</span>
            </div>
            <div class="eight columns">
		<?php echo $form->textField($model,'date_id'); ?>
		<?php echo $form->error($model,'date_id'); ?>
            </div>
            <div class="two columns">
                <span class="postfix">YYYY:MM:DD</span>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Eltern-Kind-Verknüpfungs-ID</span>
            </div>
            <div class="ten columns">
		<?php echo $form->textField($model,'parent_child_id'); ?>
		<?php echo $form->error($model,'parent_child_id'); ?>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Lehrer-ID</span>
            </div>
            <div class="ten columns">
		<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11,)); ?>
		<?php echo $form->error($model,'user_id'); ?>
            </div>
	</div>
<br>

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern',  array('class' => 'small button')); ?>
	

<?php $this->endWidget(); ?>