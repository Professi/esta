<?php
/* @var $this ParentsPupilsController */
/* @var $model ParentsPupils */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_parents_pupils'); ?>
		<?php echo $form->textField($model,'id_parents_pupils'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_parents'); ?>
		<?php echo $form->textField($model,'id_parents'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_pupil'); ?>
		<?php echo $form->textField($model,'id_pupil'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->