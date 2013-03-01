<?php
/* @var $this ParentsController */
/* @var $model Parents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parents-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'parent1'); ?>
		<?php echo $form->textField($model,'parent1'); ?>
		<?php echo $form->error($model,'parent1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent2'); ?>
		<?php echo $form->textField($model,'parent2'); ?>
		<?php echo $form->error($model,'parent2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pw'); ?>
		<?php echo $form->textField($model,'pw'); ?>
		<?php echo $form->error($model,'pw'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->