<?php
/* @var $this ParentsPupilsController */
/* @var $model ParentsPupils */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parents-pupils-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_parents_pupils'); ?>
		<?php echo $form->textField($model,'id_parents_pupils'); ?>
		<?php echo $form->error($model,'id_parents_pupils'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_parents'); ?>
		<?php echo $form->textField($model,'id_parents'); ?>
		<?php echo $form->error($model,'id_parents'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_pupil'); ?>
		<?php echo $form->textField($model,'id_pupil'); ?>
		<?php echo $form->error($model,'id_pupil'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->